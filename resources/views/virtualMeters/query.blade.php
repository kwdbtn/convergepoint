@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Query</h5>
            <hr>
            {!! Form::open(['route' => 'virtual-meters.queryResults']) !!}
            <div class="row g-5">
                <div class="col-auto">
                    {!! Form::select('virtualMeter',$arr['virtualMeters'], null,['class'=>'form-control
                            col-md-12 col-xs-12
                            select2'])
                            !!}
                </div>

                <div class="col-auto" style="padding-left: 0">
                    {!! Form::select('variable',$arr['variables'], null,['class'=>'form-control
                            col-md-12 col-xs-12
                            select2'])
                            !!}
                </div>

                <div class="col-auto" style="padding-left: 0">
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
            <hr>

            {{-- <div class="row">
                <div class="col-md-12">
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
            </div> --}}
            
        </div>
    </div>
</div>
@endsection