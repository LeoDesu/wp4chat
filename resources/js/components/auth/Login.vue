<template>
    <div class="container d-flex vh-100 justify-content-center align-items-center">
        <div class="card col-md-8 bg-dark text-white p-0">
            <div class="card-header text-center">
                ເຂົ້າສູ່ລະບົບ
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="email" class="col-form-label col-md-4 text-md-right">E-Mail: </label>
                    <input class="col-md-6 form-control" :class="{'is-invalid': errors.email}" id="email" name="email" type="text" placeholder="E-Mail" v-model="form.email">
                    <span class="invalid-feedback offset-md-4" v-if="errors.email">{{ errors.email[0] }}</span>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-form-label col-md-4 text-md-right">ລະຫັດຜ່ານ: </label>
                    <input class="col-md-6 form-control" :class="{'is-invalid': errors.password}" id="password" name="password" type="password" placeholder="ລະຫັດຜ່ານ" v-model="form.password">
                    <span class="invalid-feedback offset-md-4" v-if="errors.password">{{ errors.password[0] }}</span>
                </div>
                <div class="form-group row">
                    <input class="offset-md-4 btn btn-primary mr-3" type="submit" value="ເຂົ້າສູ່ລະບົບ" @click.prevent="login">
                </div>
                <div class="row"><span class="offset-md-4">ຍັງບໍ່ມີບັນຊີ? <router-link to="/register">ລົງທະບຽນ</router-link></span></div>
                <div class="row"><span class="offset-md-4"><router-link to="/about">ກ່ຽວກັບເວັບໄຊທ໌ນີ້</router-link></span></div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods:{
        ...mapActions(['fetchUser']),
        login() {
            axios.post("/api/login", this.form).then( res => {
                console.log(res)
                this.fetchUser()
                this.$router.push({ name: "dashboard"})
            }).catch( err => {
                console.log(err);
                this.errors = err.response.data.errors;
            });
        }
    }
}
</script>
