@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>Meter Locations</strong>
                {{-- <span class="float-right"><a href="{{ route('virtual-meters.refresh') }}" class="btn btn-sm btn-dark float-end">Refresh</a></span> --}}
            </h4>
            <hr>
            <div class="table-responsive table-striped">
                <table class="table table-borderless table-striped table-hover table-myDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Area</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($meterLocations->isEmpty())
                            @else @foreach ($meterLocations as $meterLocation)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td><a style="text-decoration: none" href="{{ route('meter-locations.show', $meterLocation) }}">{{ strToUpper($meterLocation->name) }}</a></td>
                                <td>{{ strToUpper($meterLocation->area->name) }}</td>
                                <td>{{ $meterLocation->active == 1 ? "Yes" : "No" }}</td>
                            </tr>
                            @endforeach 
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection