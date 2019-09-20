@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ config('app.name', 'Laravel') }}</div>

                    <div class="card-body">
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                   <a href="/login">登录</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
