<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'sales';
    public $incrementing  = false;
    
    public function Service(){
        return $this->hasOne(Services::class);
    }
    public function Freelancer(){
        return $this->hasOne(Freelancers::class);
    }
}
