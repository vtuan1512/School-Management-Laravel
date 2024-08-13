@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Student Subject <span style="color: red;">({{$getUser->name}} {{$getUser->last_name}})</span> </h1>
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
                            <h3 class="card-title">Student Subject</h3>
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
                                        <th>Subject Name</th>
                                        <th>Subject Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $index => $value)
                                    <tr>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{$value->subject_name}}</td>
                                        <td>{{$value->subject_type}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection