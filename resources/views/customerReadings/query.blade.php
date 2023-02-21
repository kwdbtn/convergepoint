@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $customer->name }}</h5>
            <hr>
            {!! Form::open(['route' => 'customer-readings.queryResults']) !!}
            <div class="row g-5">
                <div class="col-auto">
                    {!! Form::select('month',$arr['months'], null,['class'=>'form-control
                            col-md-12 col-xs-12
                            select2'])
                            !!}
                </div>

                <div class="col-auto" style="padding-left: 0; width:100px">
                    {!! Form::select('year',$arr['years'], null,['class'=>'form-control
                            col-md-12 col-xs-12
                            select2'])
                            !!}
                </div>

                <div class="col-auto" style="padding-left: 0">
                    <div class="offset-sm-2">
                        <button type="submit" class="btn btn-sm btn-dark">Search</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <hr>

        </div>
    </div>
</div>
@endsection