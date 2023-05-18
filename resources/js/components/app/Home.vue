<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mt-5">
                    <h1>Faça sua reserva!</h1> 
                    <h2>Clique aqui para fazer sua reserva!</h2>
                    <div class="mt-5">
                        <button type="button" class="btn btn-outline-warning btn-lg" @click="goReservation()">Reservar</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['login'],
    methods: {
        goReservation() {
            if(this.login == 'y') {
                window.location.href = 'http://localhost:8000/reservation'
            } else {
                window.location.href = 'http://localhost:8000/login'
            }
        }
    }
}
</script>