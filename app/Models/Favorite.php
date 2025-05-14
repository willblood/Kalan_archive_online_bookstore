<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id'];

    /**
     * Get the book that was favorited.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the user that favorited the book.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
