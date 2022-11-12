<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\VirtualMeter;
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
        $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("C:\\Users\\Kay\\Desktop\\telmeterdata.xlsx");
        $sheetData   = $spreadsheet->getActiveSheet()->toArray();
        $sheet       = $spreadsheet->getActiveSheet();

        for ($i = 0; $i < count($sheetData); $i++) {
            $meter = VirtualMeter::where('name', $sheetData[$i][3])->first();
            // dd($sheetData[9][1]);

            if (!is_null($meter)) {
                // dd($meter->name);
                // $meter->update([
                //     'type' => "LOAD",
                // ]);

                // $location = MeterLocation::where('name', $sheetData[$i][0])->first();

                // if (!is_null($location)) {
                //     $meter->update([
                //         'meter_location_id' => $location->id,
                //     ]);
                // }

                // $feeder = Feeder::where('number', $sheetData[$i][1])->first();

                // if (!is_null($feeder)) {
                //     $meter->update([
                //         'feeder_id' => $feeder->id,
                //     ]);
                // }

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
            'body'    => '{"userName":"gridcodev", "password":"Pa55w.rd"}',
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
            'body'    => '{"userName":"gridcodev", "password":"Pa55w.rd"}',
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
