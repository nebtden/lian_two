@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')

@stop

@section('content')
    <div class="row">
        {{--普通经销商--}}

        <div class="col-12">
            <div class="col-12">
                @if(Auth::user()->status==1)
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">通知！</h3>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">



                    </div>
                    <!-- /.card-body -->
                </div>
                @endif

            </div>

        </div>


    </div>
@stop

@section('js')


@stop
