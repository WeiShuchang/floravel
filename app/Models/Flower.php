<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'picture', 'price', 'category_id'];

    public function getFlowerPictureUrlAttribute()
    {
        if ($this->picture) {
            return asset('storage/flower/' . $this->picture);
        }
   
    }
    
public function category()
{
    return $this->belongsTo(Category::class);
}

}
