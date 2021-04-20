<template>
    <div class="pt-3 px-5">
        <div class="">
            <h3>Comments</h3>     
        </div>           
        <div class="">           
            <div v-for="comment in comments" :key="comment.id" class="">
                <div class="d-flex mb-3">
                    <div class="w-100">
                        <div class="p-2">
                            <b><big>{{comment.name}}</big></b> 
                            <small><small>{{comment.created_at}}</small></small>
                        </div>
                        <div class="pl-2 pt-1 pr-3">
                            <div class="bg-light">
                                {{comment.comment}}
                            </div>
                            <a class="btn btn-link" @click="openReplyForm(comment)" >Reply</a>
                        </div>
                        <div v-show="openCommentId === comment.id"  class="border-1">
                            <div class="">
                                <div class="text-right">
                                    <a class="btn btn-link"  @click="closeReplyForm()">Close</a>
                                </div>
                                <input v-model="reply_name"  class="form-control rounded-0" type="text" placeholder="Name" />
                            </div>
                            <div class="">
                                <textarea v-model="reply_message" class="form-control rounded-0" placeholder="Reply" ></textarea>
                            </div>
                            <div class="">
                                <input @click="addComment(comment)" class="btn w-100 btn-primary rounded-0" type="button" value="Reply" />
                            </div>
                        </div>

                        <!-- REPLY -->
                        <div v-for="reply in comment.replies" :key="reply.id" class="ml-5 mt-5 border-1">
                            <div class="p-2">
                                <b><big>{{reply.name}}</big></b> 
                                <small><small>{{reply.created_at}}</small></small>
                            </div>
                            <div class="pl-2 pt-1 pb-3 pr-3">
                                <div class="bg-light">
                                    {{reply.comment}}
                                </div>
                                <a class="btn btn-link" @click="openReplyForm(reply)" >Reply</a>
                            </div>
                            <div v-show="openCommentId === reply.id">
                                <div class="">
                                    <div class="text-right">
                                        <a class="btn btn-link"  @click="closeReplyForm()">Close</a>
                                    </div>
                                    <input v-model="reply_name"  class="form-control rounded-0" type="text" placeholder="Name" />
                                </div>
                                <div class="">
                                    <textarea v-model="reply_message" class="form-control rounded-0" placeholder="Reply" ></textarea>
                                </div>
                                <div class="">
                                    <input @click="addComment(reply)" class="btn w-100 btn-primary rounded-0" type="button" value="Reply" />
                                </div>
                            </div>

                            <!-- NESTED REPLY -->
                            <div v-for="nestedReply in reply.replies" :key="nestedReply.id" class="ml-5 mt-5 border-1">
                                <div class="p-2">
                                    <b><big>{{nestedReply.name}}</big></b> 
                                    <small><small>{{nestedReply.created_at}}</small></small>
                                </div>
                                <div class="pl-2 pt-1 pb-3 pr-3">
                                    <div class="bg-light">
                                        {{nestedReply.comment}}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- END NESTED REPLY -->
                            
                        </div>
                        <!-- END REPLY -->

                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 mb-5" >
            <form ref='commentForm'>
                <div class="">
                    <input v-model="name"  class="form-control rounded-0" type="text" placeholder="Name" />
                </div>
                <div class="">
                    <textarea v-model="message" rows="5" class="form-control rounded-0" placeholder="Comment" ></textarea>
                </div>
                <div class="text-right">
                    <input @click="addComment()" class="btn btn-primary rounded-0 w-100" type="button" value="Leave a Comment" />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        name: null,
        message: null,
        reply_name: null,
        reply_message: null,
        openCommentId: null,
        comments: [],
        comment: {
            name: null,
            message: null,
        }
      }
    },

    mounted () {
        this.getComments()
    },

    methods: {
        addComment (comment) {

            const comment_id = typeof comment !== 'undefined' ? comment.id : null;

            let data = {
                name: this.name,
                comment: this.message
            };

            if (comment_id) {
                data = {
                    comment_id: comment_id,
                    name: this.reply_name,
                    comment: this.reply_message
                };
            }

            console.log('data', data);

            axios.post(`/api/comments`, data)
                .then((response) => {

                    this.resetForm();

                    this.closeReplyForm();

                    this.getComments();
                })
        },

        getComments (post) {
            axios.get(`/api/comments`)
                .then((response) => {

                    this.comments = response.data.comments;

                })
        },

        resetForm () {
            this.message = this.name = this.reply_name = this.reply_message = "";
        },

        openReplyForm (comment) {
            this.openCommentId = null;

            this.openCommentId = comment.id;
        },

        closeReplyForm () {
            this.openCommentId = null;
        },

        resetReplyForm () {
            this.openCommentId = null;
        }

      }

    }
</script>
