<?php

namespace App\Http\Controllers;

use App\Models\VirtualMeter;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VirtualMeterController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $virtualMeters = VirtualMeter::orderBy('name')->get();
        return view('virtualMeters.index', compact('virtualMeters'));
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
     * @param  \App\Models\VirtualMeter  $virtualMeter
     * @return \Illuminate\Http\Response
     */
    public function show(VirtualMeter $virtualMeter, $variable) {
        // dd($request->from);
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $client = new Client([
            // 'base_uri' => 'https://ksi-ent-cba-01.gridcogh.com/rest_api/',
            'base_uri' => 'https://converge4.gridcogh.com/rest_api/',
            'verify'   => false,
        ]);

        $response = $client->request('POST', 'api/v1/login/user-login', [
            'headers' => $headers,
            'body'    => '{"userName":"gridcodev", "password":"Pa55w.rd"}',
        ]);

        $statusCode   = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        $token        = $responseBody["token"];

        $body = [
            "virtualMeters"             => [
                [
                    "virtualMeterId" => $virtualMeter->node_id,
                    "variableIds"    => [
                        $variable,
                    ],
                ],
            ],
            "dataFrom"                  => "2021-10-01T00:00:00.501Z",
            "dataTo"                    => "2021-10-10T00:00:00.501Z",
            "useMeterTimezoneAlignment" => true,
        ];

        $response_meter_data = $client->request('POST', 'api/v1/meter-data', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'content-type'  => 'application/json',
            ],

            'body'    => json_encode($body),
        ]);

        $meterdata = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response_meter_data->getBody()->getContents()), true);
        $data      = $meterdata['rowData'];
        // dd($data['rowData']);

        $variables = [
            '+A'           => 16005, '+R'        => 16007, '+S'              => 16006, 'PF'          => 16017,
            'XNU_A+'       => 1632, 'XNU_R+'     => 2123, '+A*Energy*Kwh'    => 24948, '+A*MaxD*Kw'  => 24952,
            '+A*MaxD*Kw*'  => 17768, '+E*'       => 15532, '+E*Power'        => 17761, '+R*'         => 17764,
            '+R*AvDem'     => 24951, '+R*AvDem*' => 24954, '+R*Energy*Kvarh' => 24949, '+R*Power'    => 17762,
            '+S*'          => 17765, '+VA*Dem'   => 24945, '+VA*Dem*'        => 24950, 'PowerFactor' => 17766,
            'PowerFactor*' => 24956,
        ];

        $variableKey = array_search($variable, $variables);

        return view('virtualMeters.show', compact('virtualMeter', 'data', 'variables', 'variableKey'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VirtualMeter  $virtualMeter
     * @return \Illuminate\Http\Response
     */
    public function edit(VirtualMeter $virtualMeter) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VirtualMeter  $virtualMeter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VirtualMeter $virtualMeter) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VirtualMeter  $virtualMeter
     * @return \Illuminate\Http\Response
     */
    public function destroy(VirtualMeter $virtualMeter) {
        //
    }
}
