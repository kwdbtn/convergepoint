<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualMeter extends Model {
    use HasFactory;

    protected $fillable = ['node_id', 'name', 'segment', 'serial_number', 'customer_id', 'feeder_id', 'meter_location_id', 'type', 'active'];

    public function readings() {
        return $this->hasMany(Reading::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function feeder() {
        return $this->belongsTo(Feeder::class);
    }

    public function meter_location() {
        return $this->belongsTo(MeterLocation::class);
    }

    public function area() {
        return $this->belongsTo(Area::class);
    }
}
