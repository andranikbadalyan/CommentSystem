<template>
    <div class="row">
        <div class="col-md-8 col-lg-6" :class="{'offset-md-2 offset-lg-3': !id}">

            <form class="bg-light mt-2 mb-2 p-3 border rounded" method="POST" v-on:submit.prevent="onSubmit">
                <div class="form-group">
                    <label class="mb-0" for="name">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="enter your name" v-model="form.name">
                    <small class="form-text text-danger" v-if="errors.name">{{errors.name}}</small>
                </div>
                <div class="form-group">
                    <label class="mb-0" for="comment">Comment<span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-sm" name="comment" id="comment" rows="3" placeholder="enter your comment" v-model="form.comment"></textarea>
                    <small class="form-text text-danger" v-if="errors.comment">{{errors.comment}}</small>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" v-if="id" @click="cancelReply">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </form>

        </div>
    </div>
</template>

<script>
    export default {
        props:{
            'id':{
                default: ''
            }
        },
        data(){
            return {
                'form':{
                    'name':'',
                    'comment':''
                },
                'errors':{
                    'name':'',
                    'comment':''
                }
            }
        },
        computed:{
            formData: function () {
                return {
                    'parent_id':this.id,
                    'name':this.form.name,
                    'comment':this.form.comment
                }
            }
        },
        methods:{
            cancelReply(){
                this.$emit('cancelReply');
            },
            onSubmit() {
                let self = this;
                axios.post('/api/comments', self.formData)
                        .then(response => {
                            self.form.name='';
                            self.form.comment='';
                            self.errors.name='';
                            self.errors.comment='';


                            this.$emit('cancelReply');
                            this.$root.$emit('addComment', response.data);
                        })
                        .catch(error => {
                            let errors = error.response.data.errors;

                            if(errors['name']){
                                self.errors.name=errors['name'][0];
                            }
                            if(errors['comment']){
                                self.errors.comment=errors['comment'][0];
                            }

                        });
            }

        }
    }
</script>
