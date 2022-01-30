<template>
    <div class="d-flex justify-content-end my-2">
        <div class="d-flex flex-column justify-content-end p-2">
            <b-button variant="primary" @click="reply" :disabled="text.length < 3" size="sm">Reply</b-button>
        </div>
        <b-form-textarea v-model="text" rows="2" placeholder="Enter your answer"></b-form-textarea>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: 'Reply',
        props:['item'],
        data() {
            return {
                text: ''
            }
        },
        methods: {
            async reply () {
                await axios.post('api/reply',
                    { id: this.item.id, text: this.text }).then((res) =>{
                        this.item.replies.push(res.data);
                    this.text = '';
                    this.$bvToast.toast('Reply Saved!', {
                        title: 'Success!',
                        variant: 'success',
                        solid: true
                        })
                    }).catch(({response:{data}})=>{
                        this.$bvToast.toast(data.message+"\n"+JSON.stringify(data.errors), {
                            title: 'Operation Failed!',
                            variant: 'danger',
                            solid: true
                        })
                    });
            },
        }
    }
</script>
