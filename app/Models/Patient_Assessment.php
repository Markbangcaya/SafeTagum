<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient_Assessment extends Model
{
    use HasFactory;

    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $guarded = [];
    protected $table = 'patient_assessments';

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
