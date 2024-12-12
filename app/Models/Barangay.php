<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barangay extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $guarded = [];
    protected $hidden = ['geometry'];

    public function patient()
    {
        return $this->hasMany(Patient::class,);
    }
}
