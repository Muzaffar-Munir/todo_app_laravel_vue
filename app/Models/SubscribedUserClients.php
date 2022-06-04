<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubscribedUserClients extends Model
{
    use HasFactory, Uuid;
    protected $table = 'subscribed_user_clients';
    protected $fillable = [
        'id',
    ];

    public $incrementing = false;

    public function client()
    {
        return $this->belongsTo(Clients::class,"client_id");
    }
    public function freelancer()
    {
        return $this->belongsTo(Freelancers::class);
    }
}
