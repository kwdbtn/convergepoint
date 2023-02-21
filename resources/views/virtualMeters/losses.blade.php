@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h4>
                        <i class="fa fa-bolt"></i> Energy Readings
                        <span class="float-end"><i class="fa fa-clock-o"></i> {{ $fromDate }} - {{ $toDate }}</span>
                    </h4>
                            </div>
                        </div>
                    </div>
                    
                        <div class="col-md-6">
                            <a style="text-decoration: none" href="{{ route('virtual-meters.load') }}">
                                <div class="card application-count mb-2">
                                    <div class="card-body">
                                        <h6>Virtual Meters - Load</h6>
                                        {{-- <h1>{{ count($baseMeters) }} / {{ count($virtualMetersLoad) }}</h1> --}}
                                        <h1>300 / 347</h1>
                                    </div>
                                </div>
                            </a>
                            
                            {{-- <a class="application-link" href="#"> --}}
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>Load</h6>
                                    <h1>{{ number_format($consumption, 2, '.', ',') }}wh</h1>
                                </div>
                            </div>
                            {{-- </a> --}}
                        
                        </div>
                        <div class="col-md-6">
                            <a style="text-decoration: none" href="{{ route('virtual-meters.generation') }}">
                                <div class="card application-count mb-2">
                                    <div class="card-body">
                                        <h6>Virtual Meters - Generation</h6>
                                        {{-- <h1>{{ count($baseGenerators) }} / {{ count($virtualMetersGenerators) }}</h1> --}}
                                        <h1>47 / 347</h1>
                                    </div>
                                </div>
                            </a>

                             {{-- <a class="application-link" href="#"> --}}
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>Generation</h6>
                                    <h1>{{ number_format($generation, 2, '.', ',') }}wh</h1>
                                </div>
                            </div>
                            {{-- </a> --}}

                        </div>

                        <div class="col-md-6">
                            {{-- <a class="application-link" href="#"> --}}
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>Losses</h6>
                                    <h1>{{ number_format($losses, 2, '.', ',') }}wh</h1>
                                </div>
                            </div>
                            {{-- </a> --}}
                        </div>

                        <div class="col-md-6">
                            {{-- <a class="application-link" href="#"> --}}
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>% Losses <span class="float-end">Approved % Loss - <strong style="color: green"><= 4.1%</strong> <br>Difference - <strong style="color:red">{{ round($percentageLoss - 4.1, 2) }}</strong>%</span></h6>
                                    <h1><span style="color:red">{{ round($percentageLoss, 2) }}%</span>
                    </h4></h1>
                                </div>
                            </div>
                            {{-- </a> --}}
                        </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-6">
                        <div class="card mb-2">
                            <div class="card-body">
                                    {!! $metersChart->container() !!}
                                    {!! $metersChart->script() !!}
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="card mt-6">
                            <div class="card-body">
                                    {!! $readingChart->container() !!}
                                    {!! $readingChart->script() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- <div class="col-md-12">
                        <div class="card mt-6">
                            <div class="card-body">
                                    {!! $areaChart->container() !!}
                                    {!! $areaChart->script() !!}
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <div class="card mt-6">
                            <div class="card-body">
                                    {!! $readingChart->container() !!}
                                    {!! $readingChart->script() !!}
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection