<?php

namespace App\Http\Controllers;

use App\Models\ConvergeVariable;
use Illuminate\Http\Request;

class ConvergeVariableController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $variables = ConvergeVariable::orderBy('name')->get();
        return view('variables.index', compact('variables'));
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
     * @param  \App\Models\ConvergeVariable  $convergeVariable
     * @return \Illuminate\Http\Response
     */
    public function show(ConvergeVariable $convergeVariable) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConvergeVariable  $convergeVariable
     * @return \Illuminate\Http\Response
     */
    public function edit(ConvergeVariable $convergeVariable) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConvergeVariable  $convergeVariable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConvergeVariable $convergeVariable) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConvergeVariable  $convergeVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConvergeVariable $convergeVariable) {
        //
    }
}
