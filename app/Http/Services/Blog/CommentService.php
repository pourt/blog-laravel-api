<?php 

namespace App\Http\Services\Blog;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\AddReplyRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;

class CommentService 
{
    public function addComment(AddCommentRequest $request)
    {
        $request->validated();

        $comment = Comment::create($request->toArray());

        if (! $comment) {
            throw new \Exception("Unable to add comment.", 500);
        }

        return $comment;
    }
    
    public function getComments()
    {
        $comments = Comment::with(['replies' => function($query) {
                                $query->where('comment_id', '!=', null);
                            }])
                            ->where('comment_id', '=', null)
                            ->orderBy('created_at', 'DESC')
                            ->get();

        if (! $comments) {
            throw new \Exception("Unable to retrieve blog post.", 404);
        }

        return (new CommentCollection($comments));
    }
}