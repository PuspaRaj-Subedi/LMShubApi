<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Borrow;


class Book extends Model
{
    use HasFactory;

    public function borrow()
    {
        return $this->hasMany(Borrow::class);
    }
}
