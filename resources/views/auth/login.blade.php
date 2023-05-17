
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <form method="POST" action="{{route('login')}}">
                    @csrf
                    <div class="row justify-content-center mt-3 mb-2">
                        <div class="col-md-10">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username"/>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-10">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-10 mb-4">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
