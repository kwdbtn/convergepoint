@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Query</h5>
            <hr>
            {!! Form::open(['route' => 'virtual-meters.calculate-losses']) !!}
            <div class="row g-5">
                <div class="col-auto">
                    <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                        {!! Form::text('from', null, ['class'=>'form-control datetimepicker-input col-md-12 col-xs-12','placeholder'=>'Start Date', 'data-target'=>'#datetimepicker7', 'data-toggle'=>"datetimepicker", 'required']) !!}
                        <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                            {{-- <div class="input-group-text form-control"><i class="fa fa-calendar"></i></div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-auto" style="padding-left: 0">
                    <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                        {!! Form::text('to', null, ['class'=>'form-control datetimepicker-input col-md-12 col-xs-12','placeholder'=>'End Date', 'data-target'=>'#datetimepicker8', 'data-toggle'=>"datetimepicker", 'required']) !!}
                        <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                            {{-- <div class="input-group-text"><i class="fa fa-calendar"></i></div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-auto" style="padding-left: 0">
                    <div class="offset-sm-2 mt-2">
                        <button type="submit" class="btn btn-sm btn-dark">Search</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection