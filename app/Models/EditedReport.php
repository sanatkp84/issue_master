<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditedReport extends Model
{
    protected $table = 'edited_records';
    
    protected $fillable = [
        'user_id',
        'detail'
    ];

    use HasFactory;
}

