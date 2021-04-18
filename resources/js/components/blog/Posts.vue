<template>
    <div class="d-flex">
        <div v-for="post in posts" :key="post.id">
            <div>
                <div class="p-5 text-center">
                   <h2><b>{{post.title}}</b></h2>
                   <small>{{post.created_at}}</small>
                </div>
                <div class="p-5">
                    {{post.content}}
                </div>
            </div>
            
            <div class="p-5">
                <div class="">
                    <h3>
                        Comments
                    </h3>
                </div>    
                 <div class="border-top">           
                    <div v-for="comment in comments" :key="comment.id" class="border-bottom">
                        <div class="d-flex">
                            <div>
                                <span class="fa fa-user"></span>
                            </div>
                            <div class="w-90">
                                <div class="pt-2">
                                    <b><big>{{comment.name}}</big></b> <small><small>{{comment.created_at}}</small></small>
                                </div>
                                <div class="pl-5 pt-3 pb-3 pr-3">
                                    <div class="bg-light">
                                        {{comment.comment}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5" >
                    <form ref='commentForm'>
                        <div class="py-2">
                            <b>Leave us a message</b>
                        </div>
                        <div class="py-2">
                            <input v-model="name"  class="form-control" type="text" placeholder="Name" />
                        </div>
                        <div class="py-2">
                            <textarea v-model="comment" rows="5" class="form-control" placeholder="Leave a reply" ></textarea>
                        </div>
                        <div class="py-2 align-right">
                            <input @click="addComment(post.id)" class="btn btn-lg btn-primary" type="button" value="Send" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
  export default {

    data() {
      return {
        posts: [],
        title: null,
        content: null,
        comments: [],
        comment: null,
        name: null,
      }
    },
    mounted(){
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get('/api/posts')
            .then((response) => {

                this.posts = response.data.posts;

                this.getComments(this.posts[0].id);
            })
        },

        addComment(postId) {

            const data = {
                name: this.name,
                comment: this.comment,
            };

            axios.post(`/api/posts/${postId}/comments`, data)
            .then((response) => {
                
                this.getComments(postId);

                this.resetForm();
            })
        },

        getComments(postId) {
            axios.get(`/api/posts/${postId}/comments`)
            .then((response) => {

                this.comments = response.data.comments;

            })
        },

        resetForm()
        {
            this.comment = this.name = "";
        }

      }

    }

</script>
