@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Query - {{ $criticalline->name }}</h5>
            <hr>
            {!! Form::open(['route' => 'critical-lines.queryResults']) !!}
            <div class="row g-5">
                <div class="col-auto">
                    {!! Form::select('criticalLines',$arr['criticalLines'], null,['class'=>'form-control
                            col-md-12 col-xs-12
                            select2'])
                            !!}
                </div>
                <div class="col-auto">
                    <div class="input-group date" id="dateonly" data-target-input="nearest">
                        {!! Form::text('from', null, ['class'=>'form-control datetimepicker-input col-md-12 col-xs-12','placeholder'=>'Start Date', 'data-target'=>'#dateonly', 'data-toggle'=>"datetimepicker", 'required']) !!}
                        <div class="input-group-append" data-target="#dateonly" data-toggle="dateonly">
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