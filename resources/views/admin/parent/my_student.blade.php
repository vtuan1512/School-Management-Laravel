@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Parent Student List ({{$getParent->name }} {{$getParent->last_name }})</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title"> Search Student </h3>
        </div>
        <form method="GET" action="">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label>Student ID</label>
                        <input type="text" class="form-control" name="id" value="{{ Request::get('id')}}" placeholder="Enter Student ID">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ Request::get('name')}}" placeholder="Enter name">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="{{ Request::get('last_name')}}" placeholder="Last name">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Email address</label>
                        <input type="text" class="form-control" name="email" value="{{ Request::get('email')}}" placeholder="Enter email">
                    </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                        <a href="{{url('admin/parent/my-student/'.$parent_id)}}" class="btn btn-success" style="margin-top: 30px;">Clear</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('message')
                    @if(!empty($getSearchStudent))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Student List </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile Pic</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Parent Name</th>
                                        <th>Created Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getSearchStudent as $index => $record)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if(!empty($record->getProfile()))
                                            <img src="{{ $record->getProfile()}}" style="height: 80px; width:80px; border-radius: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $record->name }} {{ $record->last_name }}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->parent_name }}</td>
                                        <td>{{ date('d-m-Y H:i A',strtotime( $record->created_atKO)) }}</td>
                                        <td style="min-width: 150px;">
                                            <a href="{{ url('admin/parent/assign_student_parent/'.$record->id.'/'.$parent_id) }}" class="btn btn-primary btn-sm">Add Student to Parent</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Parent Student List </h3>
                        </div>
                        <div class="card-body p-0">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile Pic</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        
                                        <th>Created Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $index => $record)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if(!empty($record->getProfile()))
                                            <img src="{{ $record->getProfile()}}" style="height: 80px; width:80px; border-radius: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $record->name }} {{ $record->last_name }}</td>
                                        <td>{{ $record->email }}</td>
                                     
                                        <td>{{ date('d-m-Y H:i A',strtotime( $record->created_atKO)) }}</td>
                                        <td style="min-width: 150px;">
                                            <a href="{{ url('admin/parent/assign_student_parent_delete/'.$record->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection