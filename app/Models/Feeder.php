<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeder extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'active'];

    public function virtual_meters() {
        return $this->hasMany(VirtualMeter::class);
    }
}
