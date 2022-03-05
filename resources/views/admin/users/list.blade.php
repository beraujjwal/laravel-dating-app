@extends('layouts.admin.master')
@section('pageTitle', 'Users List')
@section('pageHeader', 'Users')
@section('activeMenu', 'users')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">@yield('pageTitle')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <div class="flash-message">
                    @include('layouts.admin.includes.flash')
                </div>
                    <table id="datas-list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Provider</th>
                                <th>Created At</th>
                                <th width="110">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($users) > 0)
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->status == 1)
                                                <i class="fas fa-lightbulb" style="color:green;"></i>
                                            @else
                                                <i class="fas fa-lightbulb" style="color:red;"></i>
                                            @endif
                                        </td>
                                        <td>{{ $user->provider }}</td>
                                        <td>{{ date( 'd/m/Y', strtotime($user->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('admin.user-edit', ['user' => $user->id]) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <span class="button-divider">|</span>
                                            <form action="{{ route('admin.user-delete', ['user' => $user->id]) }}" method="POST" class="delete-form" style="float:right;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="delete-form-button" style="float:left; display:inline-block; border:none; color:red;">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button >
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="6">No user found!</td></tr>
                            @endif                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Provider</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection