<template>


    <li>
        <div class="row">
            <div class="col-md-9"><strong>{{comment.name}}</strong> said:</div>
            <div class="col-md-3 text-md-right text-secondary"><i class="fa fa-clock-o"></i> {{formatDate(comment.created_at)}}</div>
        </div>

        <div>
            {{comment.comment}}<br>
            <a href="#" v-if="level<3 && !show_reply" @click.prevent="toggleReply">Reply</a>
        </div>

        <comment-form v-if="show_reply" :id="comment.id" v-on:cancelReply="toggleReply"></comment-form>
        <show-comments :comments="comment.replies" :level="level+1"></show-comments>
    </li>


</template>

<script>
    export default {
        props:['comment', 'level'],
        data(){
            return {
                'show_reply':false
            }
        },
        methods:{
            toggleReply(){
                this.show_reply = !this.show_reply;
            },
            formatDate(date){
                return moment(date).fromNow();
            }
        }
    }
</script>
