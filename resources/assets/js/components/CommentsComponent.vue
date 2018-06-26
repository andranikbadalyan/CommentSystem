<template>
    <ul>
        <show-comment :comment="comment" :level="level" v-for="comment in comments"></show-comment>
    </ul>

</template>

<script>
    export default {
        props:{
            'comments': {
                default: function(){
                    return [];
                }
            },
            'level': {
                default:0
            }
        },
        data(){
            return {
            }
        },
        mounted() {
        }
    }
</script>
