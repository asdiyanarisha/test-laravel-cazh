@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Transactions') }}</div>

                <div class="card-body">
                    <form id="add-transaction-form" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Company') }}</label>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id='input-company_id' class="select2 form-control" name="company_id" style="200px">
                                        <option value="">- Search Company -</option>
                                    </select>

                                    <span id="span-company_id" class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Employee') }}</label>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id='input-employee_id' class="select2 form-control" name="employee_id" style="200px">
                                        <option value="">- Search Employee -</option>
                                    </select>

                                    <span id="span-employee_id" class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Balance') }}</label>

                            <div class="col-md-6">
                                <input id="input-balance" type="text" class="form-control" name="balance" value="{{ old('balance') }}" autofocus>

                                <span id="span-balance" class="invalid-feedback" role="alert"></span>
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
            placeholder: 'Search for a company',
            templateResult: formatCompany,
            templateSelection: formatCompanySelection
        });

        $("#input-employee_id").select2({
            // width: '350px',
            ajax: {
                url: '/api/employees/paginate',
                type: 'POST',
                dataType: 'json',
                delay: 250,
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer {{ Auth::user()->remember_token }}");
                },
                data: function(params) {
                    query = {
                        "term": params.term || '',
                        "company_id": $("#input-company_id").val() 
                    }
                    return {
                        q: query,
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
            placeholder: 'Search for a employee',
            templateResult: formatCompany,
            templateSelection: formatCompanySelection
        });

        $('#input-company_id').on('change', function () {
            $('#input-employee_id').val(null).trigger('change');
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
        const form_data = new FormData(document.getElementById("add-transaction-form"));

        $.ajaxSetup({
            headers: {
                'Authorization': "Bearer {{ Auth::user()->remember_token }}"
            }
        });

        $.ajax({
            url: "{{ url('api/transaction/insert') }}",
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
                setTimeout(function(){ window.location = "{{ url('transaction') }}"; }, 1000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    validateError(xhr.responseJSON);
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: xhr.responseJSON.msg + ' !!!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>
@endsection
