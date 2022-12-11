@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>{{ $customer->name }} Meters</strong>
                @guest
                 <span class="float-right"><a href="{{ route('customers.index') }}" class="btn btn-sm btn-dark float-end">Back</a></span>
                @endguest
            </h4>
            
            @auth
            <hr>
                <ul>
                    <li><a style="text-decoration: none" href="{{ route('customers.currentbill') }}">Current Bill</a></li>
                    <li><a style="text-decoration: none" href="{{ route('customers.currentstatementsheet') }}">Current Statement Sheet</a></li>
                    <li><a style="text-decoration: none" href="{{ route('customers.currentcoverletter') }}">Current Cover Letter</a></li>
                </ul>
            @endauth
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
                            @auth
                                <th scope="col">Action</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @if ($customer->virtual_meters->isEmpty())
                            @else @foreach ($customer->virtual_meters as $virtualMeter)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td><a style="text-decoration: none" href="{{ route('virtual-meters.show', [$virtualMeter, 16005]) }}">{{ strToUpper($virtualMeter->name) }}</a></td>
                                 <td>{{ strToUpper($virtualMeter->type ?? "") }}</td>
                                <td>{{ strToUpper($virtualMeter->feeder->number ?? "") }}</td>
                                <td>{{ strToUpper($virtualMeter->meter_location->name ?? "") }}</td>
                                @auth
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <button type="button" class="btn btn-sm btn-primary">Approve</button>
                                            <a class="btn btn-sm btn-danger" href="{{ route('customers.send-email', [$customer, $virtualMeter]) }}">Reject</a>
                                            {{-- <button type="button" class="btn btn-sm btn-danger">Reject</button> --}}
                                        </div>
                                    </td>
                                @endauth
                            </tr>
                            @endforeach @endif
                    </tbody>
                </table>
            </div> 
            @auth
                <hr>
                <div class="col-12">
                    Comments:
                    <textarea name="comments" id="comments" cols="10" rows="2" class="col-12"></textarea>
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-primary">Approve</button>
                        <button type="button" class="btn btn-danger">Reject</button>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection