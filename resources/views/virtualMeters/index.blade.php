@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>Virtual Meters</strong>
                {{-- <span class="float-right"><a href="{{ route('equipment.create') }}" class="btn btn-sm btn-dark float-end">Add New</a></span> --}}
            </h4>
            <hr>
            <div class="table-responsive table-striped">
                <table class="table table-borderless table-striped table-hover table-myDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Segment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($virtualMeters->isEmpty())
                            @else @foreach ($virtualMeters as $virtualMeter)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td><a style="text-decoration: none" href="{{ route('virtual-meters.show', [$virtualMeter, 16005]) }}">{{ strToUpper($virtualMeter->name) }}</a></td>
                                <td>{{ $virtualMeter->segment == 666001 ? "Public" : "Private" }}</td>
                            </tr>
                            @endforeach @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection