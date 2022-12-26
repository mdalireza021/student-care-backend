@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        {{-- <img class="img-fluid" src="{{ asset('assets/logo-white.png') }}" alt="Logo">--}}
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Login</h1>
                            <p class="account-subtitle">Access to our dashboard</p>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" name="email" type="text" placeholder="Email" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="password" type="password" placeholder="Password" value="" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                            </form>

                            <div class="text-center forgotpass">
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>

                            {{-- <div class="text-center dont-have">Don’t have an account? <a href="{{ url('register') }}">Register</a></div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/auth.js') }}"></script>
@endsection
