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
                                        <h1>{{ count($virtualMetersLoad) }}</h1>
                                    </div>
                                </div>
                            </a>
                            
                            {{-- <a class="application-link" href="#"> --}}
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>Load</h6>
                                    <h1>{{ $consumption }}wh</h1>
                                </div>
                            </div>
                            {{-- </a> --}}
                        
                        </div>
                        <div class="col-md-6">
                            <a style="text-decoration: none" href="{{ route('virtual-meters.generation') }}">
                                <div class="card application-count mb-2">
                                    <div class="card-body">
                                        <h6>Virtual Meters - Generators</h6>
                                        <h1>{{ count($virtualMetersGenerators) }}</h1>
                                    </div>
                                </div>
                            </a>

                             {{-- <a class="application-link" href="#"> --}}
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>Generation</h6>
                                    <h1>{{ number_format($generation, 0, '', '') }}wh</h1>
                                </div>
                            </div>
                            {{-- </a> --}}

                        </div>

                        <div class="col-md-12">
                            {{-- <a class="application-link" href="#"> --}}
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h6>Losses</h6>
                                    <h1>{{ number_format($losses, 0, '', '') }}wh</h1>
                                </div>
                            </div>
                            {{-- </a> --}}
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-2">
                            <div class="card-body">
                                    {!! $metersChart->container() !!}
                                    {!! $metersChart->script() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-6">
                            <div class="card-body">
                                    {!! $readingChart->container() !!}
                                    {!! $readingChart->script() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-6">
                            <div class="card-body">
                                    {!! $areaChart->container() !!}
                                    {!! $areaChart->script() !!}
                            </div>
                        </div>
                    </div>
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