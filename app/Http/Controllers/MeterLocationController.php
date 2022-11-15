<?php

namespace App\Http\Controllers;

use App\Models\MeterLocation;
use Illuminate\Http\Request;

class MeterLocationController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $meterLocations = MeterLocation::orderBy('name')->get();
        return view('meterLocations.index', compact('meterLocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MeterLocation  $MeterLocation
     * @return \Illuminate\Http\Response
     */
    public function show(MeterLocation $meterLocation) {
        return view('meterLocations.show', compact('meterLocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MeterLocation  $MeterLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(MeterLocation $meterLocation) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MeterLocation  $meterLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeterLocation $meterLocation) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MeterLocation  $meterLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeterLocation $meterLocation) {
        //
    }
}
