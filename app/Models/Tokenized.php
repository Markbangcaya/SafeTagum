<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Tokenized extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $connection = 'safetagumtokens';
    protected $guard_name = 'api';
    protected $guarded = [];
}
