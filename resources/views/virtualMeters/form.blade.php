@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justified-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        <strong>{{ $virtualMeter->exists ? "Editing '".$virtualMeter->name."'" : "New Virtual Meter" }}</strong>
                        <span>
                            <a href="{{ route('virtual-meters.index') }}" class="btn btn-sm btn-dark float-end">Back</a>
                        </span>
                    </h4>
                    <hr>

                    {!! Form::model($virtualMeter, ['method' => $virtualMeter->exists ? 'PUT' : 'POST', 
                    'route' => $virtualMeter->exists ? ['virtual-meters.update', $virtualMeter] : ['virtual-meters.store'],
                    'class' => 'form-horizontal'])
                    !!}

                    <div class="form-group row mb-1">
                        {!! Form::label('name', 'Converge Name:', ['class' => 'control-label col-sm-2 text-end'])
                        !!}
                        <div class="col-sm-8 col-md-8">
                            {!! Form::text('name', null,['class'=>'form-control col-md-7 col-xs-8
                            ','placeholder'=>'Name', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('alias', 'Alias:', ['class' => 'control-label col-sm-2 text-end'])
                        !!}
                        <div class="col-sm-8 col-md-8">
                            {!! Form::text('alias', null,['class'=>'form-control col-md-7 col-xs-8
                            ','placeholder'=>'Alias']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('type', 'Type:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('type', $arr['types'], null, ['class' => 'form-control col-md-7 col-xs-8'])}}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('load_type', 'Load Type:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('load_type', $arr['load_types'], null, ['class' => 'form-control col-md-7 col-xs-8'])}}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('serial_number', 'Serial Number:', ['class' => 'control-label col-sm-2 text-end'])
                        !!}
                        <div class="col-sm-8 col-md-8">
                            {!! Form::text('serial_number', null,['class'=>'form-control col-md-7 col-xs-8
                            ','placeholder'=>'Serial Number', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('customer_id', 'Customer:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('customer_id', $arr['customers'], null, ['class' => 'form-control col-md-7 col-xs-8'])}}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('feeder_id', 'Feeder/SS/Line:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('feeder_id', $arr['feeders'], null, ['class' => 'form-control col-md-7 col-xs-8'])}}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('area_id', 'Area:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('area_id', $arr['areas'], null, ['class' => 'form-control col-md-7 col-xs-8'])}}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('meter_location_id', 'Meter Location:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('meter_location_id', $arr['meter_locations'], null, ['class' => 'form-control col-md-7 col-xs-8'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="offset-sm-2">
                            <button type="submit" class="btn btn-dark">{{ $virtualMeter->exists ? @"Update" : @"Create" }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection