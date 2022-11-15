<?php

namespace App\Jobs;

use App\Models\Reading;
use App\Models\VirtualMeter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetVirtualMeterData implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $virtualMeters = VirtualMeter::where('type', 'LOAD')->get();
        // $consumptionData = [];
        foreach ($virtualMeters as $virtualMeter) {
            $data = $this->getMeterData($virtualMeter, 1632, "2022-10-01T00:00:00Z", "2022-10-01T00:00:00Z");
            // array_push($consumptionData, $data);

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
    }
}
