@extends('layouts.admin.master')
@section('pageTitle', 'Gender Add')
@section('pageHeader', 'Gender')
@section('content')
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">@yield('pageTitle')</h3>

        <div class="card-tools">
            <a href="{{ route('admin.genders') }}" class="btn btn-success"><i class="fas fa-arrow-circle-left"></i> Back</a>
        </div>
    </div>
    <!-- /.card-header -->
    <form role="form" action="{{ route('admin.gender-store') }}" method="POST">
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
                        @error('name') <div class="input-error"><i class="icon fas fa-exclamation-triangle"></i> {{ $message }} </div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2" style="width: 100%;">
                            <option>Choose Status</option>
                            <option value="0">In-Active</option>
                            <option value="1">Active</option>
                        </select>
                        @error('status') <div class="input-error"><i class="icon fas fa-exclamation-triangle"></i> {{ $message }} </div> @enderror
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ __('common.save') }}  <i class="fas fa-save"></i></button>
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
    </form>

</div>
@endsection
