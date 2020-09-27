<?php

namespace App\Models;
use App\Models\User;
use App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    public function User()
        {
            return $this->belongsTo(User::class);
        }
        public function Book()
        {
            return $this->belongsTo(Book::class);
        }

}
