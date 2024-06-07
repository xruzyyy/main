@extends('layouts.app')

@section('content')
<style>
    .authentication-card {
        animation: fadeIn 0.5s ease-in-out;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-family: Helvetica, Arial, sans-serif; /* Added font-family */
        background: #fff; /* Added background color */
        margin: 0 auto; /* Moved margin to the container */
        max-width: 650px; /* Adjusted max-width */
        border-top: 1px solid #ddd; /* Added border top */
        border-bottom: 1px solid #ddd; /* Added border bottom */
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Additional styles */
    .card-header {
        background-color: #6759fb; /* Changed card header background color */
        color: #fff; /* Changed card header text color */
        border-radius: 10px 10px 0 0; /* Rounded top corners */
        padding: 15px; /* Added padding */
    }

    .card-body {
        text-align: center; /* Center-align card body content */
    }

    .btn-primary {
        background-color: #6759fb; /* Changed primary button background color */
        color: #fff; /* Changed primary button text color */
        border-radius: 10px; /* Rounded button corners */
        padding: 15px 30px; /* Added padding */
        text-decoration: none; /* Removed underline */
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card authentication-card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p>{{ __('Before proceeding, please check your email for a verification link,open the link at the same browser') }}</p>
                    <p>{{ __('If you did not receive the email') }},</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('Click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
