@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Class Timetable ({{$getClass->name}} {{$getSubject->name}}) <span style="color: blue;">({{$getStudent->name}} {{$getStudent->last_name}})</span></h1>
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="color: blue;">
                                Class: {{$getClass->name}} / Subject: {{$getSubject->name}}
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Week</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Room Number</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($getRecord as $week)
                                    <tr>
                                        <td>{{$week['week_name']}}</td>
                                        <td>{{$week['start_time']}}</td>
                                        <td>{{$week['end_time']}}</td>
                                        <td>{{$week['room_number']}}</td>
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

<!-- @section('script')

<script type="text/javascript">
    $('.getClass').change(function() {
        var class_id = $(this).val();
        $.ajax({
            url: "{{ url('admin/class_timetable/get_subject') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                class_id: class_id,
            },
            dataType: "json",
            success: function(response) {
                $('.getSubject').html(response.html);
            },
        });
    });
</script>

@endsection -->