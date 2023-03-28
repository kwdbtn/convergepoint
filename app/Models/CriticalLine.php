<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalLine extends Model {
    use HasFactory;

    protected $fillable = ['name', 'source', 'destination', 'loss_date', 'loss', 'active'];
}
