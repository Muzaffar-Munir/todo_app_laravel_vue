<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsctiptions extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    public $incrementing = false;

    public function client()
    {
        return $this->hasOne(Clients::class);
    }
}
