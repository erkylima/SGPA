<template>
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary" v-if="message">
            {{ message }}
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Atualizar Perfil</h4>
            </div>
            <div class="card-body">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.name}" type="text" v-model="name" class="form-control">
                        <div class="invalid-feedback" v-if="errors.name">
                            <p>{{ errors.name[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.email}" type="text" v-model="email" class="form-control">
                        <div class="invalid-feedback" v-if="errors.email">
                            <p>{{ errors.email[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4" v-if="$parent.userCan('edit-users') && !getUserdata('isme')">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tipo de Usuário</label>
                    <div class="col-sm-12 col-md-7">
                        <select class="form-control" v-model="role" v-bind:class="{'is-invalid': errors.role}">
                            <option v-for="role in roles"  v-bind:key="role.id" v-bind:value="role.id">{{ role.name }}</option>
                        </select>
                        <div class="invalid-feedback" v-if="errors.role">
                            <p>{{ errors.role[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Avatar</label>
                    <div class="col-sm-12 col-md-7">
                    <div id="image-preview" class="image-preview">
                        <label for="image_avatar" id="image-label">Escolher arquivo</label>
                        <input type="file" name="image_avatar" id="image_avatar" />
                    </div>
                    </div>
                </div>
                <div class="form-group row mb-4" v-if="!$parent.userCan('edit-users')">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Senha Atual</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.current_password}" type="password" v-model="current_password" class="form-control" autocomplete="new-password" placeholder="Current password">
                        <div class="invalid-feedback" v-if="errors.current_password">
                            <p>{{ errors.current_password[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Senha</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.password}" type="password" v-model="password" class="form-control" autocomplete="new-password" placeholder="Nova senha (Somente se quiser alterar)">
                        <div class="invalid-feedback" v-if="errors.password">
                            <p>{{ errors.password[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Confirmar Senha</label>
                    <div class="col-sm-12 col-md-7">
                        <input v-bind:class="{'is-invalid': errors.password_confirmation}" type="password" v-model="password_confirmation" class="form-control" autocomplete="new-password">
                        <div class="invalid-feedback" v-if="errors.password_confirmation">
                            <p>{{ errors.password_confirmation[0] }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button v-bind:disabled="loading" @click="updateUser" class="btn btn-primary"><span v-if="loading">Atualizar</span><span v-else>Update</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            name: this.getUserdata('name'),
            email: this.getUserdata('email'),
            image_avatar: this.getUserdata('image_avatar'),
            current_password: '',
            password: '',
            password_confirmation: '',
            role: this.getUserdata('roles').length ? this.getUserdata('roles')[0].id : '',
            roles: [],
            errors: [],
            message: '',
            loading: false
        }
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        getUserdata(key) {
            return JSON.parse(this.user)[key];
        },
        getRoles() {
            axios.get(this.$parent.MakeUrl('sistema/users/roles')).then((res) => {
                this.roles = res.data;
            }).catch((err) => {

            });
        },
        updateUser() {
            let _this = this;
            _this.errors = [];
            _this.message = '';
            _this.loading = true;
            
            axios.post(this.$parent.MakeUrl('sistema/users/'+this.getUserdata('id')), {'name': this.name, 'email': this.email,'image_avatar': this.image_avatar, 'current_password': this.current_password, 'role': this.role, 'password': this.password, 'password_confirmation': this.password_confirmation,'_enctype':'multipart/form-data', '_method': 'PATCH'}).then((res) => {
                _this.loading = false;
                _this.message = 'Dados atualizados com sucesso!';
            }).catch((err) => {
                _this.errors = err.response.data.errors;
                _this.loading = false;
            });
        }
    }
}
</script>
