<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    public function index()
    {
        $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(10);
        // To get the count of the posts without categories
        $uncategorized_count = 0;
        $all_posts = $this->post->all();
        foreach ($all_posts as $post) {
            if ($post->categoryPost->count() == 0) {
                $uncategorized_count++;
            }
        }

        /**
         * posts table
         * 1
         * 2
         * 3
         * 4
         *
         * category_post table
         * post_id | category_id
         * 1           2
         * 2           3
         * 2           1
         *
         * PART: $all_posts = $this->post->all();  // result all the post enrties
         * Iteration #1: post id = 1
         *
         * if($post->categoryPost->count == 0) , result = FALSE
         * $uncategorized_count = 0
         *
         * Iteration #2: post id = 2
         *
         * if($post->categoryPost->count == 0) , result = FALSE
         * $uncategorized_count = 0
         *
         * Iteration #3: post id = 3
         *
         * if($post->categoryPost->count == 0) , result = TRUE
         * $uncategorized_count = $uncategorized_count + 1
         *                      = 0  + 1
         *                      = 1 (final value)
         *
         * Iteration #4: post id = 4
         *
         * if($post->categoryPost->count == 0) , result = TRUE
         * $uncategorized_count = $uncategorized_count + 1
         *                      =  1  + 1
         *                      = 2
         *
         * FINAL RESULT $uncategorized_count after loop exit = 2
         */

        return view('admin.categories.index')
            ->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name'
        ]);
        $this->category->name = ucwords(strtolower($request->name));
        /**
         * input = ACAdeme
         * PART: strtolower($request->name)   => input = academe
         * strtolower() converts input to all lowercase
         * PART: ucwords()                    => input = Academe
         * ucwords() coverts input's first letter to upper case
         */

        $this->category->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'new_name' => 'required|min:1|max:50|unique:categories,name,' . $id
        ]);
        $category = $this->category->findOrFail($id);
        $category->name = ucwords(strtolower($request->new_name));

        $category->save();
        return redirect()->back();
    }

    public function destroy($id){
        $this->category->destroy($id);
        return redirect()->back();
    }

}
