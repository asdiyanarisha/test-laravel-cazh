@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Employees') }}</div>

                <div class="card-body">
                    <form id="edit-employees-form" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <input type="hidden" name="id" value="{{ $employee['id'] }}">

                            <div class="col-md-6">
                                <input value="{{ $employee['name'] }}" id="input-name" type="text" class="form-control" name="name" autofocus>

                                <span id="span-name" class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="input-email" type="text" class="form-control" name="email" value="{{ $employee['email'] }}">

                                <span id="span-email" class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Balance') }}</label>

                            <div class="col-md-6">
                                <input id="input-balance" type="text" class="form-control" name="balance" value="{{ $employee['balance'] }}" autofocus>

                                <span id="span-balance" class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Company') }}</label>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id='input-company_id' class="select2 form-control" name="company_id" style="200px">
                                        <option value="{{ $employee['company']['id'] }}" selected="selected">{{ $employee['company']['name'] }}</option>
                                    </select>

                                    <span id="span-company_id" class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" id="button-submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/handleRequest.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#input-company_id").select2({
            // width: '350px',
            ajax: {
                url: '/api/companies/paginate',
                type: 'POST',
                dataType: 'json',
                delay: 250,
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer {{ Auth::user()->remember_token }}");
                },
                data: function(params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function(data, params) {
                    params.current_page = params.current_page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: (params.current_page * 30) < data.total
                        }
                    };
                },
                cache: true
            },
            templateResult: formatCompany,
            templateSelection: formatCompanySelection
        });

        function formatCompany(company) {
            if (company.loading) {
                return company.name;
            }

            var $container = $(
                "<div class='select2-result-product clearfix'>" +
                "<div class='select2-result-product__title'></div>" +
                "</div>"
            );

            $container.find(".select2-result-product__title").text(company.name);

            return $container;
        }

        function formatCompanySelection(company) {
            return company.name || company.id;
        }
    });


    $(':input').on('keyup', function () {
        const is_invalid_element = document.querySelectorAll('.is-invalid');
        is_invalid_element.forEach(box => {
          box.classList.remove("is-invalid");
        });
    });

    $('#button-submit').on('click', function () {
        const form_data = new FormData(document.getElementById("edit-employees-form"));

        $.ajaxSetup({
            headers: {
                'Authorization': "Bearer {{ Auth::user()->remember_token }}"
            }
        });

        $.ajax({
            url: "{{ url('api/employees/change') }}",
            type: 'POST',
            data: form_data,
            success: function () {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'That data have been inserted !!!',
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout(function(){ window.location = "{{ url('employees') }}"; }, 1000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    validateError(xhr.responseJSON);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>
@endsection
