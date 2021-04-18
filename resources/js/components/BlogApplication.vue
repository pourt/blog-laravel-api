<template>
   <posts-component  />
</template>

<script>
    import PostsComponent from './blog/Posts.vue'

    export default {
        components : {
            'posts-component': PostsComponent
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
