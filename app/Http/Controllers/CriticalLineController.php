<?php

namespace App\Http\Controllers;

use App\Charts\VirtualMeterDataChart;
use App\Models\CriticalLine;
use App\Models\VirtualMeter;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

class LineLoss {
    public $line;
    public $from;
    public $to;
    public $source;
    public $sourceDataPreviousValue;
    public $sourceDataPresentValue;
    public $sourceLoss;
    public $destination;
    public $destinationDataPreviousValue;
    public $destinationDataPresentValue;
    public $destinationLoss;
    public $loss;
    public $percentageLoss;
}

class LossAverage {
    public $today;
    public $yesterday;
    public $average;
}

class CriticalLineController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $lines = CriticalLine::all();
        return view('criticalLines.index', compact('lines'));
    }

    public function showQueryPage(CriticalLine $criticalline) {
        return view('criticalLines.query', compact('criticalline'));
    }

    public function showQueryPageAll() {
        return view('criticalLines.queryAll');
    }

    public function getQueryResults(Request $request) {
        $line = CriticalLine::where('id', $request->criticalLines)->first();
        $source = VirtualMeter::where('name', $line->source)->first();
        $destination = VirtualMeter::where('name', $line->destination)->first();

        $dateSelected = $request->from;
        $to = Carbon::parse($dateSelected);
        $tox = Carbon::parse($dateSelected);
        $from = $tox->subDay();

        $sourceDataPrevious = $this->getMeterData($source, 1632, $from, $from);
        $sourceDataPreviousValue = $sourceDataPrevious[0]['f0'];

        $sourceDataPresent = $this->getMeterData($source, 1632, $to, $to);
        $sourceDataPresentValue = $sourceDataPresent[0]['f0'];

        $sourceLoss = $sourceDataPresentValue - $sourceDataPreviousValue;

        $destinationDataPrevious = $this->getMeterData($destination, 1633, $from, $from);
        $destinationDataPreviousValue = $destinationDataPrevious[0]['f0'];

        $destinationDataPresent = $this->getMeterData($destination, 1633, $to, $to);
        $destinationDataPresentValue = $destinationDataPresent[0]['f0'];

        $destinationLoss = $destinationDataPresentValue - $destinationDataPreviousValue;

        $loss = $sourceLoss - $destinationLoss;
        $percentageLoss = ($loss / $sourceLoss) * 100;

        // dd($sourceDataPrevious[0]['f0'], $sourceDataPresent[0]['f0'], $destinationDataPrevious[0]['f0'], $destinationDataPresent[0]['f0']);
        // dd($sourceLoss, $destinationLoss);
        // dd($percentageLoss);

        return view('criticalLines.queryResults', compact('source', 'destination', 'sourceDataPreviousValue', 'sourceDataPresentValue', 'sourceLoss', 'destinationDataPreviousValue', 'destinationDataPresentValue', 'destinationLoss', 'loss', 'percentageLoss'));
    }

    public function getLineLoss($line, $from, $to) {
        $source = VirtualMeter::where('name', $line->source)->first();
        $destination = VirtualMeter::where('name', $line->destination)->first();

        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        $sourceDataPrevious = $this->getMeterData($source, 1632, $from, $from);
        $sourceDataPreviousValue = $sourceDataPrevious[0]['f0'];

        $sourceDataPresent = $this->getMeterData($source, 1632, $to, $to);
        $sourceDataPresentValue = $sourceDataPresent[0]['f0'];

        $sourceLoss = $sourceDataPresentValue - $sourceDataPreviousValue;

        $destinationDataPrevious = $this->getMeterData($destination, 1633, $from, $from);
        $destinationDataPreviousValue = $destinationDataPrevious[0]['f0'];

        $destinationDataPresent = $this->getMeterData($destination, 1633, $to, $to);
        $destinationDataPresentValue = $destinationDataPresent[0]['f0'];

        $destinationLoss = $destinationDataPresentValue - $destinationDataPreviousValue;

        $loss = $sourceLoss - $destinationLoss;
        $percentageLoss = ($loss / $sourceLoss) * 100;

        $lineLoss = new LineLoss();
        $lineLoss->line = $line;
        $lineLoss->from = $from;
        $lineLoss->to = $to;
        $lineLoss->source = $source;
        $lineLoss->sourceDataPreviousValue = $sourceDataPreviousValue;
        $lineLoss->sourceDataPresentValue = $sourceDataPresentValue;
        $lineLoss->sourceLoss = $sourceLoss;
        $lineLoss->destination = $destination;
        $lineLoss->destinationDataPreviousValue = $destinationDataPreviousValue;
        $lineLoss->destinationDataPresentValue = $destinationDataPresentValue;
        $lineLoss->destinationLoss = $destinationLoss;
        $lineLoss->loss = $loss;
        $lineLoss->percentageLoss = $percentageLoss;

        return $lineLoss;
    }

    public function getQueryResultsAll(Request $request) {
        $line = CriticalLine::where('id', $request->criticalLines)->first();
        $source = VirtualMeter::where('name', $line->source)->first();
        $destination = VirtualMeter::where('name', $line->destination)->first();

        $dateSelectedFrom = $request->from;
        $dateSelectedTo = $request->to;
        $to = Carbon::parse($dateSelectedTo);
        $from = Carbon::parse($dateSelectedFrom);

        $fromx = Carbon::parse($dateSelectedFrom);

        $lossArray = [];

        $days = $to->diffInDays($from);

        for ($i = 0; $i < $days; $i++) {
            $tox = $fromx->copy()->addDay();
            $xlineLoss = $this->getLineLoss($line, $fromx, $tox);
            array_push($lossArray, $xlineLoss);
            $fromx = $fromx->addDay();
        }

        $labels = [];
        $losses = [];

        foreach ($lossArray as $lossItem) {
            array_push($labels, $lossItem->to);
            array_push($losses, $lossItem->percentageLoss);
        }

        $readingChart = new VirtualMeterDataChart;
        $readingChart->labels($labels);
        $readingChart->dataset('Loss %', 'line', $losses)
            ->backgroundColor([
                'rgba(255, 99, 132, 0.2)',
            ]);

        return view('criticalLines.queryResultsAll', compact('lossArray', 'from', 'to', 'readingChart'));
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

    public function dailyAverageLosses() {
        $lineLosses = [];
        $today = Carbon::today();
        $yesterday = $today->copy()->subDay();

        $criticalLines = CriticalLine::where('active', true)->get();

        foreach ($criticalLines as $criticalLine) {
            $lineLoss = $this->getLineLoss($criticalLine, $yesterday, $today);

            $criticalLine->update([
                'loss' => $lineLoss->percentageLoss,
                'loss_date' => Carbon::today()
            ]);

            array_push($lineLosses, $lineLoss);
        }

        $labels = [];
        $losses = [];
        $sum = 0;

        foreach ($lineLosses as $lossItem) {
            array_push($labels, $lossItem->line->name);
            array_push($losses, round($lossItem->percentageLoss, 2));
            $sum += round($lossItem->percentageLoss, 2);
        }

        $average = $sum / count($lineLosses);

        $readingChart = new VirtualMeterDataChart;
        $readingChart->labels($labels);
        $readingChart->dataset('Loss %', 'bar', $losses)
            ->backgroundColor([
                'rgba(255, 99, 132, 0.2)',
            ]);

        return view('criticalLines.dailyAverageResults', compact('lineLosses', 'yesterday', 'today', 'average', 'readingChart'));

        // dd($lineLosses);
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
     * @param  \App\Models\CriticalLine  $criticalLine
     * @return \Illuminate\Http\Response
     */
    public function show(CriticalLine $criticalLine) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CriticalLine  $criticalLine
     * @return \Illuminate\Http\Response
     */
    public function edit(CriticalLine $criticalLine) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CriticalLine  $criticalLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CriticalLine $criticalLine) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CriticalLine  $criticalLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(CriticalLine $criticalLine) {
        //
    }
}
