@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>
                <div class="card-body">
                    <a href="companies/add" class="btn btn-primary">
                        Add Companies
                    </a>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-xl-2">Logo</th>
                                <th scope="col" class="col-xl-2">Name</th>
                                <th scope="col" class="col-xl-2">Email</th>
                                <th scope="col" class="col-xl-2">Website</th>
                                <th scope="col" class="col-xl-2">Balance</th>
                                <th scope="col" class="col-xl-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <th scope="row">
                                        <img src="company/{{ $company['logo'] }}" class="img-fluid img-thumbnail" alt="...">
                                    </th>
                                    <td>{{ $company['name'] }}</td>
                                    <td>{{ $company['email'] }}</td>
                                    <td>{{ $company['website'] }}</td>
                                    <td>{{ $company['balance'] }}</td>
                                    <td>
                                        <a href="companies/edit/{{ $company['id'] }}" target="_blank" class="btn btn-warning">
                                            Edit
                                        </a>

                                        <button class="btn btn-danger" id="btn-delete" onclick="deleteAction({{ $company['id'] }})">
                                            Delete
                                        </button>
                                        
                                        <a href="companies/pdf/{{ $company['id'] }}" target="_blank" class="btn btn-info mt-1">
                                            Export Employees
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        function deleteAction(id) {
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ Auth::user()->remember_token }}"
                }
            });

            $.ajax({
                url: "{{ url('api/companies/delete') }}",
                type: 'POST',
                data: {
                    id: id,
                },
                success: function () {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'That data have been deleted !!!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(function(){ window.location = "{{ url('companies') }}"; }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        validateError(xhr.responseJSON);
                    }
                }
            });
        }
    </script>
@endsection
