<template>
    <div class="pt-3 px-5">
        <div class="">
            <h3>Comments</h3>     
        </div>           
        <div class="">           
            <div v-for="comment in comments" :key="comment.id" class="">
                <div class="d-flex mb-3">
                    <div class="border w-100">
                        <div class="p-2">
                            <b><big>{{comment.name}}</big></b> 
                            <small><small>{{comment.created_at}}</small></small>
                        </div>
                        <div class="pl-5 pt-3 pb-3 pr-3">
                            <div class="bg-light">
                                {{comment.comment}}
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-0">
                            <div class="flex-fill p-0">
                                <a class="btn btn-secondary rounded-0 w-100" @click="openReplyForm(comment)" v-show="openCommentId !== comment.id">Leave a Reply</a>
                            </div>
                        </div>
                        <div v-for="reply in comment.replies" :key="reply.id" class="">
                            <div class="p-2">
                                <b><big>{{reply.name}}</big></b> 
                                <small><small>{{reply.created_at}}</small></small>
                            </div>
                            <div class="pl-5 pt-3 pb-3 pr-3">
                                <div class="bg-light">
                                    {{reply.comment}}
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-between p-0">
                                <div class="flex-fill p-0">
                                    <a class="btn btn-secondary rounded-0 w-100" @click="openReplyForm(reply)" v-show="openCommentId !== reply.id">Leave a Reply</a>
                                </div>
                            </div>
                            <div class="">
                                <div v-show="openCommentId === comment.id">
                                    <div class="">
                                        <input v-model="reply.name"  class="form-control rounded-0" type="text" placeholder="Name" />
                                    </div>
                                    <div class="">
                                        <textarea v-model="reply.message" class="form-control rounded-0" placeholder="Reply" ></textarea>
                                    </div>
                                    <div class="">
                                        <input @click="addComment(comment)" class="btn w-100 btn-primary rounded-0" type="button" value="Reply" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div v-show="openCommentId === comment.id">
                                <div class="">
                                    <input v-model="reply.name"  class="form-control rounded-0" type="text" placeholder="Name" />
                                </div>
                                <div class="">
                                    <textarea v-model="reply.message" class="form-control rounded-0" placeholder="Reply" ></textarea>
                                </div>
                                <div class="">
                                    <input @click="addComment(comment)" class="btn w-100 btn-primary rounded-0" type="button" value="Reply" />
                                </div>
                            </div>
                        </div>
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
    props: {
        comments: {
            type: Object,
            required: true
        }
    },
    data () {
      return {
        name: null,
        message: null,
        openCommentId: null,
        comments: [],
        comment: {
            name: null,
            message: null,
        },
        reply: {
            name: null,
            comment: null
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
                    name: this.reply.name,
                    comment: this.reply.message,
                };
            }

            axios.post(`/api/comments`, data)
                .then((response) => {

                    this.getComments();

                    this.resetForm();

                    this.closeReplyForm();
                })
        },

        getComments (post) {
            axios.get(`/api/comments`)
                .then((response) => {

                    this.comments = response.data.comments;

                })
        },

        resetForm () {
            this.message = this.name = this.reply.name = this.reply.message = "";
        },

        openReplyForm (comment) {
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
