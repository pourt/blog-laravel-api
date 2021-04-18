<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Http\Services\Blog\CommentService;
use App\Http\Services\Blog\PostService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        try {
            
            $posts = (new PostService)->getPosts();

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
                'posts' => $posts,
                'error' => false,
                'message' => 'Successfully retrieved posts'
            ],
            200
        );
    }

    public function show($id)
    {
        try {
            
            $post = (new PostService)->getPostById($id);

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
                'message' => 'Successfully retrieved post'
            ],
            200
        );
    }

    public function addComments(AddCommentRequest $request, int $postId)
    {
        try {
            
            $post = (new CommentService)->addComment($request, $postId);

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
                'message' => 'Successfully commented post'
            ],
            200
        );
    }

    public function getComments(int $postId)
    {
        try {
            
            $comments = (new CommentService)->getComments($postId);

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
                'message' => 'Successfully commented post'
            ],
            200
        );
    }
}
