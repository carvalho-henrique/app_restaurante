<template>
    <div class="container">
        <div class="row">
            <h2 class="text-center">Faça sua reserva</h2>
            <div class="mx-auto col-10 col-md-8 col-lg-6">
                <div class="align-items-center">
                    <form @submit.prevent="submit($event)">
                        <input type="hidden" name="user_id" :value="user_id">
                        <div class="mb-3">
                            <label class="form-label" for="number_people">Numero de pessoas</label>
                            <input id="number_people" class="form-control" type="number" v-model="number_people"  name="number_people" placeholder="Ex: 4"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="reservation_date">Dia da Reserva</label>
                            <input id="reservation_date" class="form-control" type="date" v-model="reservation_date" name="reservation_date" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="start_time">Hora Inicial</label>
                            <input id="start_time" class="form-control" type="time" v-model="start_time"  name="start_time" placeholder="Ex: 18:00"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="end_time">Hora Final</label>
                            <input id="end_time" class="form-control" type="time" v-model="end_time" name="end_time" placeholder="Ex: 19:00"/>
                        </div>
                        <button type="submit" class="btn btn-warning">Reservar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            user_id: '',
            number_people: 0,
            reservation_date: '',
            start_time: '',
            end_time: ''
        }
    },
    methods: {
        submit(e){
            const body = {
                user_id : this.user_id,
                number_people : this.number_people,
                reservation_date : this.reservation_date,
                start_time : this.start_time,
                end_time : this.end_time,
            }

            axios.post('http://localhost:8000/api/reservation', body)
            .then(response => response.data)
            .then(data => {
                window.location.href = "http://localhost:8000/dashboard"
            })
            .catch(error => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Aviso!',
                    text: error.response.data.erro
                })
            })
        }
    },
    mounted () {
        axios.post('http://localhost:8000/api/me')
        .then(response => response.data)
        .then(data => {
            this.user_id = data.id
        })
        .catch(error => console.log(error))
    }

}
</script>
