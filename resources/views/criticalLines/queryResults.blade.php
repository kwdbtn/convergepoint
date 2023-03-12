@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Query</h5>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-striped">
                        <table class="table table-bordered table-striped-columns table-hover table-myDataTablex">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Resource</th>
                                    <th scope="col">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr scope="row">
                                    <td>Source Meter</td>
                                    <td>{{ $source->name }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Source Previous Reading</td>
                                    <td>{{ $sourceDataPreviousValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Source Present Reading</td>
                                    <td>{{ $sourceDataPresentValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Source Loss</td>
                                    <td>{{ $sourceLoss }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Meter</td>
                                    <td>{{ $destination->name }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Previous Reading</td>
                                    <td>{{ $destinationDataPreviousValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Present Reading</td>
                                    <td>{{ $destinationDataPresentValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Loss</td>
                                    <td>{{ $destinationLoss }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Loss</td>
                                    <td>{{ $loss }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>% Loss</td>
                                    <td>{{ round($percentageLoss, 2) }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection