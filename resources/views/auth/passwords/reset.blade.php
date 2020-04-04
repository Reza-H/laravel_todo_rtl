@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('تعویض گذرواژه') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}" id="restPassForm">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('پست الکترونیکی') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                       data-parsley-trigger="keyup"
                                       data-parsley-trigger-after-failure="keyup"
                                       data-parsley-type="email"
                                       data-parsley-required-message="<span style='display:inline-block;margin-top: 5px'>لطفا ایمیل خود را وارد کنید!</span>"
                                >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('گذرواژه') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
                                       data-parsley-trigger="keyup"
                                       data-parsley-trigger-after-failure="keyup"
                                       data-parsley-minlength="8"
                                       data-parsley-errors-container="#editErrorBox"
                                       data-parsley-required-message="لطفا پسورد خود را وارد کنید!"
                                       data-parsley-uppercase="1"
                                       data-parsley-lowercase="1"
                                       data-parsley-number="1"
                                       data-parsley-special="1"
                                       data-parsley-required
                                >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('تاییدگذرواژه') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"
                                       data-parsley-trigger="keyup"
                                       data-parsley-trigger-after-failure="keyup"
                                       data-parsley-minlength="8"
                                       data-parsley-errors-container="#editErrorBox"
                                       data-parsley-required-message="لطفا گذرواژه خود را دوباره وارد کنید!"
                                       data-parsley-equalto="#password"
                                       data-parsley-required
                                >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('تعویز گذرواژه') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
    <script>
        $(document).ready(function () {
            $('#restPassForm').parsley();
        })
    </script>
@endsection
