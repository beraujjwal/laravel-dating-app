@extends('layouts.admin.master')
@section('pageTitle', 'Genders List')
@section('pageHeader', 'Genders')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('pageTitle')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gender-add') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add New</a>
                    </div>
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
                                <th width="80">Status</th>
                                <th width="80">Created At</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($genders) > 0)
                                @foreach($genders as $gender)
                                    <tr>
                                        <td>{{ $gender->name }}</td>
                                        <td>
                                            @if($gender->status == 1)
                                                <i class="fas fa-lightbulb" style="color:green;"></i> Active
                                            @else
                                                <i class="fas fa-lightbulb" style="color:red;"></i> In-Active
                                            @endif
                                        </td>
                                        <td>{{ date( 'd/m/Y', strtotime($gender->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('admin.gender-edit', ['gender' => $gender->id]) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <span class="button-divider">|</span>
                                            <form action="{{ route('admin.gender-delete', ['gender' => $gender->id]) }}" method="POST" class="delete-form" style="float:right;">
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
                                <tr><td colspan="4">No gender found!</td></tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th width="110">Action</th>
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
