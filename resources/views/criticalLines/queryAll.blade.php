@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Query <span class="float-right"><a href="{{ route('critical-lines.index') }}" class="btn btn-sm btn-dark float-end">Back</a></span></h5>
            <hr>
            {!! Form::open(['route' => 'critical-lines.queryResultsAll']) !!}
            <div class="row g-5">

                <div class="col-auto" style="width: 200px">
                    {!! Form::select('criticalLines',$arr['criticalLines'], null,['class'=>'form-control
                            col-md-12 col-xs-12
                            select2'])
                            !!}
                </div>

                <div class="col-auto" style="padding-left: 0">
                    <div class="input-group date" id="dateFrom" data-target-input="nearest">
                        {!! Form::text('from', null, ['class'=>'form-control datetimepicker-input col-md-12 col-xs-12','placeholder'=>'Start Date', 'data-target'=>'#dateFrom', 'data-toggle'=>"datetimepicker", 'required']) !!}
                        <div class="input-group-append" data-target="#dateFrom" data-toggle="datetimepicker">
                        </div>
                    </div>
                </div>
            
                <div class="col-auto" style="padding-left: 0">
                    <div class="input-group date" id="dateTo" data-target-input="nearest">
                        {!! Form::text('to', null, ['class'=>'form-control datetimepicker-input col-md-12 col-xs-12','placeholder'=>'End Date', 'data-target'=>'#dateTo', 'data-toggle'=>"datetimepicker", 'required']) !!}
                        <div class="input-group-append" data-target="#dateTo" data-toggle="datetimepicker">
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
            <hr>
            
        </div>
    </div>
</div>
@endsection