<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelSubscriptions extends Model
{
    use HasFactory, Uuid;
    protected $table = 'cancel_subscriptions';
    protected $fillable = [
        'id',
    ];
    public $incrementing  = false;
    
    // public function subscription()
    // {
    //     return $this->hasOne(subscription::class);
    // }
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
