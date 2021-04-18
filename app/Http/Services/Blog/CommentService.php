<?php 

namespace App\Http\Services\Blog;

use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;

class CommentService 
{
    public function addComment(AddCommentRequest $request, $postId)
    {
        $request['post_id'] = $postId;

        $request->validated();

        $comment = Comment::create($request->toArray());

        if (! $comment) {
            throw new \Exception("Unable to add comment.", 500);
        }

        return $comment;
    }
    
    public function getComments(int $postId)
    {
        $comments = Comment::with(['replies'])
                            ->wherePostId($postId)
                            ->orderBy('created_at', 'DESC')
                            ->get();

        if (! $comments) {
            throw new \Exception("Unable to retrieve blog post.", 404);
        }

        return $comments;
    }
}