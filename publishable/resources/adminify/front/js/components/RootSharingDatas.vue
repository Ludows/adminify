<template>
    <span id="ROOT_SHARING"></span>
</template>

<script>
    export default {
        props: {
            export : {
                type : Object,
                default: () => { {} }
            },
        },
        methods : {

        },
        mounted({ store }) {

            store.commit('addData', this.export);
            //console.log('Comment Form Mounted.')
        }
    }
</script>
