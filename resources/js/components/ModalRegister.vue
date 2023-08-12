<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const document = ref('');
const full_name = ref('');
const email = ref('');
const cell_phone = ref('');
const messages = ref({});

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'Registrarme'
    }
});

const emits = defineEmits(['close']);

const save = () => {
    let request = {
        'document': document.value,
        'full_name': full_name.value,
        'email': email.value,
        'cell_phone': cell_phone.value,
    };

    messages.value = {};
    axios.post('api/registrar', request)
    .then(response => {
        messages.value = response.data;
        console.log(messages.value);
        showAlert('Exito', 'success');
        emits('close');
        document.value = '';
        full_name.value = '';
        email.value = '';
        cell_phone.value = '';
    })
    .catch(error => {
        if (error.response && error.response.status === 422) {
            messages.value.document = error.response.data.document;
            messages.value.full_name = error.response.data.full_name;
            messages.value.email = error.response.data.email;
            messages.value.cell_phone = error.response.data.cell_phone;
            console.log(error.response);
        } else {
            console.error(error.response);
            messages.value = error.response;
            showAlert("Oops...", "error");
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

const closeModal = () => {
    emits('close');
};

</script>

<template>
<div v-if="show" class="modal fade show" tabindex="-1" style="display: block;">
    <div class="modal-dialog modal-md margin-top">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="text-primary fa-regular fa-circle-check"></i> {{ title }}</h5>
                <button type="button" class="btn-close" @click="closeModal"></button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <div class="container">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div :class="['form-group', {'has-error': messages.document}]">
                                        <label for="document">Documento<strong class="text-danger"> *</strong></label>
                                        <input class="form-control text-sm form-control-solid" v-model="document" type="text" placeholder="TI, CC, CE, NIT" />
                                        <span v-if="messages.document" class="text-danger">{{ messages.document }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div :class="['form-group', {'has-error': messages.full_name}]">
                                        <label for="name">Nombre completo<strong class="text-danger"> *</strong></label>
                                        <input class="form-control text-sm form-control-solid" v-model="full_name" type="text" placeholder="Nombres y apellidos" />
                                        <span v-if="messages.full_name" class="text-danger">{{ messages.full_name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div :class="['form-group', {'has-error': messages.email}]">
                                        <label for="name">Correo electrónico<strong class="text-danger"> *</strong></label>
                                        <input class="form-control text-sm form-control-solid" v-model="email" type="text" placeholder="ejemplo@gmail.com" />
                                        <span v-if="messages.email" class="text-danger">{{ messages.email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div :class="['form-group', {'has-error': messages.cell_phone}]">
                                        <label for="name">Celular<strong class="text-danger"> *</strong></label>
                                        <input class="form-control text-sm form-control-solid" v-model="cell_phone" type="text" placeholder="+57" />
                                        <span v-if="messages.cell_phone" class="text-danger">{{ messages.cell_phone }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-2">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-secondary" @click="closeModal"><i class="fa-solid fa-arrow-left"></i></button>
                                    <button @click.prevent="save()" class="btn btn-outline-primary ms-2"><i class="fa-solid fa-save me-2"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div v-if="show" class="modal-backdrop fade show"></div>
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