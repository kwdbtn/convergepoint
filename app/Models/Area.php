<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model {
    use HasFactory;

    protected $fillable = ['name', 'active'];

    public function meter_locations() {
        return $this->hasMany(MeterLocation::class);
    }

    public function virtual_meters() {
        return $this->hasMany(VirtualMeter::class);
    }
}
