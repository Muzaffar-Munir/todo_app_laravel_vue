<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAppliedJob extends Model
{
    use HasFactory, Uuid;
    protected $table = 'user_applied_jobs';
    public $incrementing = false;
    protected $keyType = 'string';

    public function freelancer()
    {
        return $this->belongsTo(Freelancers::class);
    }
    public function service()
    {
        return $this->belongsTo(Services::class,"service_id");
    }
}
