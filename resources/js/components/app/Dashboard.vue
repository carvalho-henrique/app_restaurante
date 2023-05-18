<template>
    <div class="container">
        <h2 class="text-center">Painel de Reservas</h2>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Numero de pessoas</th>
                    <th>Data da Reserva</th>
                    <th>Hora Inicial</th>
                    <th>Hora Final</th>
                </tr>
            </thead>
            <tbody v-if="type == 1">
                <tr v-for="reservation in reservations" :key="reservation.id" v-show="user_id == reservation.user_id">
                    <td>{{ reservation.user.name }}</td>
                    <td>{{ reservation.number_people }}</td>
                    <td>{{ formatDate(reservation.reservation_date) }}</td>
                    <td>{{ reservation.start_time }}</td>
                    <td>{{ reservation.end_time }}</td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="reservation in reservations" :key="reservation.id">
                    <td>{{ reservation.user.name }}</td>
                    <td>{{ reservation.number_people }}</td>
                    <td>{{ formatDate(reservation.reservation_date) }}</td>
                    <td>{{ reservation.start_time }}</td>
                    <td>{{ reservation.end_time }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props : ['type'],
    data() {
        return {
            reservations: {},
            user_id: ''
        }
    },
    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('default', {dateStyle: 'long'}).format(date);
        }
    },
    mounted() {
        axios.post('http://localhost:8000/api/me')
        .then(response => response.data)
        .then(data => {
            this.user_id = data.id
        })
        .catch(error => console.log(error))

        axios.get('http://localhost:8000/api/reservation')
        .then(response => response.data)
        .then(data => {
            this.reservations = data
        })
        .catch(error => console.log(error))
    }
}
</script>