<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "title",
        "author",
        "description",
        "price",
        "stock",
        "e_book",
        "image",
        "category_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function isFavoritedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'book_id', 'id'); // Define the relationship
    }
}
