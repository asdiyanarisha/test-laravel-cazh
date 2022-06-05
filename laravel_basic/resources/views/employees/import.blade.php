@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Import Employees') }}</div>

                <div class="card-body">
                    <form id="import-employees-form" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Import') }}</label>

                            <div class="col-md-6">
                                <input id="input-file" type="file" class="form-control" name="file" autofocus>

                                <span id="span-file" class="invalid-feedback" role="alert"></span>
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

    $('#button-submit').on('click', function () {
        const form_data = new FormData(document.getElementById("import-employees-form"));

        $.ajaxSetup({
            headers: {
                'Authorization': "Bearer {{ Auth::user()->remember_token }}"
            }
        });

        $.ajax({
            url: "{{ url('api/employees/upload') }}",
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
