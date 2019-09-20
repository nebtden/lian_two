@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('app.name') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.password_reset_message') }}</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ url(config('adminlte.password_code_url', 'password/code')) }}" method="post">
                {!! csrf_field() !!}

                <div class="input-group form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ isset($phone) ? $phone : old('phone') }}"
                           placeholder="请输入您的手机号">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary info" type="button" id="get_code">获取验证码</button>
                    </div>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('code') ? 'has-error' : '' }}">
                    <input type="code" name="code" class="form-control" value="{{ isset($code) ? $code : old('code') }}"
                           placeholder="请输入获取到的验证码">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >提交</button>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    @yield('js')
    <script src="/vendor/adminlte/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#get_code').click(function () {
                var phone = $('#phone').val();
                if(!phone){
                    return false
                }
                $.post('/code',{'phone':phone,"_token": "{{ csrf_token() }}"}, function (data) {
                    alert(data.message)
                },'json')
            });
        });

    </script>
@stop
