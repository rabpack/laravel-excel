@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header text-right">لیست کارمندان</div>
                <div class="card-body">
                    <a href="{{ route('employee.download') }}" class="btn btn-primary">دانلود اکسل</a>
                    <br><br>
                    @include('employee.table', $employees)
                </div>
            </div>
        </div>
    </div>
@endsection
