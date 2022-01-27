<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <b-form @submit="login">
                    <b-form-group
                        id="useremail"
                        class="mb-2"
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
                        class="mb-2"
                        label-align="left"
                        label-for="input-password"
                    >
                        <b-form-input
                            id="input-password"
                            v-model="form.password"
                            min="6"
                            type="password"
                            placeholder="Enter password"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-2"
                    >
                        <b-form-checkbox
                            id="remember-me"
                            v-model="form.remember_me"
                            name="checkbox-1"
                            class="pl-4"
                        >
                            Remember Me
                        </b-form-checkbox>
                    </b-form-group>
                    <b-button type="submit" block variant="success">Login</b-button>
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
                password: '',
                remember_me: null,
            },
        }
    },
    methods: {
        ...mapActions({
            signIn:'auth/login'
        }),
        async login(e){
            e.preventDefault();
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('api/login',this.form).then(({data})=>{
                this.signIn()
            }).catch(({response:{data}})=>{
                this.$bvToast.toast(data.message+"\n"+JSON.stringify(data.errors), {
                    title: 'Operation Failed!',
                    variant: 'danger',
                    solid: true
                })
            })
        },
    },
}
</script>
