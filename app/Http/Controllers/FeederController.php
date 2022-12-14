<?php

namespace App\Http\Controllers;

use App\Models\Feeder;
use Illuminate\Http\Request;

class FeederController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $feeders = Feeder::where('active', true)->orderBy('number', 'asc')->get();
        return view('feeders.index', compact('feeders'));
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
     * @param  \App\Models\Feeder  $feeder
     * @return \Illuminate\Http\Response
     */
    public function show(Feeder $feeder) {
        return view('feeders.show', compact('feeder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feeder  $feeder
     * @return \Illuminate\Http\Response
     */
    public function edit(Feeder $feeder) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feeder  $feeder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feeder $feeder) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feeder  $feeder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feeder $feeder) {
        //
    }
}
