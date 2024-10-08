@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assign Class Teacher </h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{url('admin/assign_class_teacher/add')}}" class="btn btn-primary">Add New Assign Class Teacher</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">
                    @include('message')

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title"> Search Assign Class Teacher </h3>
                        </div>
                        <form method="GET" action="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label>Class Name</label>
                                        <input type="text" class="form-control" name="class_name" value="{{ Request::get('class_name')}}" placeholder="Class name">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Teacher Name</label>
                                        <input type="text" class="form-control" name="teacher_name" value="{{ Request::get('teacher_name')}}" placeholder="Subject name">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Select Class</option>
                                            <option {{(Request::get('status')==100)?'selected':''}} value="100">Active</option>
                                            <option {{(Request::get('status')==1)?'selected':''}} value="1">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                        <a href="{{url('admin/assign_class_teacher/list')}}" class="btn btn-success" style="margin-top: 30px;">Clear</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Assign Class Teacher List </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            @if($getRecord->isEmpty())
                            <p class="text-center" style="color: red;">No data found</p>
                            @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Class Name</th>
                                        <th>Teacher Name</th>
                                        <th>Status</th>
                                        <th>Create By</th>
                                        <th>Created Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $index =>$value)
                                    <tr>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{$value->class_name}}</td>
                                        <td>{{$value->teacher_name}} {{$value->teacher_last_name}}</td>
                                        <td>@if($value->status==0) Active @else Inactive @endif</td>
                                        <td>{{$value->created_by_name}}</td>
                                        <td>{{date('d-m-Y H:i A', strtotime($value->created_at))}}</td>
                                        <td>
                                            <a href="{{ url('admin/assign_class_teacher/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ url('admin/assign_class_teacher/edit_single/'.$value->id) }}" class="btn btn-warning">Edit Single</a>
                                            <a href="{{ url('admin/assign_class_teacher/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div style="padding: 10px; float:right;">
                                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                            </diV>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection