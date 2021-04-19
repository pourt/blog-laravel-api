<template>
    <div class="d-flex flex-column">
        <posts-component  />
        <comments-component  />
    </div>
</template>

<script>
    import PostsComponent from './blog/Posts.vue'
    import CommentsComponent from './blog/Comments.vue'

    export default {
        components : {
            'posts-component': PostsComponent,
            'comments-component': CommentsComponent
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
