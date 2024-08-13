@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Parent List (Total: {{ $getRecords->total() }})</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{url('admin/parent/add')}}" class="btn btn-primary">Add New Parent</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title"> Search Parent </h3>
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
                        <label>Occupation</label>
                        <input type="text" class="form-control" name="occupation" value="{{ Request::get('occupation')}}" placeholder="Enter Occupation">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ Request::get('address')}}" placeholder="Enter address">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Mobile Number</label>
                        <input type="text" class="form-control" name="mobile_number" value="{{ Request::get('mobile_number')}}" placeholder="Enter mobile number">
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
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}">
                    </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                        <a href="{{url('admin/parent/list')}}" class="btn btn-success" style="margin-top: 30px;">Clear</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">
                    @include('message')

                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Parent List </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            @if($getRecords->isEmpty())
                            <p class="text-center" style="color: red;">No data found</p>
                            @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile Pic</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Mobile Number</th>
                                        <th>Occcupation</th>
                                        <th>Address</th>
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
                                            @if(!empty($record->getProfile_Parent()))
                                            <img src="{{ $record->getProfile_Parent()}}" style="height: 80px; width:80px; border-radius: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $record->name }} {{ $record->last_name}}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->gender }}</td>
                                        <td>{{ $record->mobile_number }}</td>
                                        <td>{{ $record->occupation }}</td>
                                        <td>{{ $record->address }}</td>
                                        <td>{{ ($record->status==0)?'Active':'Inactive' }}</td>
                                        <td>{{ date('d-m-Y H:i A',strtotime( $record->created_atKO)) }}</td>
                                        <td>
                                            <a href="{{ url('admin/parent/edit/'.$record->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ url('admin/parent/delete/'.$record->id) }}" class="btn btn-danger">Delete</a>
                                            <a href="{{ url('admin/parent/my-student/'.$record->id) }}" class="btn btn-primary">Student</a>
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