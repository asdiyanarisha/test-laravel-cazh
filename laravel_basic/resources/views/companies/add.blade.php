@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Companies') }}</div>

                <div class="card-body">
                    <form id="add-companies-form" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="input-name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                <span id="span-name" class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="input-email" type="text" class="form-control" name="email" value="{{ old('email') }}">

                                <span id="span-email" class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Balance') }}</label>

                            <div class="col-md-6">
                                <input id="input-balance" type="text" class="form-control" name="balance" value="{{ old('balance') }}" autofocus>

                                <span id="span-balance" class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Logo') }}</label>

                            <div class="col-md-6">
                                <input id="input-logo" type="file" class="form-control" name="logo" autofocus>

                                <span id="span-logo" class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Website') }}</label>

                            <div class="col-md-6">
                                <input id="input-website" type="text" class="form-control" name="website" value="{{ old('website') }}" autofocus>

                                <span id="span-website" class="invalid-feedback" role="alert"></span>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/handleRequest.js') }}"></script>
<script>
    $(':input').on('keyup', function () {
        const is_invalid_element = document.querySelectorAll('.is-invalid');
        is_invalid_element.forEach(box => {
          box.classList.remove("is-invalid");
        });
    });

    $('#button-submit').on('click', function () {
        const form_data = new FormData(document.getElementById("add-companies-form"));

        $.ajaxSetup({
            headers: {
                'Authorization': "Bearer {{ Auth::user()->remember_token }}"
            }
        });

        $.ajax({
            url: "{{ url('api/companies/insert') }}",
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
                setTimeout(function(){ window.location = "{{ url('api/companies') }}"; }, 1000);
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
