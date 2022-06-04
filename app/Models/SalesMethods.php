<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMethods extends Model
{
    use HasFactory,Uuid;
    protected $table = 'sales_methods';

    public $incrementing = false;
}
