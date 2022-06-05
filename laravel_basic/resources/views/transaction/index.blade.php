@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Transactions') }}</div>
                <div class="card-body">
                    <a href="transaction/add" class="btn btn-primary">
                        Add Transactions
                    </a>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-xl-2">Created At</th>
                                <th scope="col" class="col-xl-2">Company</th>
                                <th scope="col" class="col-xl-1">Employee</th>
                                <th scope="col" class="col-xl-1">Balance</th>
                                <th scope="col" class="col-xl-1">Start Balance Company</th>
                                <th scope="col" class="col-xl-1">Last Balance Company</th>
                                <th scope="col" class="col-xl-1">Start Balance Employee</th>
                                <th scope="col" class="col-xl-1">Last Balance Employee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction['created_at'] }}</td>
                                    <td>{{ $transaction['company']['name'] }}</td>
                                    <td>{{ $transaction['employee']['name'] }}</td>
                                    <td>{{ $transaction['balance'] }}</td>
                                    <td>{{ $transaction['company_start_balance'] }}</td>
                                    <td>{{ $transaction['company_last_balance'] }}</td>
                                    <td>{{ $transaction['employee_start_balance'] }}</td>
                                    <td>{{ $transaction['employee_last_balance'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $transactions->links() }}
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
