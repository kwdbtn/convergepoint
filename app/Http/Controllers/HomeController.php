<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Feeder;
use App\Models\MeterLocation;
use App\Models\Reading;
use App\Models\VirtualMeter;
use Carbon\Carbon;
use GuzzleHttp\Client;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $virtualMeters   = VirtualMeter::where('type', 'IMPORT/EXPORT')->get();
        $consumptionData = [];
        foreach ($virtualMeters as $virtualMeter) {
            $data = $this->getMeterData($virtualMeter, 17770, "2023-04-01T00:00:00Z", "2023-04-01T00:00:00Z");
            // dd($data);
            // array_push($consumptionData, $data);

            foreach ($data as $datum) {
                Reading::create([
                    'name'               => '-A*kwh',
                    'timestamp'          => $datum['t'],
                    'norm'               => $datum['f0'],
                    'norm_unit'          => $datum['f2'],
                    'virtual_meter_id'   => $virtualMeter->id,
                    'virtual_meter_name' => $virtualMeter->name,
                    'node_id'            => $virtualMeter->node_id,
                    'serial_number'      => $virtualMeter->serial_number,
                    'type'               => 'GENERATOR',
                ]);
            }
        }

        // $virtualMeters   = VirtualMeter::where('type', 'GENERATOR')->get();
        // $consumptionData = [];
        // foreach ($virtualMeters as $virtualMeter) {
        //     $data = $this->getMeterData($virtualMeter, 1632, "2022-09-01T00:00:00Z", "2022-09-30T00:00:00Z");
        //     // dd($data);
        //     // array_push($consumptionData, $data);

        //     foreach ($data as $datum) {
        //         Reading::create([
        //             'name'             => 'XNU_A+',
        //             'timestamp'        => $datum['t'],
        //             'norm'             => $datum['f0'],
        //             'norm_unit'        => $datum['f2'],
        //             'virtual_meter_id' => $virtualMeter->id,
        //             'type'             => 'GENERATOR',
        //         ]);
        //     }
        // }

        // dd(count($consumptionData));

        // $firstLoad = Reading::where('timestamp', "2022-10-01T00:00:00Z")
        //     ->where('type', 'LOAD')
        //     ->sum('norm');
        // $secondLoad = Reading::where('timestamp', "2022-11-01T00:00:00Z")
        //     ->where('type', 'LOAD')
        //     ->sum('norm');
        // $consumption = $secondLoad - $firstLoad;

        // $firstGeneration = Reading::where('timestamp', "2022-10-01T00:00:00Z")
        //     ->where('type', 'GENERATOR')
        //     ->sum('norm');
        // $secondGeneration = Reading::where('timestamp', "2022-11-01T00:00:00Z")
        //     ->where('type', 'GENERATOR')
        //     ->sum('norm');
        // $consumption = $secondLoad - $firstLoad;
        // $generation  = $secondGeneration - $firstGeneration;
        // $loss        = $generation - $consumption;
        // // dd($generation);
        // dd(($loss / $generation) * 100);

        dd('done');
    }

    public function index_store_readings() {
        $virtualMeters = VirtualMeter::all();
        foreach ($virtualMeters as $virtualMeter) {
            $data = $this->getMeterData($virtualMeter, 1632, "2022-01-01T00:00:00Z", "2022-11-12T00:00:00Z");

            foreach ($data as $datum) {
                Reading::create([
                    'name'             => 'XNU_A+',
                    'timestamp'        => $datum['t'],
                    'norm'             => $datum['f0'],
                    'norm_unit'        => $datum['f2'],
                    'virtual_meter_id' => $virtualMeter->id,
                ]);
            }
        }

        dd(true);
    }

    public function getMeterData(VirtualMeter $virtualMeter, $variable, $from, $to) {
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $client = new Client([
            'base_uri' => 'https://ksi-ent-cba-01.gridcogh.com/rest_api/',
            // 'base_uri' => 'https://converge4.gridcogh.com/rest_api/',
            'verify'   => false,
        ]);

        $response = $client->request('POST', 'api/v1/login/user-login', [
            'headers' => $headers,
            'body'    => '{"userName":"kwadwo", "password":"wyn8ega-udg4RPQ@qhv"}',
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

    public function index_update_excel() {
        $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("C:\\Users\\kwadwo.boateng\\Desktop\\telmeterdata.xlsx");
        $sheetData   = $spreadsheet->getActiveSheet()->toArray();
        $sheet       = $spreadsheet->getActiveSheet();

        for ($i = 0; $i < count($sheetData); $i++) {
            // dd($sheetData[$i][0]);
            $meter = VirtualMeter::where('name', $sheetData[$i][3])->first();
            // dd($sheetData[9][1]);

            if (!is_null($meter)) {
                // dd($meter->name);
                $meter->update([
                    'type'          => "GENERATOR",
                    'serial_number' => $sheetData[$i][4],
                ]);

                $location = MeterLocation::where('name', $sheetData[$i][0])->first();

                if (!is_null($location)) {
                    $meter->update([
                        'meter_location_id' => $location->id,
                    ]);
                }

                $feeder = Feeder::where('number', $sheetData[$i][1])->first();

                if (!is_null($feeder)) {
                    $meter->update([
                        'feeder_id' => $feeder->id,
                    ]);
                }

                $customer = Customer::where('name', $sheetData[$i][2])->first();

                if (!is_null($customer)) {
                    $meter->update([
                        'customer_id' => $customer->id,
                    ]);
                }
            }
        }

        dd(true);
    }

    public function index_meter_data() {
        // $apiURL = 'https://ksi-ent-cba-01.gridcogh.com/rest_api/api/v1/login/user-login';
        $apiURL = 'https://converge4.gridcogh.com/rest_api/api/v1/login/user-login';

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
            'body'    => '{"userName":"kwadwo", "password":"wyn8ega-udg4RPQ@qhv"}',
        ]);

        $statusCode   = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        $token        = $responseBody["token"];

        $body = [
            "virtualMeters"             => [
                [
                    "virtualMeterId" => 199752,
                    "variableIds"    => [
                        16007,
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

        dd($meterdata);

        return view('home');
    }

    public function virtual_meters() {
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
            'body'    => '{"userName":"kwadwo", "password":"wyn8ega-udg4RPQ@qhv"}',
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

        // foreach ($meterdata['rows'] as $vm) {
        //     VirtualMeter::create([
        //         'node_id' => $vm[0],
        //         'name'    => $vm[1],
        //         'segment' => $vm[2],
        //     ]);
        // }

        dd($meterdata);

        return view('home');
    }

    public function indexz() {
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
            'body'    => '{"userName":"kwadwo", "password":"wyn8ega-udg4RPQ@qhv"}',
        ]);

        $statusCode   = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        $token        = $responseBody["token"];

        $response_meter_data = $client->request('GET', 'api/v1/acquisition/variable/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'content-type'  => 'application/json',
            ],
        ]);

        $meterdata = json_decode($response_meter_data->getBody()->getContents(), true);

        foreach ($meterdata as $vm) {
            // ConvergeVariable::create([
            //     'name'     => $vm['name'],
            //     'obis'     => $vm['obis'],
            //     'pvmCount' => $vm['pvmCount'],
            //     'type'     => $vm['type'],
            // ]);
        }

        dd($meterdata);

        return view('home');
    }
}
