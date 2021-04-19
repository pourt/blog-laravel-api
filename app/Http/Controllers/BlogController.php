<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\AddReplyRequest;
use App\Http\Services\Blog\CommentService;
use App\Http\Services\Blog\PostService;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function addComments(AddCommentRequest $request)
    {
        try {
            
            $post = (new CommentService)->addComment($request);

        } catch (\Exception $e) {
            return response(
                [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ], 
                422
            );
        }

        return response(
            [
                'post' => $post,
                'error' => false,
                'message' => 'Comment successfully added'
            ],
            201
        );
    }

    public function getComments(int $commentId = 0)
    {
        try {
            
            $comments = (new CommentService)->getComments($commentId);

        } catch (\Exception $e) {
            return response(
                [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ], 
                422
            );
        }

        return response(
            [
                'comments' => $comments,
                'error' => false,
                'message' => 'Comments successfully retrieved'
            ],
            200
        );
    }
}
