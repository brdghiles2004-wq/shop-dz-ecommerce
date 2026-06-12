<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($cat) {
            $cat->slug = Str::slug($cat->name);
        });
    }
}