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
        'files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $comment = new Comment();
    $comment->comment = $request->comment;
    $comment->task_id = $request->task_id; 
    $comment->user_id = auth()->user()->id;
    $comment->save();

    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->store('public/attachments');

            $attachment = new Attachment();
            $attachment->filename = $filename;
            $attachment->path = $path;
            $attachment->mime_type = $file->getClientMimeType();
            $attachment->comment_id = $comment->id;
            $attachment->save();
            echo($attachment);
          }
        }
        
        return response(['message' =>'Comment with files attached successfully'], Response::HTTP_OK);
}


  public function deleteComment(Comment $comment)
  {
      $this->authorize('delete', $comment);

      $comment->delete();

      return response(['message' => 'Comment deleted'], Response::HTTP_OK);
  }


}