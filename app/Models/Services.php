<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid as UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory, UUID, SoftDeletes;
    protected $table = 'services';
    protected $fillable = [
        'id', 'client_id',
    ];

    public $incrementing = false;

    public function Client()
    {
        return ($this->belongsTo(Clients::class));
    }
    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }
    public function industries()
    {
        return $this->belongsTo(Industries::class, "industry");
    }
    public function salesMethods()
    {
        return $this->belongsTo(SalesMethods::class, 'sales_method');
    }
}
