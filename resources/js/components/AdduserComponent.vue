<template>
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary" v-if="message">
            {{ message }}
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Adicionar um Novo Usuário</h4>
            </div>
            <div class="card-body">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.name}" type="text" v-model="name" class="form-control" placeholder="Nome do Usuário.">
                        <div class="invalid-feedback" v-if="errors.name">
                            <p>{{ errors.name[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.email}" type="text" v-model="email" class="form-control" placeholder="Endereço de Email.">
                        <div class="invalid-feedback" v-if="errors.email">
                            <p>{{ errors.email[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tipo de Usuário</label>
                    <div class="col-sm-12 col-md-7">
                        <select class="form-control" v-model="role" v-bind:class="{'is-invalid': errors.role}">
                            <option v-for="role in roles" v-bind:value="role.id" v-bind:key="role.id">{{ role.name }}</option>
                        </select>
                        <div class="invalid-feedback" v-if="errors.role">
                            <p>{{ errors.role[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Senha</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.password}" type="password" v-model="password" class="form-control" autocomplete="new-password" placeholder="Escolha uma senha.">
                        <div class="invalid-feedback" v-if="errors.password">
                            <p>{{ errors.password[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Confirmar Senha</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.password_confirmation}" type="password" v-model="password_confirmation" class="form-control" placeholder="Confirme a senha da conta." autocomplete="new-password">
                        <div class="invalid-feedback" v-if="errors.password_confirmation">
                            <p>{{ errors.password_confirmation[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button v-bind:disabled="loading" @click="addUser" class="btn btn-primary"><span v-if="loading">Adding</span><span v-else>Add</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: [],
            role: '',
            roles: '',
            message: '',
            loading: false
        }
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        getRoles() {
            axios.get(this.$parent.MakeUrl('sistema/users/roles')).then((res) => {
                this.roles = res.data;
            }).catch((err) => {

            });
        },
        addUser() {
            let _this = this;
            _this.errors = [];
            _this.message = '';
            _this.loading = true;
            axios.post(this.$parent.MakeUrl('sistema/users'), {'name': this.name, 'role': this.role, 'email': this.email, 'current_password': this.current_password, 'password': this.password, 'password_confirmation': this.password_confirmation}).then((res) => {
                _this.loading = false;
                _this.resetForm();
                _this.message = 'Usuário criado com sucesso!';
            }).catch((err) => {
                _this.errors = err.response.data.errors;
                _this.loading = false;
            });
        },
        resetForm() {
            this.name = '';
            this.email = '';
            this.password = '';
            this.role = '';
            this.password_confirmation = '';
        }
    }
}
</script>
