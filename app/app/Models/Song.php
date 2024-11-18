<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['name','artist'];

    public function list_content()
    {
        return $this->hasMany('App\Models\List_content');
    }
}
