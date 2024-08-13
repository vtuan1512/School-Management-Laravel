@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Teacher List (Total: {{ $getRecords->total() }})</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{url('admin/teacher/add')}}" class="btn btn-primary">Add New Teacher</a>
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
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="">Select Gender</option>
                                            <option {{(Request::get('gender')=='Male')?'selected':''}} value="Male">Male</option>
                                            <option {{(Request::get('gender')=='Female')?'selected':''}} value="Female">Female</option>
                                            <option {{(Request::get('gender')=='Other')?'selected':''}} value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile_number" value="{{ Request::get('mobile_number')}}" placeholder="Enter mobile number">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Marital Status</label>
                                        <input type="text" class="form-control" name="marital_status" value="{{ Request::get('marital_status')}}" placeholder="Enter Marital Status">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Current Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ Request::get('address')}}" placeholder="Enter Address">
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
                                        <label>Date Of Joining</label>
                                        <input type="date" class="form-control" name="admission_date" value="{{ Request::get('admission_date')}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                        <a href="{{url('admin/teacher/list')}}" class="btn btn-success" style="margin-top: 30px;">Clear</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @include('message')

                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Teacher List </h3>
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
                                        <th>Teacher Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Date of Birth</th>
                                        <th>Date of Joining</th>
                                        <th>Mobile Number</th>
                                        <th>Marital Status</th>
                                        <th>Current Address</th>
                                        <th>Permanent Address</th>
                                        <th>Qualification</th>
                                        <th>Work Experience</th>
                                        <th>Note</th>
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
                                            @if(!empty($record->getProfile_Teacher()))
                                            <img src="{{ $record->getProfile_Teacher()}}" style="height: 80px; width:80px; border-radius: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $record->name }} {{ $record->last_name }}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->gender }}</td>
                                        <td>
                                            @if(!empty($record->date_of_birth))
                                            {{ date('d-m-Y', strtotime($record->date_of_birth)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($record->admission_date))
                                            {{ date('d-m-Y', strtotime($record->admission_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ $record->mobile_number }}</td>
                                        <td>{{ $record->marital_status }}</td>
                                        <td>{{ $record->address }}</td>
                                        <td>{{ $record->permanent_address }}</td>
                                        <td>{{ $record->qualification }}</td>
                                        <td>{{ $record->work_experience }}</td>
                                        <td>{{ $record->note }}</td>
                                        <td>{{ ($record->status==0)?'Active':'Inactive' }}</td>
                                        <td>{{ date('d-m-Y H:i A',strtotime( $record->created_atKO)) }}</td>
                                        <td style="min-width: 150px;">
                                            <a href="{{ url('admin/teacher/edit/'.$record->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ url('admin/teacher/delete/'.$record->id) }}" class="btn btn-danger btn-sm">Delete</a>
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