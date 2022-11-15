@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>{{ $feeder->number }} Virtual Meters</strong>
                <span class="float-right"><a href="{{ route('feeders.index') }}" class="btn btn-sm btn-dark float-end">Back</a></span>
            </h4>
            <hr>
            <div class="table-responsive table-striped">
                <table class="table table-borderless table-striped table-hover table-myDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Feeder</th>
                            <th scope="col">Location</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($feeder->virtual_meters->isEmpty())
                            @else @foreach ($feeder->virtual_meters as $virtualMeter)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td><a style="text-decoration: none" href="{{ route('virtual-meters.show', [$virtualMeter, 16005]) }}">{{ strToUpper($virtualMeter->name) }}</a></td>
                                 <td>{{ strToUpper($virtualMeter->type ?? "") }}</td>
                                <td>{{ strToUpper($virtualMeter->feeder->number ?? "") }}</td>
                                <td>{{ strToUpper($virtualMeter->meter_location->name ?? "") }}</td>
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