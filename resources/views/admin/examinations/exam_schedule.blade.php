@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam Schedule </h1>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title"> Search Exam Schedule </h3>
        </div>
        <form method="GET" action="">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Exam</label>
                        <select class="form-control" name="exam_id" required>
                            <option value="">Select</option>
                            @foreach($getExam as $exam)
                            <option {{(Request::get('exam_id') == $exam->id)?'selected':''}} value="{{$exam->id}}">{{$exam->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Class</label>
                        <select class="form-control" name="class_id" required>
                            <option value="">Select</option>
                            @foreach($getClass as $class)
                            <option {{(Request::get('class_id') == $class->id)?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                        <a href="{{url('admin/examinations/exam/list')}}" class="btn btn-success" style="margin-top: 30px;">Clear</a>
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
                    @if(!empty($getRecords))
                    <form action="{{url('admin/examinations/exam_schedule_insert')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                        <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Exam Schedule </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject Name</th>
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Room Number</th>
                                            <th>Full Mark</th>
                                            <th>Pass Mark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($getRecords as $value)
                                        <tr>
                                            <td>
                                                {{$value['subject_name']}}
                                                <input type="hidden" name="schedule[{{$i}}][subject_id]" value="{{$value['subject_id']}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="date" name="schedule[{{$i}}][exam_date]" value="{{$value['exam_date']}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="time"  name="schedule[{{$i}}][start_time]" value="{{$value['start_time']}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="time"  name="schedule[{{$i}}][end_time]" value="{{$value['end_time']}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text"  name="schedule[{{$i}}][room_number]" value="{{$value['room_number']}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text"  name="schedule[{{$i}}][full_marks]" value="{{$value['full_marks']}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text"  name="schedule[{{$i}}][passing_mark]" value="{{$value['passing_mark']}}" class="form-control">
                                            </td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="text-align: right; padding:20px">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@endsection