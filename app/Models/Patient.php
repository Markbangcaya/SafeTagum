<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $guarded = [];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class, 'type_of_disease');
    }
    public function patient_assessment()
    {
        return $this->hasMany(Patient_Assessment::class);
    }
    public function tokenized()
    {
        return $this->belongsTo(Tokenized::class, 'lastname');
    }
}
