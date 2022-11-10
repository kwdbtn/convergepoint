<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterLocation extends Model {
    use HasFactory;

    protected $fillable = ['name', 'area_id', 'active'];

    public function area() {
        return $this->belongTo(Area::class);
    }

    public function virtual_meters() {
        return $this->hasMany(VirtualMeter::class);
    }
}
