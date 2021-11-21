<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'content'=>'required'
        ]);

        $comment=new Comment();
        $comment->content=$request->content;
        $comment->post_id=$request->post_id;
        $comment->user_id=auth()->user()->id;
        $comment->save();
        return redirect()->back()->with('successMsg','comment added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        // $comment=Comment::findOrFail($id);
        // $comment->delete();
        // return back()->with('status','comment deleted successfully');

        //no gate and policies with method
        // $comment=Comment::findOrFail($id);
        // if($comment->user_id==auth()->user()->id){
        //     $comment->delete();
        //     return back()->with('status','comment deleted successfully');
        // }else{
        //     return back()->with('error','unauthorize');
        // }

        //gate with allows method
        // $comment=Comment::findOrFail($id);
        // if(Gate::allows('comment-delete',$comment)){
        //     $comment->delete();
        //     return back()->with('status','comment deleted successfully');
        // }else{
        //     return back()->with('error','unauthorize');
        // }

        //gate with denies method
        $comment=Comment::findOrFail($id);
        if(Gate::denies('comment-delete',$comment)){
             return back()->with('error','unauthorize');
        }

        $comment->delete();
        return back()->with('status','comment deleted successfully');
    }
}
