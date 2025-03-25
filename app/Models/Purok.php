<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purok extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'barangay_id'];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}
