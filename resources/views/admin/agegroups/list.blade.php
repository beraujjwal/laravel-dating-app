@extends('layouts.admin.master')
@section('pageTitle', 'Age Groups List')
@section('pageHeader', 'Age Groups')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('pageTitle')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.agegroup-add') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add New</a>
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
                                <th>Gender</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th width="110">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($agegroups) > 0)
                                @foreach($agegroups as $agegroup)                                    
                                    <tr>
                                        <td>{{ $agegroup->gender->name }}</td>
                                        <td>{{ $agegroup->min }}</td>
                                        <td>{{ $agegroup->max }}</td>
                                        <td>{{ $agegroup->group }}</td>
                                        <td>
                                            @if($agegroup->status == 1)
                                                <i class="fas fa-lightbulb" style="color:green;"></i>
                                            @else
                                                <i class="fas fa-lightbulb" style="color:red;"></i>
                                            @endif
                                        </td>
                                        <td>{{ date( 'd/m/Y', strtotime($agegroup->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('admin.agegroup-edit', ['agegroup' => $agegroup->id]) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <span class="button-divider">|</span>
                                            <form action="{{ route('admin.agegroup-delete', ['agegroup' => $agegroup->id]) }}" method="POST" class="delete-form" style="float:right;">
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
                                <tr><td colspan="4">No age group found!</td></tr>
                            @endif                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Gender</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Group</th>
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