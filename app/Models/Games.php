<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Games extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = ['mod', 'is_over'];

}
