@extends('layouts.admin.master')
@section('pageTitle', 'Profession Add')
@section('pageHeader', 'Profession')
@section('content')
<div class="card card-default">
    <div class="card-header">
    <h3 class="card-title">@yield('pageTitle')</h3>

        <div class="card-tools">
            <a href="{{ route('admin.professions') }}" class="btn btn-success"><i class="fas fa-arrow-circle-left"></i> Back</a>
        </div>
    </div>
    <!-- /.card-header -->
    <form role="form" action="{{ route('admin.profession-store') }}" method="POST">
        <div class="flash-message">
            @include('layouts.admin.includes.flash')
        </div>
        @csrf
        <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name"
                            value="{{ old('name') }}">
                    @error('name') <div class="input-error"> {{ $message }} </div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control select2" style="width: 100%;">
                        <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Save <i class="fas
                fa-arrow-circle-right"></i></button>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
    </form>
    <!-- /.row -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
    the plugin.
    </div>
</div>
@endsection