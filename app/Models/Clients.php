<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid as UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use HasFactory, UUID, SoftDeletes;
    protected $table = 'clients';
    protected $fillable = [
        'id',
    ];
    public $incrementing  = false;

    public function CancelSubscription()
    {
        return $this->hasOne(CancelSubscriptions::class);
    }
    public function services()
    {
        return $this->hasMany(Services::class,'client_id');
    }
    public function User()
    {
        return  $this->belongsTo(User::class);
    }
    public function Subscription()
    {
        return $this->belongsTo(Subsctiptions::class);
    }
}
