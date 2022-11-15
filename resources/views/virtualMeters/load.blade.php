@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>Virtual Meters - Load</strong>
                <span class="float-right"><a href="{{ route('virtual-meters.calculate-losses') }}" class="btn btn-sm btn-dark float-end">Back</a></span>
            </h4>
            <hr>
            <div class="table-responsive table-striped">
                <table class="table table-borderless table-striped table-hover table-myDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Serial No.</th>
                            <th scope="col">Type</th>
                            <th scope="col">Feeder/Plant Line</th>
                            <th scope="col">Location</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($virtualMeters->isEmpty())
                            @else @foreach ($virtualMeters as $virtualMeter)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td><a style="text-decoration: none" href="{{ route('virtual-meters.show', [$virtualMeter, 16005]) }}">{{ strToUpper($virtualMeter->name) }}</a></td>
                                <td>{{ strToUpper($virtualMeter->serial_number ?? "") }}</td>
                                <td>{{ strToUpper($virtualMeter->type ?? "") }}</td>
                                @if (!is_null($virtualMeter->feeder))
                                    <td><a style="text-decoration: none" href="{{ route('feeders.show', $virtualMeter->feeder) }}">{{ strToUpper($virtualMeter->feeder->number) }}</a></td>
                                @else
                                    <td> </td>
                                @endif
                                @if (!is_null($virtualMeter->meter_location))
                                    <td><a style="text-decoration: none" href="{{ route('meter-locations.show', $virtualMeter->meter_location) }}">{{ strToUpper($virtualMeter->meter_location->name ?? "") }}</a></td>
                                @else
                                    <td> </td>
                                @endif
                                @if (!is_null($virtualMeter->customer))
                                    <td><a style="text-decoration: none" href="{{ route('customers.show', $virtualMeter->customer) }}">{{ strToUpper($virtualMeter->customer->name ?? "") }}</a></td>
                                @else
                                    <td> </td>
                                @endif
                                <td>{{ $virtualMeter->active == 1 ? "YES" : "NO" }}</td>
                            </tr>
                            @endforeach @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection