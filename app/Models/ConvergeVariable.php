<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvergeVariable extends Model {
    use HasFactory;

    protected $fillable = ['name', 'description', 'obis', 'pvmCount', 'type'];

    public function convergeVariableType() {
        return $this->belongsTo(ConvergeVariableType::class);
    }
}
