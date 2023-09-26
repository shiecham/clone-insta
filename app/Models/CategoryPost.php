<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;


    /*
    OOP
    class >blueprint of a structure of data

     class parts are:
     1)Properties
     2)MEthods

     Propaties visabillity
    protected
    private
     public
     */


    protected $table = 'category_post';
    protected $fillable = ['category_id', 'post_id']; //for batch saving of data
    public $timestamps = false; //disable creating timestamp for created_at and updated_at


    // To get the name of the category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // // To get the name of the category
    // public function pots()
    // {
    //     return $this->belongsTo(Post::class);
    // }
}
