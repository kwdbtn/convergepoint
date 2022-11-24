@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justified-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        <strong>{{ $virtual_meter->exists ? "Editing '".$virtual_meter->name."'" : "New Virtual Meter" }}</strong>
                        <span>
                            <a href="{{ route('virtual-meters.index') }}" class="btn btn-sm btn-dark float-end">Back</a>
                        </span>
                    </h4>
                    <hr>

                    {!! Form::model($virtual_meter, ['method' => $virtual_meter->exists ? 'PUT' : 'POST', 
                    'route' => $virtual_meter->exists ? ['virtual-meters.update', $virtual_meter] : ['virtual-meters.store'],
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
                            ','placeholder'=>'Alias', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('type', 'Type:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('type', $types, null, ['class' => 'form-control col-md-7 col-xs-8'])}}
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

                    <div class="form-group">
                        <div class="offset-sm-2">
                            <button type="submit" class="btn btn-dark">{{ $virtual_meter->exists ? @"Update" : @"Create" }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection