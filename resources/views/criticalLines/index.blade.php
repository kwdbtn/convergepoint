@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><strong>Critical Lines</strong>
                <span class="float-right"><a href="{{ route('critical-lines.showQueryAll') }}" class="btn btn-sm btn-dark float-end">Query for Losses</a></span>
                <span class="float-right"><a href="{{ route('critical-lines.dailyAverageLosses') }}" class="btn btn-sm btn-secondary float-end">Daily Loss</a></span>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-myDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Source</th>
                            <th scope="col">Destination</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($lines->isEmpty())
                            @else @foreach ($lines as $line)
                            <tr scope="row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $line->name }}</td>
                                <td>{{ $line->source }}</td>
                                <td>{{ $line->destination }}</td>
                            </tr>
                            @endforeach @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection