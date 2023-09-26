<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }
    public function create()
    {
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);
        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        // dd($post);


        // Resuriction for the login user to just edit his/her own post. Redirect to homepage
        if (Auth::user()->id != $post->user->id) {
            return redirect()->route('index');
        }
        $all_categories = $this->category->all();


        // dd($all_categories);

        $selected_categories = [];
        // post id = 1

        foreach ($post->categoryPost as $category_post) {
            $selected_categories[] = $category_post->category_id;
            // echo "$category_post->category_id <br>";
        }

        // dd($post->categoryPost);

        // dd($selected_categories);

        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id)
    {
        #1 Validation
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpg,png,jpeg,gif|max:1048',

        ]);

        #2 Update a post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        if ($request->image) {
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        #3 delete old entries of a post in pivot table and create a new one
        $post->categoryPost()->delete();
        /*
        *
        *  $category_post = [
        *     'category_id' =>1,
        *     'category_id' =>2,
        *       ]
        */
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];
        }

        $post->categoryPost()->createMany($category_post);
        return redirect()->route('post.show', $id);
    }

    public function destroy($id)
    {
    $post = $this->post->findOrFail($id);
    $post->forceDelete();
    return redirect()->route('index');
    }




    public function store(Request $request)
    {
        // dd($request);//die and debug
        // 1:Validate
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);
        // dd('hi');

        // 2:save the new entries in to the posts tabel
        $this->post->user_id = Auth::user()->id;
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        // 3:save the new entries in to the pivot tabel(category_post)
        /**
         * SIMULATE:
         * intial state
         *$category_post = []
         *user  selected Travle = category->id= 1, Food = category->id= 2
         *
         * $request->category = [1,2]
         *
         * ITR #1:
         *  $category_post = [
         *     'category_id' =>1,
         *     ]
         * iteration (1<=5)
         * ITR #2:
         *  $category_post = [
         *     'category_id' =>1,
         *     'category_id' =>2,
         *       ]
         */
        foreach ($request->category as $category_id) {
            $category_post[] = [
                'category_id' => $category_id
            ];


            $this->post->categoryPost()->createMany($category_post);
            return redirect()->route('index');
        }
    }
}
