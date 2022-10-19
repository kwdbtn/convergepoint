<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualMeter extends Model {
    use HasFactory;

    protected $fillable = ['node_id', 'name', 'segment', 'serial_number'];

    public function readings() {
        return $this->hasMany(Reading::class);
    }
}
