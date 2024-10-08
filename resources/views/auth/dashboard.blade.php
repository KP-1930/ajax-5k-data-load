@extends('auth.layout')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                    <div class="card-header">dashboard</div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection