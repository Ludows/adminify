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
        mounted() {
            this.$store.commit('addData', this.export);
        }
    }
</script>
