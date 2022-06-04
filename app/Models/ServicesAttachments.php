<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesAttachments extends Model
{
    protected $table = 'services_attachments';
    use HasFactory;
    public $incrementing = false;
    public function service()
    {
            return $this->belongsTo(Services::class);
    }
}
