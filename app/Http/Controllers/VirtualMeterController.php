<?php

namespace App\Http\Controllers;

use App\Charts\VirtualMeterDataChart;
use App\Models\Reading;
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
        $virtualMeters = VirtualMeter::where('active', 1)->orderBy('name')->get();
        return view('virtualMeters.index', compact('virtualMeters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(VirtualMeter $virtualMeter) {
        return view('virtualMeters.form', compact('virtualMeter'));
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
            'Active Power Load profile (15) (+A)'              => 16005, 'Reactive Power Load Profile (15) (+R)'            => 16007, 'Apparent Power Load Profile (15) (+S)'          => 16006, 'Power Factor (PF)'                            => 16017,
            'Active Energy Load Profile (15) (XNU_A+)'         => 1632, 'Reactive Energy Load Profile (15) (XNU_R+)'        => 2123, 'Active Energy Stored Value (+A*Energy*Kwh)'      => 24948, 'Active Max Demand Running Value (+A*MaxD*Kw)' => 24952,
            'Active Max Demand Stored Value (+A*MaxD*Kw*)'     => 17768, 'Energy Running Values (+E*)'                      => 15532, 'Active Energy Running Values (+E*Power)'        => 17761, 'Reactive Energy (+R*)'                        => 17764,
            'Reactive Average Demand Stored Value (+R*AvDem)'  => 24951, 'Reactive Average Demand Stored Value (+R*AvDem*)' => 24954, 'Reactive Energy Stored Value (+R*Energy*Kvarh)' => 24949, 'Reactive Power (+R*Power)'                    => 17762,
            'Apparent Power (+S*)'                             => 17765, 'Apparent Power Demand (+VA*Dem)'                  => 24945, 'Apparent Demand Stored (+VA*Dem*)'              => 24950, 'Power Factor Instantaneous (PowerFactor)'     => 17766,
            'Average Power Factor Stored Value (PowerFactor*)' => 24956,
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

    public function getMeterDailyConsumption(VirtualMeter $virtualMeter) {
        $now       = Carbon::now();
        $month     = $now->month;
        $year      = $now->year;
        $day       = $now->day;
        $today     = Carbon::create($year, $month, $day, 0, 0, 0);
        $todayx    = Carbon::create($year, $month, $day, 0, 0, 0);
        $yesterday = $todayx->subDay();
        // dd($today);

        $todaydata     = $this->getMeterData($virtualMeter, 1632, $today, $today);
        $yesterdaydata = $this->getMeterData($virtualMeter, 1632, $yesterday, $yesterday);
        // $unit          = $todaydata[0]['f2'];
        $consumption = $todaydata[0]['f0'] - $yesterdaydata[0]['f0'];

        return $consumption;
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

    public function showLossQueryPage() {
        return view('virtualMeters.lossquery');
    }

    public function lossCalculation(Request $request) {
        $virtualMetersLoad       = VirtualMeter::where('type', 'LOAD')->get();
        $virtualMetersGenerators = VirtualMeter::where('type', 'GENERATOR')->get();

        // $accra = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 1)
        //     ->get();

        // $tema = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 2)
        //     ->get();

        // $akosombo = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 3)
        //     ->get();

        // $takoradi = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 4)
        //     ->get();

        // $prestea = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 5)
        //     ->get();

        // $bolgatanga = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 6)
        //     ->get();

        // $tamale = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 7)
        //     ->get();

        // $techiman = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 8)
        //     ->get();

        // $kumasi = VirtualMeter::where('type', 'LOAD')
        //     ->where('area_id', 9)
        //     ->get();

        $fromDate = $request->from;
        $toDate   = $request->to;

        $from = Carbon::parse($fromDate)->toIso8601ZuluString();
        $to   = Carbon::parse($toDate)->toIso8601ZuluString();

        // // filter out all the unknowns from the first load readings
        // $readingsFrom = Reading::where([
        //     ['timestamp', '=', $from],
        //     ['type', '=', 'LOAD'],
        //     ['norm_unit', '<>', 'unknown'],
        // ])->get();

        // // filter out all the knowns from the second load readings
        // $readingsTo = Reading::where([
        //     ['timestamp', '=', $to],
        //     ['type', '=', 'LOAD'],
        //     ['norm_unit', '=', 'unknown'],
        // ])->get();

        // $baseGenerators = Reading::where([
        //     ['timestamp', '=', $from],
        //     ['type', '=', 'GENERATOR'],
        // ])->get();

        // $firstLoadMeters          = [];
        // $secondLoadMetersUnknowns = [];
        // $baseMeters               = [];

        // // get all meters without null values as the base for
        // // second load calculation
        // foreach ($readingsFrom as $reading) {
        //     array_push($firstLoadMeters, $reading->virtual_meter_id);
        // }

        // // dd(count($firstLoadMeters));

        // // get all meters with null values
        // foreach ($readingsTo as $reading) {
        //     array_push($secondLoadMetersUnknowns, $reading->virtual_meter_id);
        // }

        // foreach ($secondLoadMetersUnknowns as $loadMeter) {
        //     $key = array_search($loadMeter, $firstLoadMeters);

        //     if ($key !== false) {
        //         unset($firstLoadMeters[$key]);
        //     }
        // }

        // $baseMeters = array_values($firstLoadMeters);

        // $firstLoad  = 0;
        // $secondLoad = 0;
        // foreach ($baseMeters as $loadMeter) {
        //     $firstLoad += Reading::where([
        //         ['timestamp', '=', $from],
        //         ['type', '=', 'LOAD'],
        //         ['virtual_meter_id', '=', $loadMeter],
        //     ])->value('norm');

        //     $secondLoad += Reading::where([
        //         ['timestamp', '=', $to],
        //         ['type', '=', 'LOAD'],
        //         ['virtual_meter_id', '=', $loadMeter],
        //     ])->value('norm');
        // }

        $firstLoad = Reading::where([
            ['timestamp', '=', $from],
            ['type', '=', 'LOAD'],
        ])->sum('norm');

        $secondLoad = Reading::where([
            ['timestamp', '=', $to],
            ['type', '=', 'LOAD'],
        ])->sum('norm');

        // calculate consumption
        $consumption = $secondLoad - $firstLoad;

        // dd($consumption);

        $firstGeneration = Reading::where('timestamp', $from)
            ->where('type', 'GENERATOR')
            ->sum('norm');

        $secondGeneration = Reading::where('timestamp', $to)
            ->where('type', 'GENERATOR')
            ->sum('norm');

        $generation     = $secondGeneration - $firstGeneration;
        $losses         = $generation - $consumption;
        $percentageLoss = ($losses / $generation) * 100;

        $baseGenerators = Reading::where('timestamp', $from)
            ->where('type', 'GENERATOR')->get();
        $baseMeters = Reading::where([
            ['timestamp', '=', $to],
            ['type', '=', 'LOAD'],
        ])->get();

        $metersChart = new VirtualMeterDataChart;
        $metersChart->labels(['Load', 'Generators']);
        $metersChart->dataset('Virtual Meters', 'doughnut', [count($baseMeters), count($baseGenerators)])
            ->backgroundColor([
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
            ]);

        $readingChart = new VirtualMeterDataChart;
        $readingChart->labels(['Load', 'Generation', 'Losses']);
        $readingChart->dataset('Energy Readings (wh)', 'bar', [$consumption, $generation, $losses])
            ->backgroundColor([
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
            ]);

        // $areaChart = new VirtualMeterDataChart;
        // $areaChart->labels(['Accra', 'Tema', 'Akosombo', 'Takoradi', 'Prestea', 'Bolgatanga', 'Tamale', 'Techiman', 'Kumasi']);
        // $areaChart->dataset('Load - Meter Count', 'bar',
        //     [count($accra), count($tema),
        //         count($akosombo), count($takoradi),
        //         count($prestea), count($bolgatanga),
        //         count($tamale), count($techiman), count($kumasi)]
        // )
        //     ->backgroundColor([
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //         'rgb(255, 99, 132)',
        //     ]);

        return view('virtualMeters.losses', compact('baseMeters', 'baseGenerators', 'consumption', 'generation', 'losses', 'percentageLoss', 'metersChart', 'readingChart', 'fromDate', 'toDate', 'virtualMetersLoad', 'virtualMetersGenerators'));
    }

    public function refresh() {
        $apiURL = 'https://converge4.gridcogh.com/rest_api/api/v1/acquisition/virtual-meter/list';

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

        $response_meter_data = $client->request('GET', 'api/v1/acquisition/virtual-meter/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'content-type'  => 'application/json',
            ],
        ]);

        $meterdata = json_decode($response_meter_data->getBody()->getContents(), true);

        $virtualMeters = VirtualMeter::pluck('name', 'id');

        // dd(!$virtualMeters->contains('VM_CAPE_COAST_S2'));

        foreach ($meterdata['rows'] as $vm) {
            if (!$virtualMeters->contains($vm[1])) {
                VirtualMeter::create([
                    'node_id' => $vm[0],
                    'name'    => $vm[1],
                    'segment' => $vm[2],
                ]);
            }
        }

        // dd($meterdata);

        return redirect()->back();
    }

    // public function refresh() {
    //     GetVirtualMeterData::dispatch();
    // }

    public function load() {
        $virtualMeters = VirtualMeter::where('type', 'LOAD')->get();
        return view('virtualMeters.load', compact('virtualMeters'));
    }

    public function generation() {
        $virtualMeters = VirtualMeter::where('type', 'GENERATOR')->get();
        return view('virtualMeters.generation', compact('virtualMeters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VirtualMeter  $virtualMeter
     * @return \Illuminate\Http\Response
     */
    public function edit(VirtualMeter $virtualMeter) {
        return view('virtualMeters.form', compact('virtualMeter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VirtualMeter  $virtualMeter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VirtualMeter $virtualMeter) {
        $virtualMeter->update([
            'name'              => $request->name,
            'alias'             => $request->alias,
            'type'              => $request->type,
            'serial_number'     => $request->serial_number,
            'customer_id'       => $request->customer_id,
            'feeder_id'         => $request->feeder_id,
            'area_id'           => $request->area_id,
            'meter_location_id' => $request->meter_location_id,
            'load_type'         => $request->load_type,
        ]);

        return redirect()->route('virtual-meters.index');
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
