<script setup>
import { computed, ref } from "vue";

const showComponent = ref(true);
const code = ref('');
const message = ref([]);
const status = ref('');
const inputs = ref(["", "", "", "", "", ""]);

const props = defineProps({
    id_customer: {
        type: String,
        default: 0,
        required: true
    },
    id_session: {
        type: String,
        default: '',
        required: true
    }
});

const submitForm = async() => {
    message.value = [];
    let request = {
        'document': props.id_customer,
        'id_session': props.id_session,
        'code': code.value,
    };

    if (!code.value){
        message.value.push('El campo es requerido.');
    }
    else{
        await axios.post('/api/billetera/confirmar/pago', request )
        .then(res=>{
            alert('El pago se realizó correctamente');
        })
        .catch(err=>{
            console.log(err);
            message.value.push(err.response.data[1])
        })
    }
}

const cancelPayment = async() => {

}

const showButton = computed(() => {
    code.value = inputs.value.join("");
    return code.value.toString().length === 6;
});

const styles = computed(() => {
    return status.value ? ['success'] : ['error'];
});

const handleInput = (index, event) => {
    const input = event.target;
    const nextInput = input.nextElementSibling
    if( nextInput && input.value ){
        nextInput.focus();
        if (nextInput.value) {
            nextInput.select();
        }
    }
}

const handlePaste = (event) => {
    event.preventDefault()
    const paste = event.clipboardData.getData('text')
    const inputs = event.target.parentNode.querySelectorAll('input')
    inputs.forEach((input, i) => {
        inputs[i].value = paste[i] || '';
    })
}

const handleFocus = (event) => {
    setTimeout(() => {
    event.target.select()
    }, 0)
}

const handleKeyDown = (index, event) => {
    const inputs = event.target.parentNode.querySelectorAll('input')
    switch (event.keyCode) {
        case 8: // Backspace
        event.preventDefault()
        if (event.target.value) {
            event.target.value = ''
            break
        }
        if (index === 0) {
            break
        }
        inputs[index - 1].focus()
        break
        case 37: // ArrowLeft
        if (!inputs[index - 1]) {
            break
        }
        inputs[index - 1].focus()
            break
        case 39: // ArrowRight
        if (!inputs[index + 1]) {
            break
        }
        inputs[index + 1].focus()
        break
    }
}



</script>

<template>
    <div v-if="showComponent" class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8 col-sm-11">
                <div class="margin-top-verification">
                    <div class="card-body p-5 text-center">
                        <div class="h5 text-primary larger-text">Confirmación de pagos</div>
                        <div class="h1 text-primary larger-text"><strong>Billetera digital</strong><h5>plus <i class="fa-regular fa-copyright small"></i></h5></div>
                        <p class="text-secondary">Ingresa el código de seguridad enviado a su correo electrónico</p>

                        <form>
                            <div class="d-flex mb-3">
                                <input type="tel" maxlength="1" pattern="[0-9]" class="form-control custom-input m-1  py-3 text-center" required
                                    v-for="(input, index) in inputs" :key="index"
                                    v-model="inputs[index]"
                                    @keydown="handleKeyDown(index, $event)"
                                    @input="handleInput(index, $event)"
                                    @paste="handlePaste($event)"
                                    @focus="handleFocus($event)"
                                    @keydown.enter="submitForm()"
                                >
                            </div>

                            <div class="message">
                                <p v-if="message.length">
                                    <span :class="styles" v-for="error in message" :key="error.id">{{ error }}</span>
                                </p>
                            </div>

                            <div>
                                <div class="row px-3">
                                    <button @click.prevent="submitForm" :disabled="!showButton"
                                        class="btn btn-lg btn-outline-primary"
                                        type="submit"
                                    >
                                        Confirmar compra
                                    </button>
                                </div>
                                <div class="row px-3 mt-2">
                                    <button @click.prevent="cancelPayment"
                                        class="btn btn-lg btn-outline-secondary"
                                        type="submit"
                                    >
                                        Cancelar
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