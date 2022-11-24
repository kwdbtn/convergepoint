<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model {
    use HasFactory;

    protected $fillable = ['name', 'timestamp', 'norm', 'norm_unit', 'virtual_meter_id, type'];

    public function virtualMeter() {
        return $this->belongsTo(VirtualMeter::class);
    }
}
