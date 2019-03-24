<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// For file upload
use Illuminate\Support\Facades\Storage;

// If manual SQL query is needed
//use DB;

// Use model
use App\Post;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Post::where('title', 'searchQ')->get();
        // DB::select('SELECT * FROM table');  - use DB;
        // Post::orderBy('created_at', 'desc')->take(1)->paginate(10);
        $data = [
            'posts' => Post::orderBy('created_at', 'desc')->paginate(10)
        ];
        return view('pages.posts.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //File upload
        if ($request->hasFile('cover_image')) {
            // Get filename with ext
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get filename without ext
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get filename ext
            $fileExt = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            //Uploads (First do: php artisan storage:link)
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = "placeholder.jpg";
        }
        
        // Create
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'post' => Post::find($id)
        ];
        return view('pages.posts.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $data = [
            'post' => $post
        ];

        // Check if correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'You do not have permission for that');
        }

        return view('pages.posts.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        //File upload
        if ($request->hasFile('cover_image')) {
            // Get filename with ext
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get filename without ext
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get filename ext
            $fileExt = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            //Uploads (First do: php artisan storage:link)
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        
        // Create
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // Check if correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'You do not have permission for that');
        }

        if($post->cover_image !== "placeholder.png"){
            // Delete image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
