<?php 

namespace App\Http\Services\Blog;

use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;

class PostService 
{
    public function getPosts()
    {
        $posts = Post::get();

        if (! $posts) {
            throw new \Exception("Unable to retrieve blog post.", 404);
        }

        return $posts;
    }

    public function getPostById($id)
    {
        $posts = Post::find($id);

        if (! $posts) {
            throw new \Exception("Unable to retrieve blog post.", 404);
        }

        return $posts;
    }

    
}