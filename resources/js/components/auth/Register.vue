<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header">Registrar</div>
                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent="register($event)">
                            <input type="hidden" name="_token" :value="csrf_token">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Nome</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="" required autocomplete="name" autofocus v-model="name">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" v-model="email">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" v-model="password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar Senha</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" v-model="password_confirmation">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-warning">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['csrf_token'],
    data(){
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        }
    },
    methods: {
        register(event){
            let url = "http://localhost:8000/api/register"
            let config = {
                method: 'post',
                body: new URLSearchParams({
                    'name': this.name,
                    'email': this.email,
                    'password': this.password,
                    'password_confirmation': this.password_confirmation
                })
            }
            fetch(url, config)
                .then(response => {
                    window.location.href = 'http://localhost:8000/login'
                })
                .catch(error => console.log(error))
                
        }
    }
}
</script>