@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Class & Subject</h1>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Class & Subject</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Class Name</th>
                                        <th>Subject Name</th>
                                        <th>Subject Type</th>
                                        <th>My Class Timetable</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $index =>$value)
                                    <tr>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{$value->class_name}}</td>
                                        <td>{{$value->subject_name}}</td>
                                        <td>{{$value->subject_type}}</td>
                                        <td>
                                            @php 
                                            $ClassSubject = $value->getMyTimetable($value->class_id,$value->subject_id)
                                            @endphp
                                            @if(!empty($ClassSubject))
                                            {{$ClassSubject->start_time}} to {{$ClassSubject->end_time}}
                                            <br />
                                            Room Number: {{$ClassSubject->room_number}}
                                            @endif
                                        </td>
                                        <td>{{date('d-m-Y H:i A', strtotime($value->created_at))}}</td>
                                        <td>
                                            <a class="btn btn-warning" href="{{url('teacher/my_class_subject/class_timetable/'.$value->class_id.'/'.$value->subject_id)}}">My Class Timetable</a>
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