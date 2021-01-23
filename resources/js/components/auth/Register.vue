<template>
    <div class="container d-flex vh-100 justify-content-center align-items-center">
        <div class="card col-md-8 bg-dark text-white p-0">
            <div class="card-header text-center">
                ລົງທະບຽນ
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="username" class="col-form-label col-md-4 text-md-right">ຊື່ຜູ້ໃຊ້: </label>
                    <input class="col-md-6 form-control" :class="{'is-invalid': errors.username}" id="username" name="username" type="text" placeholder="ຊື່ຜູ້ໃຊ້" v-model="form.username">
                    <span class="invalid-feedback offset-md-4" v-if="errors.username">{{ errors.username[0] }}</span>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-form-label col-md-4 text-md-right">E-mail: </label>
                    <input class="col-md-6 form-control" :class="{'is-invalid': errors.email}" id="email" name="email" type="email" placeholder="E-Mail" v-model="form.email">
                    <span class="invalid-feedback offset-md-4" v-if="errors.email">{{ errors.email[0] }}</span>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-form-label col-md-4 text-md-right">ລະຫັດຜ່ານ: </label>
                    <input class="col-md-6 form-control" :class="{'is-invalid': errors.password}" id="password" name="password" type="password" placeholder="ລະຫັດຜ່ານ" v-model="form.password">
                    <span class="invalid-feedback offset-md-4" v-if="errors.password">{{ errors.password[0] }}</span>
                </div>
                <div class="form-group row">
                    <label for="password_confirmation" class="col-form-label col-md-4 text-md-right">ຢືນຢັນລະຫັດຜ່ານ: </label>
                    <input class="col-md-6 form-control" :class="{'is-invalid': errors.password_confirmation}" id="password_confirmation" name="password_confirmation" type="password" placeholder="ຢືນຢັນລະຫັດຜ່ານ" v-model="form.password_confirmation">
                    <span class="invalid-feedback offset-md-4" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</span>
                </div>
                <div class="form-group row">
                    <input class="offset-md-4 btn btn-primary mr-3" type="submit" value="ລົງທະບຽນ" @click.prevent="registerAccount">
                </div>
                <div class="row"><span class="offset-md-4">ມີບັນຊີແລ້ວ? <router-link to="/login">ເຂົ້າສູ່ລະບົບ</router-link></span></div>
                <div class="row"><span class="offset-md-4"><router-link to="/about">ກ່ຽວກັບເວັບໄຊທ໌ນີ້</router-link></span></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form: {
                username: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: []
        }
    },
    methods:{
        registerAccount(){
            axios.post("/api/register", this.form)
            .then( res => {
                this.$router.push({ name: "dashboard"})
            })
            .catch( err => {
                this.errors = err.response.data.errors
            })
        }
    }
}
</script>
