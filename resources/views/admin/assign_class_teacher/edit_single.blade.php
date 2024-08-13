@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Assign Class Teacher</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="POST" action="">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Class Name</label>
                                    <select class="form-control" name="class_id">
                                        <option value="">Select Class</option>
                                        @foreach($getClass as $class)
                                        <option {{($getRecord->class_id==$class->id) ? 'selected' : ''}} value="{{$class->id }}">{{ $class->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Teacher Name</label>
                                    <select class="form-control" name="teacher_id">
                                        <option value="">Select Class</option>
                                        @foreach($getTeacher as $teacher)
                                        <option {{($getRecord->teacher_id==$teacher->id) ? 'selected' : ''}} value="{{$teacher->id }}">{{ $teacher->name }} {{ $teacher->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option {{($getRecord->status==0) ? 'selected' : ''}} value="0">Active</option>
                                        <option {{($getRecord->status==1) ? 'selected' : ''}} value="1">Inactive</option>
                                    </select>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection