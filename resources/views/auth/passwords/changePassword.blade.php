@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تعویض گذرواژه</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('change.password') }}" id="change_pass_form">
                        @csrf

                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">گذرواژه فعلی</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password" required
                                data-parsley-required-message="لطفا گذرواژه فعلی خود را وارد کنید!">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">گذرواژه جدید</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password" required
                                data-parsley-trigger="keyup"
                                data-parsley-trigger-after-failure="keyup"
                                data-parsley-minlength="8"
{{--                                       data-parsley-errors-container="#editErrorBox"--}}
                                data-parsley-required-message="لطفا گذرواژه جدید خود را وارد کنید!"

                                data-parsley-required
                                >

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">تکرار گذرواژه جدید</label>

                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password" required
                                data-parsley-trigger="keyup"
                                data-parsley-trigger-after-failure="keyup"
                                data-parsley-minlength="8"
{{--                                       data-parsley-errors-container="#editErrorBox"--}}
                                data-parsley-required-message="لطفا گذرواژه جدید خود را دوباره وارد کنید!"
                                data-parsley-equalto="#password"
                                data-parsley-required
                                >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    ذخیره تغییرات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#change_pass_form').parsley();
    });

</script>
@endsection
