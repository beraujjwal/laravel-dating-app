@extends('layouts.admin.master')
@section('pageTitle', 'Gender Edit')
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
    <form role="form" action="{{ route('admin.gender-update', ['gender' => $gender->id]) }}" method="POST">
        <div class="flash-message">
            @include('layouts.admin.includes.flash')
        </div>
        @csrf
        <div class="card-body">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Gender name"
                              value="{{ old('name', $gender->name) }}">
                      @error('name') <div class="input-error"> {{ $message }} </div> @enderror
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group">
                      <label>Slug</label>
                      <input type="text" name="slug" class="form-control" placeholder="Gender slug"
                              value="{{ old('slug', $gender->slug) }}">
                      @error('slug') <div class="input-error"> {{ $message }} </div> @enderror
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control select2" style="width: 100%;">
                          <option value="0" @if(old('status', $gender->status) == '0') selected @endif>In-Active</option>
                          <option value="1" @if(old('status', $gender->status) == '1') selected @endif>Active</option>
                      </select>
                  </div>
              </div>

          </div>


      <!-- /.row -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          <button type="submit" class="btn btn-success">Update  <i class="fas fa-save"></i></button>
          <button type="reset" class="btn btn-default float-right">Cancel</button>
      </div>
    </form>
</div>
@endsection
