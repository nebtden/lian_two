@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>信息修改</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">请输入意向客户详细信息</div>
                @if(session()->has('setting_status'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! session('setting_status') !!}</strong>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">

                    <form  method="POST" action="{{ url('/user/client/'.$client->id) }}">
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="id" value="{{$client->id}}" >

                        @csrf

                        <div class="form-group">
                            <label for="name"  >状态</label>

                            <div class="col-md-6">
                                <select name="status">
                                    @foreach($statuses as $key=>$status)
                                        <option value="{{$key}}">{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name"  >备注(便于自己查看)</label>

                            <div class="col-md-6">
                                <textarea name="remark" class="form-control" rows="5"> {{old('remark')??$client->remark}}</textarea>

                            </div>
                        </div>



                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
