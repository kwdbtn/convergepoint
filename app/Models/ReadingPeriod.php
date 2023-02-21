<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingPeriod extends Model {
    use HasFactory;

    protected $fillable = ['name', 'month', 'year'];

    public function customer_readings() {
        return $this->hasMany(CustomerReading::class);
    }
}
