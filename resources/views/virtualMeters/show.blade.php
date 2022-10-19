@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>{{ $virtualMeter->name }} ({{ $variableKey }})</strong>
                <span class="float-right"><a href="{{ route('virtual-meters.index') }}" class="btn btn-sm btn-dark float-end">Back</a></span>
            </h4>
            <hr>
            <div class="row g-2 mt-1">
                {!! Form::label('from', 'From:', ['class' => 'control-label col-sm-2 text-end']) !!}
                <div class="col-auto">
                    <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                        {!! Form::text('from', null, ['class'=>'form-control datetimepicker-input col-md-12 col-xs-12','placeholder'=>'Start Date', 'data-target'=>'#datetimepicker7', 'data-toggle'=>"datetimepicker", 'required']) !!}
                        <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                            {{-- <div class="input-group-text form-control"><i class="fa fa-calendar"></i></div> --}}
                        </div>
                    </div>
                </div>
            
                {!! Form::label('to', 'To:', ['class' => 'control-label col-sm-2 text-end']) !!}
                <div class="col-auto">
                    <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                        {!! Form::text('to', null, ['class'=>'form-control datetimepicker-input col-md-12 col-xs-12','placeholder'=>'End Date', 'data-target'=>'#datetimepicker8', 'data-toggle'=>"datetimepicker", 'required']) !!}
                        <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                            {{-- <div class="input-group-text"><i class="fa fa-calendar"></i></div> --}}
                        </div>
                    </div>
                </div>
            </div><hr>

            <div class="row">
                <div class="col-md-4">
                    <div class="card" style="height: 500px; overflow:auto;">
                        <div class="card-body">
                            @foreach ($variables as $key => $variable)
                                <li><a style="{{ $key == $variableKey ? 'color: black; font-weight: bold' : ''}}" href="{{ route('virtual-meters.show', [$virtualMeter, $variable]) }}">{{ $key }}</a></li> <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive table-striped">
                        <table class="table table-bordered table-striped-columns table-hover table-myDataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">Norm</th>
                                    <th scope="col">Norm Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($data))
                                    @else @foreach ($data as $datum)
                                    <tr scope="row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $datum['t'] }}</td>
                                        <td>{{ $datum['f0'] }}</td>
                                        <td>{{ $datum['f2'] }}</td>
                                    </tr>
                                    @endforeach @endif
                            </tbody>
                        </table>
            </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection