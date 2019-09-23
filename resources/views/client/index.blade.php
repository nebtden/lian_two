@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{--<h1>Dashboard</h1>--}}
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">客户信息</h3>
                    <div class="card-tools">

                    </div>
                </div>
                @if(session()->has('setting_status'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! session('setting_status') !!}</strong>
                    </div>
            @endif

            <!-- /.card-header -->
                <div class="card-body">
                    <div   class="dataTables_wrapper dt-bootstrap4">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="client_index" class="table table-bordered table-hover" role="grid" >
                                    <thead>
                                    <tr role="row">

                                        <th>姓名</th>
                                        <th>手机号码 </th>
                                        <th>状态</th>
                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clients as $client)
                                        <tr role="row" class="odd">

                                            <td>{{$client->client->user_name}}</td>
                                            <td class="phone">{{\App\Logic\Lian::HandleClientPhone($client)}}</td>
                                            <td>{{$status[$client->status]}}</td>
                                            <td>{{$client->created_at}}</td>
                                            <td>
                                                <a class="client_accept" data-id="{{$client->id}}">接收</a>
                                                <a href="{{ url('/user/client/'.$client->id.'/edit') }}">编辑</a></td>
                                        </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    总共 {{ $total }}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                    {{ $clients->links() }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/vendor/adminlte/plugins/datatables/dataTables.bootstrap4.css">

@stop

@section('js')
    <script src="/js/lian/accept.js"></script>
    <script>
        $('#client_index').DataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bAutoWidth": false,
            "bInfo" : false,
            "paging": false,
            "ordering": false,
            "searching": false,
            "autoWidth": false,
            "scrollX": true ,
        });
    </script>

@stop
