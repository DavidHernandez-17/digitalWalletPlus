<script setup>
import { computed, onMounted, ref } from "vue";

const message = ref('');
const balancesCustomer = ref([]);
const movementsCustomer = ref([]);
const customer = ref([]);

const props = defineProps({
    id_customer: {
        type: String,
        default: ''
    },
});

const getBalances = async () => {
    let request = {
        'document': props.id_customer,
    };
    message.value = {};
    await axios.post('/api/billetera/saldos', request)
    .then(response => {
        balancesCustomer.value = response.data.balancesCustomer;
        customer.value = response.data.customer;
    })
    .catch(error => {
        message.value = error.response.data;
    });
}

const getMovements = async () => {
    let request = {
        'document': props.id_customer,
    };
    message.value = {};
    await axios.post('/api/billetera/movimientos', request)
    .then(response => {
        movementsCustomer.value = response.data.movementsCustomer;
    })
    .catch(error => {
        message.value = error.response.data;
        console.log(message.value);
    });
}

const valueFormated = computed(() => {
    return function(value) {
        return value.toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    };
})

onMounted( async () => {
    await getBalances();
    await getMovements();

    $(document).ready(function() {
        $('#datatablesBalances').DataTable({
            scrollX: true,
            scrollY: 100,
            searching: false,
            info: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json',
            },
        });

        $('#datatablesMovements').DataTable({
            scrollX: true,
            scrollY: 300,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json',
            },
        });
    });
});
</script>
<template>
    <div class="container-xl px-4 mt-n10 mt-5">
        <div class="h1 text-primary larger-text text-center"><strong>Billetera digital</strong><h5>plus <i class="fa-regular fa-copyright small"></i></h5></div>
        <div class="h1 text-primary larger-text text-center"><h6>Consulta tu saldo</h6></div>
        <div class="card mb-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <strong>Cliente: </strong>
                    </div>
                    <div class="row ms-1">
                        {{ customer.full_name }} |
                        {{ customer.email }} |
                        {{ customer.cell_phone }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-header text-primary">
                            Saldo actual
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered nowrap" id="datatablesBalances">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Billetera</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="balance in balancesCustomer" :key="balance.id">
                                        <td>{{ balance.id }}</td>
                                        <td>{{ balance.name }}</td>
                                        <td>{{ valueFormated(balance.saldo) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                     <div class="col-md-8">
                        <div class="card-header text-primary">
                            Movimientos
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered nowrap" id="datatablesMovements">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Billetera</th>
                                        <th>Concepto de compra</th>
                                        <th>Pagado a</th>
                                        <th>Valor</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="movement in movementsCustomer" :key="movement.id">
                                        <td>{{ movement.id }}</td>
                                        <td>{{ movement.id_wallet }}</td>
                                        <td>{{ movement.payment_concept }}</td>
                                        <td>{{ movement.pay_to }}</td>
                                        <td>{{ valueFormated(movement.value) }}</td>
                                        <td>{{ movement.status }}</td>
                                        <td>{{ movement.updated_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>