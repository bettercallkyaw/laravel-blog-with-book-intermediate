<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $limited=5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth')->except(['index','show']);
     }

    public function index()
    {
       $posts=Post::latest()->simplePaginate($this->limited);
       return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $categories=[
        //     ['id'=>1,'name'=>'Polite'],
        //     ['id'=>2,'name'=>'Programming'],
        //     ['id'=>3,'name'=>'Teach']
        // ];
        $categories=Category::all();
        return view('posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request,[
            'image'=>'required|mimes:png,jpg,jpeg',
            'title'=>'required',
            'content'=>'required',
            'category_id'=>'required',
        ]);


       // Get Form Image
       $image = $request->file('image');
       if (isset($image)) {
          
          // Make Unique Name for Image 
         $currentDate = Carbon::now()->toDateString();
 $imageName =$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

       // Check Post Dir is exists
           if (!Storage::disk('public')->exists('posts')) {
              Storage::disk('public')->makeDirectory('posts');
           }

           // Resize Image for post and upload
           $postImage= Image::make($image)->resize(900,1125)->stream();
           Storage::disk('public')->put('posts/'.$imageName,$postImage);
        }else{
           $imageName = 'https://source.unsplash.com/random';
        } 


        $post=new Post();
        $post->image=$imageName;
        $post->title=$request->title;
        $post->content=$request->content;
        $post->category_id=$request->category_id;
        $post->user_id=auth()->user()->id;
        $post->save();
        return redirect()->route('all.posts')->with('successMsg','post added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::findOrFail($id);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
        //delete old image 
           if(Gate::allows('post-delete',$post)){
              //delete old image
              if (Storage::disk('public')->exists('posts/'.$post->image)) {
                Storage::disk('public')->delete('posts/'.$post->image);
               }
                $post->delete();
                return back()->with('status','post deleted successfully');
            }else{
                return back()->with('session','unauthorize');
            }
    }
}
