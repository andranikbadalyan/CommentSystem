<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    public function index()
    {
        return Comment::orderBy('id', 'desc')->get();
    }

    public function store(CommentRequest $request){
        $comment = new Comment();
        $comment->name = $request->name;
        $comment->comment = $request->comment;
        $comment->save();

        if($request->parent_id){
            $parent = Comment::find($request->parent_id);
            $comment->reply($parent);
        }

        return $comment;
    }

    public function truncate(){
        Comment::query()->truncate();
    }
}
