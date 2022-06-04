<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid as UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class Freelancers extends Model
{
    use HasFactory, UUID, SoftDeletes;
    protected $table = 'freelancers';
    protected $fillable = [
        'id', 'user_id',
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];


    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function industries()
    {
        return $this->belongsTo(Industries::class, "industry");
    }
    public function Mysubscriptions()
    {
        return $this->hasMany(SubscribedUserClients::class, "freelancer_id")->select('client_id');
    }
}
