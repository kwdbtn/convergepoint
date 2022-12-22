@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $virtualMeter->name }} <span style="color: red">||</span> {{ $variableKey }}
                <span class="float-right"><a href="{{ route('virtual-meters.index') }}" class="btn btn-sm btn-dark float-end">Back</a></span>
            </h5>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-2" style="height: 250px; overflow:auto;">
                        <div class="card-header">Variables</div>
                        <div class="card-body">
                            @foreach ($variables as $key => $variable)
                                <li><a style="{{ $key == $variableKey ? 'color: black; font-weight: bold' : 'text-decoration: none'}}" href="{{ route('virtual-meters.show', [$virtualMeter, $variable]) }}">{{ $key }}</a></li> <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive table-striped">
                        <table class="table table-bordered table-striped-columns table-hover table-myDataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($data))
                                    @else @foreach ($data as $datum)
                                    <tr scope="row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $datum['t'] }}</td>
                                        <td>{{ $datum['f0'] }}</td>
                                        <td>{{ $datum['f2'] }}</td>
                                    </tr>
                                    @endforeach @endif
                            </tbody>
                        </table>
                    </div>
                </div> 

                <div class="col-md-12 mt-5">
                    {!! $chart->container() !!}
                    {!! $chart->script() !!}
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection