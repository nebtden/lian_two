@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>个人设置</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            {{--            <div class="card card-warning">--}}
            {{--                <div class="card-header">--}}
            {{--                    <h3 class="card-title">您的推广链接</h3>--}}
            {{--                    <!-- /.card-tools -->--}}
            {{--                </div>--}}
            {{--                <!-- /.card-header -->--}}
            {{--                <div class="card-body">--}}
            {{--                    <label>复制下面链接，邀请供应商注册成为您的代理！</label>--}}
            {{--                    <div class="form-group">--}}
            {{--                       <input type="text" readonly value="{{ $invitation }}" class="form-control">--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <!-- /.card-body -->--}}
            {{--            </div>--}}
            <div class="card card-primary">
                @if(session()->has('setting_status'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! session('setting_status') !!}</strong>
                    </div>
                @endif
                @error('password')
                <span class="alert alert-error alert-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror

            <!-- form start -->
                <form role="form" method="post" action="{{ url('/user/setting') }}" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">真实姓名</label>
                            <input type="text" class="form-control" name="name" value="{{$user->name}}" id="name" placeholder="请输入真实姓名，便于打款" style="">
                        </div>
                        @if(Auth::user()->type!=4)
                        <div class="form-group">
                            <label for="card_number">银行账号</label>
                            <input type="text" class="form-control" name="card_number" value="{{$user->card_number}}"  id="card_number" placeholder="请输入完整账号" style="">
                        </div>
                        <div class="form-group">
                            <label for="bank_name">银行名(请详细到支行)</label>
                            <input type="text" class="form-control" name="bank_name" value="{{$user->bank_name}}" id="bank_name" placeholder="比如建设银行五一支行、招商银行树木岭支行" style="">
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="password">新密码</label>

                            <input type="password" class="form-control" name="password" value="" id="password" placeholder="如需修改密码，请填写新密码，否则留空" style="">


                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">确认密码</label>
                            <input type="password" class="form-control" name="password_confirmation" value="" id="password_confirmation" placeholder="请保证和上面密码一致" style="">
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </form>
            </div>
            @if((Auth::user()->type==1 or Auth::user()->type==3) && $settings['top_is_open'])
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">您的专属客服经理：</h3>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>姓名：{{ $top?$top['name']:'' }}</p>
                        <p>电话：{{ $top?$top['phone']:'' }}</p>
                    </div>
                    <!-- /.card-body -->
                </div>
        @endif
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/vendor/adminlte/plugins/datatables/dataTables.bootstrap4.css">
    <script src="/vendor/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="/vendor/adminlte/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/vendor/adminlte/plugins/datatables/dataTables.bootstrap4.js"></script>
@stop

@section('js')
    <script> console.log('Hi!'); </script>

@stop
