<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    protected $table = 'announcement';
    protected $fillable = ['title', 'content'];
    //
}
