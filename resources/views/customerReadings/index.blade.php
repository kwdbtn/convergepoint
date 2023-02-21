@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>{{ $customer->name }} Readings</strong></h4>
            <hr>
            <div class="table-responsive table-striped">
                <table class="table table-borderless table-striped table-hover table-myDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Period</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($readings->isEmpty())
                            @else @foreach ($readings as $reading)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td><a style="text-decoration: none" href="{{ route('customer-readings.show', [$reading, $customer]) }}">{{ strToUpper($reading->reading_period->name) }}</a></td>
                                <td>{{ $reading->status }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @if ($reading->status != 'Not Verified')
                                            <button type="button" name="approve" class="btn btn-sm btn-success" disabled>{{ $reading->status }}</button>
                                        @else
                                        <form action="{{ route('customer-readings.approval', $reading) }}" method="POST">
                                            @csrf
                                            <button type="submit" name="approve" class="btn btn-sm btn-primary">Approve</button>
                                            <button type="submit" name="reject" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection