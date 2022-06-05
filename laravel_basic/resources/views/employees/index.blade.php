@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Employees') }}</div>
                <div class="card-body">
                    <a href="employees/add" class="btn btn-primary">
                        Add Employees
                    </a>
                    <a href="employees/import" class="btn btn-success">
                        Import Employees
                    </a>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-xl-2">Name</th>
                                <th scope="col" class="col-xl-2">Email</th>
                                <th scope="col" class="col-xl-2">Balance</th>
                                <th scope="col" class="col-xl-2">Company</th>
                                <th scope="col" class="col-xl-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee['name'] }}</td>
                                    <td>{{ $employee['email'] }}</td>
                                    <td>{{ $employee['balance'] }}</td>
                                    <td>{{ $employee['company']['name'] }}</td>
                                    <td>
                                        <a href="employees/edit/{{ $employee['id'] }}" target="_blank" class="btn btn-warning">
                                            Edit
                                        </a>

                                        <button class="btn btn-danger" id="btn-delete" onclick="deleteAction({{ $employee['id'] }})">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $employees->links() }}
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
                url: "{{ url('api/employees/delete') }}",
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
                    setTimeout(function(){ window.location = "{{ url('employees') }}"; }, 1000);
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
