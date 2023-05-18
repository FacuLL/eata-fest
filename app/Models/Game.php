<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;

class Game extends Model
{
    use HasFactory;

    protected  $primaryKey = 'id';

    protected $fillable = [
        'name',
        'logo_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_game');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
