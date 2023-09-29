<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';
    protected $fillable = ['category_id', 'post_id']; //for batch saving of data
    public $timestamps = false; //disable creating timestamp for created_at and updated_at

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
