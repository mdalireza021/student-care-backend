@extends('layouts.app')

@section('content')
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="assets/img/logo-white.png" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Register</h1>
                            <p class="account-subtitle">Access to our dashboard</p>

                            <form action="login.html">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Confirm Password">
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block" type="submit">Register</button>
                                </div>
                            </form>

                            <div class="login-or">
                                <span class="or-line"></span>
                            </div>

                            <div class="text-center dont-have">Already have an account? <a href="login.html">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
