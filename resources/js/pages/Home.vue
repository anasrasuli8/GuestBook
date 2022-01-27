<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-lg-8 p-4 bg-white rounded shadow mb-5">
                <div class="row pb-3 mb-3 border-bottom" v-if="user.is_author">
                    <div class="col-lg-8">
                        <b-form-textarea
                            v-model="form.message"
                            placeholder="Type a message"
                            rows="3"
                            ref="message"
                            maxlength="1000"
                            class="custom-body"
                        ></b-form-textarea>
                    </div>
                    <div class="col-lg-4">
                        <b-form-file
                            class="mb-2"
                            plain
                            v-model="form.img"
                            size="sm"
                            accept="image/jpg,image/jpeg,image/png"
                        ></b-form-file>
                        <b-button block class="w-100" :disabled="form.message.length < 5" variant="info" @click="savePost" v-if="!form.id">POST</b-button>
                        <div v-else>
                            <b-button block class="" :disabled="form.message.length < 5"  variant="info" @click="savePost">UPDATE</b-button>
                            <b-button block class="" variant="secondary" @click="clear">CANCEL</b-button>

                        </div>
                    </div>
                </div>
                <div class="row mb-2" v-for="(item,i) in result.data" :key="i">
                        <div class="col-8 d-flex flex-column">
                            <div><span class="text-capitalize fw-bold">{{item.user.name}} </span> <a v-if="item.replies.length == 0 && item.user_id == user.id" @click="editItem(item)" class="ml-4 py-2">Edit</a></div>
                            <div class="d-flex message p-2">
                                <b-img v-if="item.img" height="100" :src="'http://127.0.0.1:8000/storage/user_images/'+item.img"></b-img>
                                <p class="p-2">{{item.text}}</p>
                            </div>
                        </div>
                        <div class="col-8 offset-4 d-flex align-items-end flex-column" v-for="(reply,t) in item.replies">
                            <span class="text-capitalize fw-bold align-self-right" >{{reply.user.name}}</span>
                            <p class="reply p-2 pr-0">{{reply.text}}</p>
                        </div>
                        <reply v-if="item.user_id != user.id" class="col-7 offset-5" :item="item"></reply>
                    </div>
                    <div class="d-flex justify-content-end">
                        <b-pagination
                            v-model="result.current_page"
                            :total-rows="result.total"
                            :per-page="result.per_page"
                            @change="load"
                        ></b-pagination>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Reply from "../components/Reply";
export default {
    name: "Home",
    components: {Reply},
    data() {
        return {
            result: {
                data: [],
                current_page: 1,
                per_page: 25,
            },
            form: {
                id: null,
                message: '',
                img: null,
            },
        }
    },
    async beforeMount() {
        await this.load();
    },
    computed: {
        user () {
            return this.$store.state.auth.user;
        }
    },
    methods: {
        async load(page = 1){
            await axios.get('/api/messages?page='+page).then((res) => {
                this.result = res.data;
            });
        },
        clear(){
            this.form.id = null;
            this.form.message = '';
            this.form.img = null;
        },
        editItem(item){
            this.form.id = item.id;
            this.form.message = item.text;
            window.scrollTo(0, this.$refs['message']);
        },
        async savePost () {
            const formData = new FormData();
            if(this.form.id)
            formData.append('id', this.form.id);
            if(this.form.img){
                formData.append('img', this.form.img);
            }
            formData.append('message', this.form.message);
            const headers = { 'Content-Type': 'multipart/form-data' };
            await axios.post('api/post', formData, { headers }).then((res) =>{
                this.clear();
                this.$bvToast.toast('Post Saved!', {
                    title: 'Success!',
                    variant: 'success',
                    solid: true
                })
                this.load();
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
<style>
.reply{
    border-radius: 1.2rem !important;
    border-start-end-radius: 0!important;
    background: #f4f7fb;}
.message{
    border-radius: 2rem !important;
    border-start-start-radius: 0!important;
    background: #f4f7fb;
}
</style>
