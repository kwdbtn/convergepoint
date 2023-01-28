<?php

namespace App\Providers;

use App\Models\Area;
use App\Models\Customer;
use App\Models\Feeder;
use App\Models\MeterLocation;
use App\Models\VirtualMeter;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        view()->composer(['virtualMeters.query', 'virtualMeters.queryResults'], function ($view) {

            $arr = [
                'virtualMeters' => VirtualMeter::pluck('name', 'id'),
                'variables'     => [
                    '+A'           => '+A', '+R'              => '+R', '+S'                     => '+S', 'PF'                    => 'PF',
                    'XNU_A+'       => 'XNU_A+', 'XNU_R+'      => 'XNU_R+', '+A*Energy*Kwh'      => '+A*Energy*Kwh', '+A*MaxD*Kw' => '+A*MaxD*Kw',
                    '+A*MaxD*Kw*'  => '+A*MaxD*Kw*', '+E*'    => '+E*', '+E*Power'              => '+E*Power', '+R*'             => '+R*',
                    '+R*AvDem'     => '+R*AvDem', '+R*AvDem*' => '+R*AvDem*', '+R*Energy*Kvarh' => '+R*Energy*Kvarh', '+R*Power' => '+R*Power',
                    '+S*'          => '+S*', '+VA*Dem'        => '+VA*Dem', '+VA*Dem*'          => '+VA*Dem*', 'PowerFactor'     => 'PowerFactor',
                    'PowerFactor*' => 'PowerFactor*',
                ],
            ];

            $view->with('arr', $arr);
        });

        view()->composer('variables.form', function ($view) {
            $types = [
                0 => 'Billing Value',
                1 => 'Load Profile',
            ];

            $view->with('types', $types);
        });

        view()->composer('virtualMeters.form', function ($view) {
            $arr = [
                'types'           => [
                    'LOAD'        => 'LOAD',
                    'GENERATOR'   => 'GENERATOR',
                    'LINE'        => 'LINE',
                    'CHECK METER' => 'CHECK METER',
                    'SPARE METER' => 'SPARE METER',
                ],

                'load_types'      => [
                    'CUSTOMER'        => 'CUSTOMER',
                    'STATION SERVICE' => 'STATION SERVICE',
                    null              => 'LINE/GENERATOR',
                ],

                'customers'       => Customer::orderBy('name', 'asc')->pluck('name', 'id'),
                'feeders'         => Feeder::orderBy('number', 'asc')->pluck('number', 'id'),
                'areas'           => Area::orderBy('name', 'asc')->pluck('name', 'id'),
                'meter_locations' => MeterLocation::orderBy('name', 'asc')->pluck('name', 'id'),
            ];

            $view->with('arr', $arr);
        });

        view()->composer('customerReadings.query', function ($view) {
            $arr = [
                'months' => [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                ],

                'years'  => [
                    2022 => '2022',
                    2023 => '2023',
                ],
            ];

            $view->with('arr', $arr);
        });
    }
}
