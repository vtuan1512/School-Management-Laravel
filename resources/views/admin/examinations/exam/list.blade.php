@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam List (Total: {{ $getRecords->total() }})</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{url('admin/examinations/exam/add')}}" class="btn btn-primary">Add New Exam</a>
                </div>
            </div>
            
        </div><!-- /.container-fluid -->
    </section>
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title"> Search Exam </h3>
        </div>
        <form method="GET" action="">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ Request::get('name')}}" placeholder="Enter exam name">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}" placeholder="Date">
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Exam List </h3>
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
                                        <th>Exam Name</th>
                                        <th>Note</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecords as $index => $record)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $record->name }}</td>
                                        <td>{{ $record->note }}</td>
                                        <td>{{ $record->created_name }}</td>  
                                        <td>{{ date('d-m-Y H:i A',strtotime( $record->created_atKO)) }}</td>
                                        <td>
                                            <a href="{{ url('admin/examinations/exam/edit/'.$record->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ url('admin/examinations/exam/delete/'.$record->id) }}" class="btn btn-danger">Delete</a>
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