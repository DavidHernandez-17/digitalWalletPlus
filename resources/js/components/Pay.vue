<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const document = ref('');
const concept = ref('');
const pay_to = ref('');
const value = ref('');
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
        'concept': concept.value,
        'pay_to': pay_to.value,
        'value': value.value
    };

    messages.value = {};
    axios.post(route('get_user'), request)
    .then(response => {
        messages.value = response.data;
        console.log(messages.value);
        showAlert('Exito', 'success');
        emits('close');
    })
    .catch(error => {
        if (error.response && error.response.status === 422) {
            messages.value.document = error.response.data.document;
            messages.value.concept = error.response.data.concept;
            messages.value.pay_to = error.response.data.pay_to;
            messages.value.value = error.response.data.value;
            console.log(error.response);
        } else {
            console.error(error.response);
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
    }).then(()=>{
        window.location.reload();
    });
};

const close = () => {
    emits('close');
};

</script>

<template>
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                <div class="margin-top-login">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <!-- <img class="logo-login-lateral" src="/assets/img/brand/wallet_main.jpg" alt="vista principal"/> -->
                            <div class="h3 text-primary larger-text">Pagar</div>
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
                                        <div :class="['form-group', {'has-error': messages.concept}]">
                                            <label class="text-white" for="concept">Concepto<strong class="text-danger"> *</strong></label>
                                            <input class="form-control text-sm form-control-solid" v-model="concept" type="text" placeholder="seleccione" />
                                            <span v-if="messages.concept" class="text-danger">{{ messages.concept }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div :class="['form-group', {'has-error': messages.pay_to}]">
                                            <label class="text-white" for="pay_to">Pagar a<strong class="text-danger"> *</strong></label>
                                            <input class="form-control text-sm form-control-solid" v-model="pay_to" type="number" placeholder="613 000 126 33" />
                                            <span v-if="messages.pay_to" class="text-danger">{{ messages.pay_to }}</span>
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

                                <div class="row mt-3 mb-2">
                                    <div class="col-md-12">
                                        <button class="btn btn-outline-secondary" @click.prevent="close"><i class="fa-solid fa-arrow-left"></i></button>
                                        <button @click.prevent="save()" class="btn btn-outline-primary ms-2"><i class="fa-solid fa-dollar-sign me-2"></i> Pagar</button>
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