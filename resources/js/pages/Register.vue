<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <b-form @submit="onSubmit">
                    <b-form-group
                        id="username"
                        label="Name"
                        label-align="left"
                        label-for="input-name"
                    >
                        <b-form-input
                            id="input-name"
                            v-model="form.name"
                            placeholder="Enter name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        id="useremail"
                        label="Email Address"
                        label-align="left"
                        label-for="input-email"
                    >
                        <b-form-input
                            id="input-email"
                            v-model="form.email"
                            type="email"
                            placeholder="Enter email"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        id="password"
                        label="Password"
                        label-align="left"
                        label-for="input-password"
                    >
                        <b-form-input
                            id="input-password"
                            v-model="form.password"
                            type="password"
                            placeholder="Enter password"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group label="Account Type" label-align="left">
                        <b-form-radio v-model="form.is_author" value="1">Author</b-form-radio>
                        <b-form-radio v-model="form.is_author" value="0">Visitor</b-form-radio>
                    </b-form-group>

                    <b-button type="submit" block variant="success">Save</b-button>
                </b-form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    data() {
        return {
            form: {
                email: '',
                name: '',
                password: '',
                is_author: 1,
            },
        }
    },
    methods: {
        ...mapActions({
            signIn:'auth/login'
        }),
        async onSubmit(e){
            e.preventDefault()
            await axios.post('api/register',this.form).then(response=>{
                this.signIn()
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
