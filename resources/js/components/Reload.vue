<script setup>
import { defineProps, defineEmits, ref, watch } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const document = ref('');
const cell_phone = ref('');
const value = ref('');
const optionsWallet = ref();
const wallet = ref('');
const messages = ref('');

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
});

const emits = defineEmits(['close']);

const save = () => {
    let request = {
        'document': document.value,
        'cell_phone': cell_phone.value,
        'value': value.value,
        'wallet': wallet.value
    };

    messages.value = {};
    axios.post('api/billetera/recargar', request)
    .then(response => {
        messages.value = response.data;
        console.log(messages.value);
        showAlert('Exito', 'success');
        emits('close');
        document.value = '';
        cell_phone.value = '';
        value.value = '';
        wallet.value = '';
    })
    .catch(error => {
        if (error.response && error.response.status === 422) {
            messages.value.document = error.response.data.document;
            messages.value.cell_phone = error.response.data.cell_phone;
            messages.value.value = error.response.data.value;
            messages.value.wallet = error.response.data.wallet;
            console.log(error.response);
        } else {
            messages.value = 'Los datos documento y celular no coinciden con el cliente';
            showAlert('Oops...', 'error');
        }
    });
}


const showAlert = (title, icon) => {
    Swal.fire({
        title: title,
        text: messages.value,
        icon: icon,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2C607F'
    });
};

const close = () => {
    emits('close');
};

watch(document, async (newDocument) => {
    optionsWallet.value = '';
    if (newDocument) {
        try {
            const response = await axios.post('api/billetera/recargar/' + newDocument);
            optionsWallet.value = response.data;
            if (optionsWallet.value == '') {
                alert('opciones vacias');
            }
            console.log(response.data);
        } catch (err) {
            console.log(err);
        }
    }
});

</script>

<template>
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                <div class="margin-top-login">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <!-- <img class="logo-login-lateral" src="/assets/img/brand/wallet_main.jpg" alt="vista principal"/> -->
                            <div class="h3 text-primary larger-text">Recarga tu</div>
                            <div class="h1 text-primary larger-text"><strong>Billetera digital</strong><h5>plus <i class="fa-regular fa-copyright small"></i></h5></div>
                        </div>

                        <form>
                            <div class="col-md-10 offset-1 offset-sm-1">
                                <!-- <div class="message">
                                    <p v-if="message.length">
                                        <span :class="styles" v-for="error in message" :key="error.id">{{ error }}</span>                                                    
                                    </p>
                                </div> -->
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div :class="['form-group', {'has-error': messages.document}]">
                                            <label class="text-white" for="document">Documento<strong class="text-danger"> *</strong></label>
                                            <input class="form-control text-sm form-control-solid" v-model="document" type="text" placeholder="TI, CC, CE, NIT" />
                                            <span v-if="messages.document" class="text-danger">{{ messages.document }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div :class="['form-group', {'has-error': messages.cell_phone}]">
                                            <label class="text-white" for="cell_phone">Celular<strong class="text-danger"> *</strong></label>
                                            <input class="form-control text-sm form-control-solid" v-model="cell_phone" type="text" placeholder="+57" />
                                            <span v-if="messages.cell_phone" class="text-danger">{{ messages.cell_phone }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div :class="['form-group', {'has-error': messages.value}]">
                                            <label class="text-white" for="value">Valor<strong class="text-danger"> *</strong></label>
                                            <input class="form-control text-sm form-control-solid" v-model="value" type="number" placeholder="$" />
                                            <span v-if="messages.value" class="text-danger">{{ messages.value }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div :class="['form-group', {'has-error': messages.wallet}]">
                                            <label class="text-white" for="wallet">Billetera<strong class="text-danger"> *</strong></label>
                                            <select class="form-control text-sm form-control-solid" v-model="wallet">
                                                <option v-for="wallet in optionsWallet" :value="wallet.id" :key="wallet.id">
                                                    {{ wallet.name }}
                                                </option>
                                            </select>
                                            <span v-if="messages.wallet" class="text-danger">{{ messages.wallet }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3 mb-2">
                                    <div class="col-md-12">
                                        <button class="btn btn-outline-secondary" @click.prevent="close"><i class="fa-solid fa-arrow-left"></i></button>
                                        <button @click.prevent="save()" class="btn btn-outline-primary ms-2"><i class="fa-solid fa-bolt me-2"></i> Recargar</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
span{
    font-size: 13px;
}
.has-error input {
  border-color: red;
}
.has-error {
  border-color: red;
}
.margin-top{
    margin-top: 100px;
}
</style>