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
    protected $table = 'tokenizeds';
    protected $guard_name = 'api';
    protected $guarded = [];
    const created_at = 'tokenized_created_at'; // Important: Specify the new created_at column name
    const updated_at = 'tokenized_updated_at';
    const id = 'tokenized_id'; // Important: Specify the new created_at column name

    public function patient()
    {
        return $this->hasMany(Patient::class, 'token');
    }
}
