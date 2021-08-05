<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 v-if="show_title">{{ list.length }} Commentaire{{ list.length > 1 ? 's' : '' }}</h3>

                <div class="commentlist" v-if="list.length > 0">
                    <div class="comment" v-for="(comment, index) in list" :key="index">

                        <p :id="'comment_'+_uid+'_'+comment.id">{{ comment.comment[lang] }}</p>
                        <update-comment v-if="allow_form" :id="'update_'+_uid+'_'+comment.id" class="d-none" :lang="lang" :comment_id="comment.id" :value="comment.comment[lang]"></update-comment>

                        <div  v-if="user.id === comment.user_id" class="">
                            <a href="#" @click.prevent="toggleForm('respond', comment.id)" class="btn btn-default">Répondre</a>
                            <a href="#"  @click.prevent="toggleForm('update', comment.id)" class="btn btn-warning">Modifier</a>
                            <a href="#"  @click.prevent="deleteComment(comment.id)"  class="btn btn-danger">Supprimer</a>
                        </div>
                        <div v-if="allow_form">
                            <comment-form :id="'respond_'+_uid+'_'+comment.id" class="d-none"  :user="user" :show_title="false"  :parent_id="parent_id" :post_id="post_id"></comment-form>
                        </div>
                        <comments :lang="lang" :show_title="false" :root_level="false" :parent_id="comment.id" :post_id="post_id" :allow_form="allow_form" :user="user" :comments='comment.childs != undefined ? comment.childs : []'></comments>
                    </div>
                </div>

                <div v-if="allow_form && root_level">
                    <comment-form  :user="user" :show_title="false"  :parent_id="parent_id" :post_id="post_id"></comment-form>
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
        methods: {
            toggleForm(string = '', commentId) {
                if(string == 'update') {
                    document.querySelector('#comment_'+this._uid+'_'+commentId).classList.toggle('d-none');
                }
                document.querySelector('#'+ string +'_'+this._uid+'_'+commentId).classList.toggle('d-none');
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
            parent_id : {
                type : Number,
                default: 0
            }
        },
        created() {

        },
        mounted() {
            //console.log('Comments mounted.')
        }
    }
</script>
