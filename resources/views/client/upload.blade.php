@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>客户信息批量上传</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">请按要求下载>>><a href="/excel/userclients.xlsx" style="color: #9f105c" >模板</a>后，再导入</div>
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

                    <form  method="post" action="{{ url('/user/client/save') }}" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group">

                            <div class="col-md-6">
                                <input id="file" type="file"   class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file')?? '' }}" required  >

                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
