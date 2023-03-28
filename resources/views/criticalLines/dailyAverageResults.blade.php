@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Query results - Losses for Yesterday <span class="float-right"><a href="{{ route('critical-lines.showQueryAll') }}" class="btn btn-sm btn-dark float-end">Query for Losses</a></span> <hr>
                Period - {{ $yesterday }} --- {{ $today }} </strong>
                <br><br> Average Loss for {{ count($lineLosses) }} lines --- {{ round($average, 2) }}% </strong>
            </h5>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-6">
                        <div class="card-body">
                            {!! $readingChart->container() !!}
                            {!! $readingChart->script() !!}
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-12">
                    <div class="table-responsive table-striped mt-4">
                        @foreach ($lineLosses as $lineItem)
                        <table class="table table-bordered table-striped-columns table-hover table-myDataTablex">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Resource</th>
                                    <th scope="col">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr scope="row">
                                    <td>From</td>
                                    <td>{{ $lineItem->from }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>To</td>
                                    <td>{{ $lineItem->to }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Source Meter</td>
                                    <td>{{ $lineItem->source->name }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Source Previous Reading</td>
                                    <td>{{ $lineItem->sourceDataPreviousValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Source Present Reading</td>
                                    <td>{{ $lineItem->sourceDataPresentValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Source Loss</td>
                                    <td>{{ $lineItem->sourceLoss }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Meter</td>
                                    <td>{{ $lineItem->destination->name }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Previous Reading</td>
                                    <td>{{ $lineItem->destinationDataPreviousValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Present Reading</td>
                                    <td>{{ $lineItem->destinationDataPresentValue }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Destination Loss</td>
                                    <td>{{ $lineItem->destinationLoss }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>Loss</td>
                                    <td>{{ $lineItem->loss }}</td>
                                </tr>
                                <tr scope="row">
                                    <td>% Loss</td>
                                    <td>{{ round($lineItem->percentageLoss, 2) }}%</td>
                                </tr>
                            </tbody>
                        </table>
                        @endforeach

                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection