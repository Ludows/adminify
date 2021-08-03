<template>
    <form v-on:submit.prevent="submit">
        <div class="form-row">
            <div class="col-12">
                <div class="form-group">
                    <label :for="'comment_'+_uid">Comment</label>
                    <textarea ref="textarea" :value="value" required="required" class="form-control" :id="'comment_'+_uid" name="comment" rows="3"></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</template>

<script>
    export default {
        props: {
            lang: {
                type: String,
                default : 'fr'
            },
            comment_id : {
                type : Number,
                required: true
            },
            value : {
                type : String,
                required : true
            }
        },
        methods : {
            submit() {
                //console.log(Route(''))
                let form = this.$el;
                let formData = new FormData(form);
                formData.append('_method', 'PATCH');
                let textarea = this.$refs.textarea;
                
                let route = this.$route('api.comments.update', {'comment' : this.comment_id});

                this.$axios({
                    'method' : 'POST',
                    'url' : route,
                    'data' : formData
                })
                .then((response) => {
                    this.$root.$refs.comments.list = response.data.commentList
                    this.$parent.toggleForm('update', this.comment_id)
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
