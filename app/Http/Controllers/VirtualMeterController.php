<?php

namespace App\Http\Controllers;

use App\Charts\VirtualMeterDataChart;
use App\Models\VirtualMeter;
use Carbon\Carbon;
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
        $today     = Carbon::now();
        $month     = $today->month;
        $year      = $today->year;
        $startDate = Carbon::create($year, $month, 1, 0, 0, 0);

        $from = $startDate;

        $data = $this->getMeterData($virtualMeter, $variable, $from, $today);

        $variables = [
            '+A'           => 16005, '+R'        => 16007, '+S'              => 16006, 'PF'          => 16017,
            'XNU_A+'       => 1632, 'XNU_R+'     => 2123, '+A*Energy*Kwh'    => 24948, '+A*MaxD*Kw'  => 24952,
            '+A*MaxD*Kw*'  => 17768, '+E*'       => 15532, '+E*Power'        => 17761, '+R*'         => 17764,
            '+R*AvDem'     => 24951, '+R*AvDem*' => 24954, '+R*Energy*Kvarh' => 24949, '+R*Power'    => 17762,
            '+S*'          => 17765, '+VA*Dem'   => 24945, '+VA*Dem*'        => 24950, 'PowerFactor' => 17766,
            'PowerFactor*' => 24956,
        ];

        $variableKey = array_search($variable, $variables);

        $labels  = [];
        $dataset = [];

        foreach ($data as $datum) {
            array_push($labels, $datum['t']);
            array_push($dataset, $datum['f0']);
        }

        $chart = new VirtualMeterDataChart;
        $chart->labels($labels);
        $chart->dataset($variableKey, 'line', $dataset)
            ->options(['borderColor' => 'rgba(255, 41, 41, 0.8)'])
            ->options(['borderWidth' => '0.5'])
            ->options(['pointHoverRadius' => '0'])
            ->backgroundColor('rgba(255, 41, 41, 0)');

        return view('virtualMeters.show', compact('virtualMeter', 'data', 'variables', 'variableKey', 'chart'));
    }

    public function search(Request $request) {
        dd($request);
    }

    public function getMeterData(VirtualMeter $virtualMeter, $variable, $from, $to) {
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
            "dataFrom"                  => Carbon::parse($from)->toISOString(),
            "dataTo"                    => Carbon::parse($to)->toISOString(),
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
        // dd($data);
        return $data;
    }

    public function showQueryPage() {
        return view('virtualMeters.query');
    }

    public function getQueryResults(Request $request) {
        $variables = [
            '+A'           => 16005, '+R'        => 16007, '+S'              => 16006, 'PF'          => 16017,
            'XNU_A+'       => 1632, 'XNU_R+'     => 2123, '+A*Energy*Kwh'    => 24948, '+A*MaxD*Kw'  => 24952,
            '+A*MaxD*Kw*'  => 17768, '+E*'       => 15532, '+E*Power'        => 17761, '+R*'         => 17764,
            '+R*AvDem'     => 24951, '+R*AvDem*' => 24954, '+R*Energy*Kvarh' => 24949, '+R*Power'    => 17762,
            '+S*'          => 17765, '+VA*Dem'   => 24945, '+VA*Dem*'        => 24950, 'PowerFactor' => 17766,
            'PowerFactor*' => 24956,
        ];

        $virtualMeter = VirtualMeter::find($request->virtualMeter);
        $variableKey  = $request->variable;
        $variable     = $variables[$variableKey];
        $from         = $request->from;
        $to           = $request->to;

        $data = $this->getMeterData($virtualMeter, $variable, $from, $to);

        $labels  = [];
        $dataset = [];

        foreach ($data as $datum) {
            array_push($labels, $datum['t']);
            array_push($dataset, $datum['f0']);
        }

        $chart = new VirtualMeterDataChart;
        $chart->labels($labels);
        $chart->dataset($variableKey, 'line', $dataset)
            ->options(['borderColor' => 'rgba(255, 41, 41, 0.8)'])
            ->options(['borderWidth' => '0.5'])
            ->options(['pointHoverRadius' => '0'])
            ->backgroundColor('rgba(255, 41, 41, 0)');

        return view('virtualMeters.queryResults', compact('data', 'virtualMeter', 'variableKey', 'from', 'to', 'chart'));
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
