<template>
    <form v-on:submit.prevent="submit">
        <input type="hidden" name="parent_id" :value="parent_id">
        <input type="hidden" name="model_id" :value="model_id">
        <input type="hidden" name="model_class" :value="model_class">
        <input type="hidden" name="user_id" :value="user.id">
        <input type="hidden" name="is_moderated" :value="user.mainRole.id === 1 ? 1 : 0">

        <div class="form-row">
            <div class="col-12">
                <div class="form-group">
                    <label :for="'comment_'+theCompId">Comment</label>
                    <textarea ref="textarea" required="required" class="form-control" :id="'comment_'+theCompId" name="comment" rows="3"></textarea>
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
            model_id : {
                type : Number,
            },
            model_class : {
                type: String,
                required: true
            }
        },
        computed: {
            theCompId : function() {
                // _uid
                return this._uid;
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
                    // console.log(this.$root.$refs.comments)
                    // console.log('response.data.commentList', response.data.commentList)
                    this.$root.$refs.comments.list = [];
                    this.$root.$refs.comments.list = response.data.commentList
                    if(this.parent_id != 0) {
                        // console.log('direct paraent', this.$parent)
                        // console.log('ancestor paraent', parent)
                        this.$parent.toggleForm('respond', this.parent_id)
                    }
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
