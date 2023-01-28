<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReading extends Model {
    use HasFactory;

    protected $fillable = ['customer_id', 'period_id', 'status'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function reading_period() {
        return $this->belongsTo(ReadingPeriod::class);
    }
}
