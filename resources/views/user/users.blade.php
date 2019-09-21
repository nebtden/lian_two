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
                    <h3 class="card-title">我推荐的下级渠道商</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th  >ID
                                        </th>
                                        <th >姓名
                                        </th>
                                        <th >手机号码

                                        </th>
                                        <th >创建时间
                                        </th>
                                        <th >本月成交
                                        </th>
                                        </th>
                                        <th >状态
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{ substr($user->phone,0,9).'**' }}</td>

                                        <td>{{$user->created_at}}</td>
                                        <td>{{$user->client_count}}</td>
                                        <td>{{$status[$user->status]}}</td>
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
                                    {{ $users->links() }}

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
    <script src="/vendor/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="/vendor/adminlte/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/vendor/adminlte/plugins/datatables/dataTables.bootstrap4.js"></script>
@stop

@section('js')
@section('js')
<script>
    $('#example1').DataTable({
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

@stop
