<?php

namespace App\Providers;

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
    }
}
