
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('show-comment', require('./components/CommentComponent.vue'));
Vue.component('show-comments', require('./components/CommentsComponent.vue'));
Vue.component('comment-form', require('./components/CommentFormComponent.vue'));


const app = new Vue({
    el: '#app',
    data: {
        'allComments':[]
    },
    methods:{
        loopNestedComments(allComments=this.allComments, parent_id=null) {
            let self = this;
            let nestedComments = [];
            allComments.forEach(function(ar){
                if(ar.parent_id == parent_id) {
                    var replies = self.loopNestedComments(allComments, ar.id);
                    if(replies.length) {
                        ar.replies = replies;
                    }
                    nestedComments.push(ar);
                }
            });
            return nestedComments;
        },
        truncate(){
            let self = this;
            axios.post('/api/comments/truncate')
                .then(response => {
                    self.allComments=[];
                });

        }
    },
    computed:{
        comments(){
            return this.loopNestedComments();
        }
    },
    created() {
        let self=this;
        this.$root.$on('addComment', (new_comment) => {
            self.allComments.push(new_comment);
        });

       axios.get('/api/comments')
               .then(response => {
                   self.allComments=response.data;
               });
    }
});
