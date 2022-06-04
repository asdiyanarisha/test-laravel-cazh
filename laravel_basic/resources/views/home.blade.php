@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>

                <div class="card-body">
                    <a href="/companies" class="btn btn-success">To Companies Page</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Employees') }}</div>

                <div class="card-body">
                    <a href="#" class="btn btn-primary">To Employees Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
