@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>Variables</strong>
                {{-- <span class="float-right"><a href="{{ route('equipment.create') }}" class="btn btn-sm btn-dark float-end">Add New</a></span> --}}
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-myDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Obis</th>
                            <th scope="col">PVM Count</th>
                            <th scope="col">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($variables->isEmpty())
                            @else @foreach ($variables as $variable)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td><a style="text-decoration: none" href="{{ route('variables.edit', $variable) }}">{{ $variable->name }}</a></td>
                                <td>{{ $variable->description }}</td>
                                <td>{{ $variable->obis }}</td>
                                <td>{{ $variable->pvmCount }}</td>
                                <td>{{ $variable->type == 1 ? "Load Profile" : "Billing Value" }}</td>
                            </tr>
                            @endforeach @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection