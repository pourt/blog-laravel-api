<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $commentCollection = $this->collection;
        $commentObject = [];

        foreach ($commentCollection as $comment) 
        {
            $replyObject = [];

            if ($comment->replies->count()) 
            {
                foreach($comment->replies as $reply)
                {
                    $nestedReplyObject = [];

                    if ($reply->replies->count())
                    {
                        foreach($reply->replies as $nestedReply)
                        {
                            $nestedReplyObject[] = $nestedReply;
                        } 

                        $replyObject[] = [
                            "id" => $reply->id,
                            "name" => $reply->name,
                            "comment" => $reply->comment,
                            "created_at" => $reply->created_at,
                            "replies" => $nestedReplyObject
                        ];

                    } else {
                        $replyObject[] = $reply;
                    }

                }

            }

            if ($comment->comment_id == null) 
            {
                $commentObject[] = [
                    "id" => $comment->id,
                    "name" => $comment->name,
                    "comment" => $comment->comment,
                    "created_at" => $comment->created_at,
                    "replies" => $replyObject
                ];
            }

        }

        return $commentObject;
    }

}
