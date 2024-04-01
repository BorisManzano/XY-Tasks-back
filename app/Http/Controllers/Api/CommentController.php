<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function allComments($task_id){
        $comments = Comment::where('task_id', $task_id)->get();
        return response($comments, Response::HTTP_OK);
    }
    public function newComment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'task_id' => 'required|exists:tasks,id',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
    
        $task = Task::find($request->task_id);
    
        if ($task) {
            $comment = new Comment([
                'comment' => $request->comment,
                'user_id' => auth()->user()->id,
            ]);
    
            if ($request->hasFile('files')) {
                $comment->has_attachment = true;
            }
    
            $task->comments()->save($comment);
    
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    if ($file->isValid()) {
                        $filename = $file->getClientOriginalName();
                        $path = $file->store('public/storage');
                        $attachment = new Attachment([
                            'filename' => $filename,
                            'path' => $path,
                            'mime_type' => $file->getClientMimeType(),
                        ]);
                        $comment->attachments()->save($attachment);
                    } else {
                        logger('El archivo no es valido: ' . $file->getClientOriginalName());
                    }
                }
            }
    
            return response(['message' =>'Comentario agregado correctamente.'], Response::HTTP_OK);
        } else {
            return response(['message' => 'Tarea no encontrada.'], Response::HTTP_NOT_FOUND);
        }
    }


    public function getAttachments($commentId)
    {
        $comment = Comment::with('attachments')->findOrFail($commentId);

        $attachments = $comment->attachments->map(function ($attachment) {
            return [
                'id' => $attachment->id,
                'filename' => $attachment->filename,
                'url' => route('attachments.download', $attachment->id),
            ];
        });

        return response()->json(['attachments' => $attachments]);
    }

    public function downloadAttachment($attachmentId)
    {
        $attachment = Attachment::findOrFail($attachmentId);
        return Storage::download($attachment->path, $attachment->filename);
    }



    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);

        try {
            $comment->delete();

            return response()->json(['message' => 'Comment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting comment', 'error' => $e->getMessage()], 500);
        }
    }
    
    
}