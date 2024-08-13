@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Student</h1>
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
                                        <th>Created Date</th>

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
                                        <td>{{ date('d-m-Y H:i A',strtotime( $record->created_atKO)) }}</td>
                                        
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