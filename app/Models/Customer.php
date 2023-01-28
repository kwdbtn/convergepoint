<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    use HasFactory;

    protected $fillable = ['name', 'active'];

    public function virtual_meters() {
        return $this->hasMany(VirtualMeter::class);
    }

    public function customer_readings() {
        return $this->hasMany(CustomerReading::class);
    }

    public function reading_periods() {
        return $this->hasMany(ReadingPeriod::class);
    }
}
