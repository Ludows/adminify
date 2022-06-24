<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 v-if="show_title">{{ list.length }} Commentaire{{ list.length > 1 ? 's' : '' }}</h3>

                <div class="commentlist" v-if="list.length > 0">
                    <div class="comment" v-for="(comment, index) in list" :key="index">

                        <p :id="'comment_'+theCompId+'_'+comment.id">{{ multilang ? comment.comment[lang]: comment.comment }}</p>
                        <update-comment v-if="allow_form" :id="'update_'+theCompId+'_'+comment.id" class="d-none" :lang="lang" :comment_id="comment.id" :value="multilang ? comment.comment[lang] : comment.comment"></update-comment>

                        <div  v-if="user.id === comment.user_id" class="">
                            <a href="#" @click.prevent="toggleForm('respond', comment.id)" class="btn btn-default">Répondre</a>
                            <a href="#"  @click.prevent="toggleForm('update', comment.id)" class="btn btn-warning">Modifier</a>
                            <a href="#"  @click.prevent="deleteComment(comment.id)"  class="btn btn-danger">Supprimer</a>
                        </div>
                        <div v-if="allow_form">
                            <comment-form :model_class="model_class" :id="'respond_'+theCompId+'_'+comment.id" class="d-none"  :user="user" :show_title="false"  :parent_id="comment.id" :model_id="post_id"></comment-form>
                        </div>
                        <comments v-if="comment.childs != undefined" :model_class="model_class" :lang="lang" :show_title="false" :root_level="false" :parent_id="comment.id" :post_id="post_id" :allow_form="allow_form" :user="user" :comments='comment.childs != undefined ? comment.childs : []'></comments>
                    </div>
                </div>

                <div v-if="allow_form && root_level">
                    <comment-form :model_class="model_class"  :user="user" :show_title="false"  :parent_id="parent_id" :model_id="post_id"></comment-form>
                </div>
                <div v-if="!allow_form && root_level" class="alert alert-info">
                    Vous devez être connecté pour pouvoir commenter
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                list : this.comments,
            }
        },
        computed: {
            theCompId : function() {
                // _uid
                return this._uid;
            }
        },
        methods: {
            toggleForm(string = '', commentId) {
                if(string == 'update') {
                    document.querySelector('#comment_'+this.theCompId+'_'+commentId).classList.toggle('d-none');
                }
                document.querySelector('#'+ string +'_'+this.theCompId+'_'+commentId).classList.toggle('d-none');
            },
            deleteComment(commentId, post_id) {

                this.$swal.fire({
                    title: 'Voulez vous supprimer ce Commentaire ?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: `Save`,
                    denyButtonText: `Don't save`,
                }).then((result) => {

                    let route = this.$route('api.comments.destroy', {
                        'comment': commentId,
                        'token': this.$tokenFromLocalStorage()
                    });

                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        this.$axios({
                            'method' : 'POST',
                            'url' : route,
                            'data' : {
                                _method: 'delete',
                                post_id : this.post_id
                            }
                        })
                        .then((response) => {
                            this.$root.$refs.comments.list = response.data.commentList
                            this.$swal.fire(response.data.status, '', 'success')
                        })
                        .catch((err) => {
                            console.log('whooops', err)
                        })
                    }

                })
            }
        },
        props: {
            lang: {
                type: String,
                required : true
            },
            root_level : {
                type : Boolean,
                default : true
            },
            show_title : {
                type : Boolean,
                default : true
            },
            comments : {
                type: Array,
                default: () => { [] }
            },
            allow_form : {
                type : Boolean,
                default : false
            },
            user : {
                type : Object,
                default: () => { {} }
            },
            post_id : {
                type : Number,
            },
            model_class : {
                type: String,
                required:true
            },
            parent_id : {
                type : Number,
                default: 0
            },
            multilang : {
                type: Boolean,
                required : true
            }
        },
        created() {

        },
        mounted() {
            //console.log('Comments mounted.')
            this.list = this.comments;
        },
        watch: {
            comments: function(newVal, oldVal) { // watch it
                console.log('Prop changed: ', newVal, ' | was: ', oldVal)
                this.list = newVal;
            }
        }
    }
</script>
