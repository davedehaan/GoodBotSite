@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data" aria-label="{{ __('Upload') }}">
                        @csrf
                        <div class="form-group row">
                            <label>Server ID</label>
                            <div class="col-md-6">
                                <input id="server_id" type="text" class="form-control{{ $errors->has('server_id') ? ' is-invalid' : '' }}" name="server_id" value="{{ $id }}" required>
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br />
                        <div class="form-group row">
                            <label>EPGP File</label>
                            <div class="col-md-6">
                                @if ($path)
                                <input value="{{ $path }}" class="form-control" onclick="this.select();" />
                                <br />
                                <br />
                                @endif
                                <input id="file" type="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" value="{{ $path }}" required>
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br />
                        <br />
                        <br />
                        <div class="form-group row mt-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
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