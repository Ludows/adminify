<template>
    <form v-on:submit.prevent="submit">
        <input type="hidden" name="parent_id" :value="parent_id">
        <input type="hidden" name="post_id" :value="post_id">
        <input type="hidden" name="user_id" :value="user.id">
        <input type="hidden" name="is_moderated" :value="user.role.id === 1 ? 1 : 0">

        <div class="form-row">
            <div class="col-12">
                <div class="form-group">
                    <label :for="'comment_'+_uid">Comment</label>
                    <textarea ref="textarea" required="required" class="form-control" :id="'comment_'+_uid" name="comment" rows="3"></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</template>

<script>
    export default {
        props: {
            parent_id : {
                type : Number,
                default: 0
            },
            user : {
                type : Object,
                default: () => { {} }
            },
            post_id : {
                type : Number,
            }
        },
        methods : {
            submit() {
                //console.log(Route(''))
                let form = this.$el;
                let formData = new FormData(form);
                let parent = this.$refs.comments;
                let textarea = this.$refs.textarea;

                let route = this.$route('api.comments.store', {
                    'token' : this.$tokenFromLocalStorage()
                });

                this.$axios({
                    'method' : 'POST',
                    'url' : route,
                    'data' : formData
                })
                .then((response) => {
                    console.log(this.$root.$refs.comments)
                    console.log('response.data.commentList', response.data.commentList)
                    this.$root.$refs.comments.list = [];
                    this.$root.$refs.comments.list = response.data.commentList
                    textarea.value = '';
                })
                .catch((err) => {
                    console.log('whooops', err)
                })
            }
        },
        mounted() {
            //console.log('Comment Form Mounted.')
        }
    }
</script>
