@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justified-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        <strong>{{ $variable->exists ? "Editing '".$variable->name."'" : "New variable" }}</strong>
                        <span>
                            <a href="{{ route('variables.index') }}" class="btn btn-sm btn-dark float-end">Back</a>
                        </span>
                    </h4>
                    <hr>

                    {!! Form::model($variable, ['method' => $variable->exists ? 'PUT' : 'POST', 
                    'route' => $variable->exists ? ['variables.update', $variable] : ['variables.store'],
                    'class' => 'form-horizontal'])
                    !!}

                    <div class="form-group row mb-1">
                        {!! Form::label('name', 'Name:', ['class' => 'control-label col-sm-2 text-end'])
                        !!}
                        <div class="col-sm-8 col-md-8">
                            {!! Form::text('name', null,['class'=>'form-control col-md-7 col-xs-8
                            ','placeholder'=>'Name', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('description', 'Description:', ['class' => 'control-label col-sm-2 text-end'])
                        !!}
                        <div class="col-sm-8 col-md-8">
                            {!! Form::text('description', null,['class'=>'form-control col-md-7 col-xs-8
                            ','placeholder'=>'Description', 'required']) !!}
                        </div>
                    </div> 

                    <div class="form-group row mb-1">
                        {!! Form::label('obis', 'Obis:', ['class' => 'control-label col-sm-2 text-end'])
                        !!}
                        <div class="col-sm-8 col-md-8">
                            {!! Form::text('obis', null,['class'=>'form-control col-md-7 col-xs-8
                            ','placeholder'=>'Obis', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('pvmCount', 'PVM Count:', ['class' => 'control-label col-sm-2 text-end'])
                        !!}
                        <div class="col-sm-8 col-md-8">
                            {!! Form::text('pvmCount', null,['class'=>'form-control col-md-7 col-xs-8
                            ','placeholder'=>'PVM Count']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        {!! Form::label('type', 'Type:', ['class' => 'control-label col-sm-2 text-end']) !!}
                        <div class="col-sm-8 col-md-8">
                            {{Form::select('type', $types, null, ['class' => 'form-control col-md-7 col-xs-8'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="offset-sm-2">
                            <button type="submit" class="btn btn-dark">{{ $variable->exists ? @"Update" : @"Create" }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection