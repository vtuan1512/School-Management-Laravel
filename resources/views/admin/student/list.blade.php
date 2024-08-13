@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student List (Total: {{ $getRecords->total() }})</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{url('admin/student/add')}}" class="btn btn-primary">Add New Student</a>
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
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title"> Search Student </h3>
                        </div>
                        <form method="GET" action="">
                            <div class="card-body">
                                <div class="row">
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
                                    <div class="form-group col-md-2">
                                        <label> Admission Number</label>
                                        <input type="text" class="form-control" name="admission_number" value="{{ Request::get('admission_number')}}" placeholder="Enter admission number">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Roll Number</label>
                                        <input type="text" class="form-control" name="roll_number" value="{{ Request::get('roll_number')}}" placeholder="Enter roll number">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Class</label>
                                        <input type="text" class="form-control" name="class" value="{{ Request::get('class')}}" placeholder="Enter Class">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="">Select Gender</option>
                                            <option {{(Request::get('gender')=='Male')?'selected':''}} value="Male">Male</option>
                                            <option {{(Request::get('gender')=='Female')?'selected':''}} value="Female">Female</option>
                                            <option {{(Request::get('gender')=='Other')?'selected':''}} value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Caste</label>
                                        <input type="text" class="form-control" name="caste" value="{{ Request::get('caste')}}" placeholder="Enter caste">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Religion</label>
                                        <input type="text" class="form-control" name="religion" value="{{ Request::get('religion')}}" placeholder="Enter religion">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile_number" value="{{ Request::get('mobile_number')}}" placeholder="Enter mobile number">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Blood Group</label>
                                        <input type="text" class="form-control" name="blood_group" value="{{ Request::get('blood_group')}}" placeholder="Enter Blood Group">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Height</label>
                                        <input type="text" class="form-control" name="height" value="{{ Request::get('height')}}" placeholder="Enter height">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Weight</label>
                                        <input type="text" class="form-control" name="weight" value="{{ Request::get('weight')}}" placeholder="Enter Weight">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Select Status</option>
                                            <option {{( Request::get('status')==0)?'selected':''}} value="0">Active</option>
                                            <option {{( Request::get('status')==1)?'selected':''}} value="1">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Admission Date</label>
                                        <input type="date" class="form-control" name="admission_date" value="{{ Request::get('admission_date')}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                        <a href="{{url('admin/student/list')}}" class="btn btn-success" style="margin-top: 30px;">Clear</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @include('message')

                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Student List </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="overflow: auto;">
                            @if($getRecords->isEmpty())
                            <p class="text-center" style="color: red;">No data found</p>
                            @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Parent Name</th>
                                        <th>Email</th>
                                        <th>Admission Number</th>
                                        <th>Roll Number</th>
                                        <th>Class</th>
                                        <th>Gender</th>
                                        <th>Date of Birth</th>
                                        <th>Caste</th>
                                        <th>Religion</th>
                                        <th>Mobile Number</th>
                                        <th>Admission Date</th>
                                        <th>Blood Group</th>
                                        <th>Height</th>
                                        <th>Weight</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecords as $index => $record)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if(!empty($record->getProfile()))
                                            <img src="{{ $record->getProfile()}}" style="height: 80px; width:80px; border-radius: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $record->name }} {{ $record->last_name }}</td>
                                        <td>{{ $record->parent_name }} {{ $record->parent_last_name }}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->admission_number }}</td>
                                        <td>{{ $record->roll_number }}</td>
                                        <td>{{ $record->class_name }}</td>
                                        <td>{{ $record->gender }}</td>
                                        <td>
                                            @if(!empty($record->date_of_birth))
                                            {{ date('d-m-Y', strtotime($record->date_of_birth)) }}
                                            @endif
                                        </td>
                                        <td>{{ $record->caste }}</td>
                                        <td>{{ $record->religion }}</td>
                                        <td>{{ $record->mobile_number }}</td>
                                        <td>
                                            @if(!empty($record->admission_date))
                                            {{ date('d-m-Y', strtotime($record->admission_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ $record->blood_group }}</td>
                                        <td>{{ $record->height }}</td>
                                        <td>{{ $record->weight }}</td>
                                        <td>{{ ($record->status==0)?'Active':'Inactive' }}</td>
                                        <td>{{ date('d-m-Y H:i A',strtotime( $record->created_atKO)) }}</td>
                                        <td style="min-width: 150px;">
                                            <a href="{{ url('admin/student/edit/'.$record->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ url('admin/student/delete/'.$record->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="padding: 10px; float:right;">
                                {!! $getRecords->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection