@extends('layouts.admin.master')
@section('pageTitle', 'Users List')
@section('pageHeader', 'Users')
@section('activeMenu', 'users')
@section('content')
<div class="card card-default">
    <div class="card-header">
    <h3 class="card-title">@yield('pageTitle')</h3>

        <div class="card-tools">
            <a href="{{ route('admin.users') }}" class="btn btn-success"><i class="fas fa-arrow-circle-left"></i> Back</a>
        </div>
    </div>
    <!-- /.card-header -->
    <form role="form" action="{{ route('admin.user-update', ['user' => $user->id]) }}" method="POST">
        <div class="flash-message">
            @include('layouts.admin.includes.flash')
        </div>
        @csrf
        <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="User Name"
                            value="{{ old('name', $user->name) }}">
                    @error('name') <div class="input-error"> {{ $message }} </div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="User Phone number"
                            value="{{ old('phone', $user->phone) }}">
                    @error('phone') <div class="input-error"> {{ $message }} </div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="User EmailId"
                            value="{{ old('email', $user->email) }}">
                    @error('email') <div class="input-error"> {{ $message }} </div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" class="form-control" placeholder="User Age"
                            value="{{ old('age', $user->age) }}">
                    @error('age') <div class="input-error"> {{ $message }} </div> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control select2" style="width: 100%;">
                        <option value="">Choose gender</option>
                        <option value="1" @if(old('gender', $user->gender_id) == '1') selected @endif>Male</option>
                        <option value="2" @if(old('gender', $user->gender_id) == '2') selected @endif>Female</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control select2" style="width: 100%;">
                        <option value="0" @if(old('status', $user->gender_id) == '0') selected @endif>In-Active</option>
                        <option value="1" @if(old('status', $user->gender_id) == '1') selected @endif>Active</option>
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