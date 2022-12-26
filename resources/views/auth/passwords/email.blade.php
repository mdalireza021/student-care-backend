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
                            <h1>Forgot Password?</h1>
                            <p class="account-subtitle">Enter your email to get a password reset link</p>

                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" name="email" type="text" placeholder="Email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                                </div>
                            </form>

                            <div class="text-center dont-have">
                                Remember your password? <a href="{{ url('login') }}">Login</a>
                            </div>
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
