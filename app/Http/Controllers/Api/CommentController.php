<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
   

  public function newComment(Request $request)
{

    $request->validate([
        'comment' => 'required|string',
        'task_id' => 'required|exists:tasks,id', 
        'files.*' => 'file|max:2048',
    ]);

    $comment = new Comment();
    $comment->comment = $request->comment;
    $comment->task_id = $request->task_id; 
    $comment->user_id = auth()->user()->id;
    $comment->save();

    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $attachment = new Attachment();
            $attachment->comment_id = $comment->id;
            $attachment->filename = $file->getClientOriginalName(); 
            $attachment->mime_type = $file->getClientMimeType(); 
            $attachment->path = $file->store('attachments'); 
            $attachment->save();
        }
    }

    return response(['message' =>'Successful change'], Response::HTTP_OK);
  }


  public function deleteComment(Comment $comment)
  {
      $this->authorize('delete', $comment);

      $comment->delete();

      return response(['message' => 'Comment deleted'], Response::HTTP_OK);
  }


}
