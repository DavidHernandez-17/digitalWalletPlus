<script setup>
import { ref } from 'vue';
import ModalRegister from './ModalRegister.vue';
import Reload from './Reload.vue';
import Pay from './Pay.vue';
import Balance from './Balance.vue';

const isLoading = ref(false);
const showButton = ref(true);
const showModalRegister = ref(false);
const showReload = ref(false);
const showLogin = ref(true);
const showPay = ref(false);
const showBalance = ref(false);

const toggleModal = (component) => {
    if (component == 'register') {
        showModalRegister.value = !showModalRegister.value;
    }

    if (component == 'reload') {
        showLogin.value = !showLogin.value;
        showReload.value = !showReload.value;
    }

    if (component == 'pay') {
        showLogin.value = !showLogin.value;
        showPay.value = !showPay.value;
    }

    if (component == 'balance') {
        showLogin.value = !showLogin.value;
        showBalance.value = !showBalance.value;
    }
}

</script>

<template>
    <div v-if="showLogin" class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                <div class="margin-top-verification">
                    <div class="card-body p-5 text-center">
                        <!-- <img class="logo-login-lateral" src="/assets/img/brand/wallet_main.jpg" alt="vista principal"/> -->
                        <div class="h1 text-primary larger-text"><strong>Billetera digital</strong><h5>plus <i class="fa-regular fa-copyright small"></i></h5></div>
                        <p class="small text-white">Elige una de estas opciones de acuerdo con lo que necesitas. Nunca fue tan fácil administrar tu dinero</p>

                        <form>
                            <div class="col-md-10 offset-1 offset-sm-1">
                                <div class="row">
                                    <div class="btn-group mt-3">
                                        <button @click.prevent="toggleModal('register')" :disabled="isLoading" 
                                            class="btn btn-lg btn-light m-1"
                                            v-show="showButton"
                                            type="submit">
                                            Registrarse
                                        </button>
                                        <button @click.prevent="toggleModal('register')" class="btn btn-lg btn-primary">
                                            <span v-if="isLoading">
                                                <i class="fa-solid fa-spinner fa-spin ms-2"></i>
                                            </span>
                                        <i class="fa-regular fa-circle-check"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="btn-group mt-3">
                                        <button @click.prevent="toggleModal('reload')" :disabled="isLoading" 
                                            class="btn btn-lg btn-light m-1"
                                            v-show="showButton"
                                            type="submit">
                                            Recargar
                                        </button>
                                        <button @click.prevent="toggleModal('reload')" class="btn btn-lg btn-primary">
                                            <span v-if="isLoading">
                                                <i class="fa-solid fa-spinner fa-spin ms-2"></i>
                                            </span>
                                            <i class="fa-solid fa-bolt"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="btn-group mt-3">
                                        <button @click.prevent="toggleModal('pay')" :disabled="isLoading" 
                                            class="btn btn-lg btn-light m-1"
                                            v-show="showButton"
                                            type="submit">
                                            Pagar
                                        </button>
                                        <button @click.prevent="toggleModal('pay')" class="btn btn-lg btn-primary">
                                            <span v-if="isLoading">
                                                <i class="fa-solid fa-spinner fa-spin ms-2"></i>
                                            </span>
                                            <i class="fa-solid fa-dollar-sign"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="btn-group mt-3">
                                        <button @click.prevent="toggleModal('balance')" :disabled="isLoading" 
                                            class="btn btn-lg btn-light m-1"
                                            v-show="showButton"
                                            type="submit">
                                            Saldo
                                        </button>
                                        <button @click.prevent="toggleModal('balance')" class="btn btn-lg btn-primary">
                                            <span v-if="isLoading">
                                                <i class="fa-solid fa-spinner fa-spin ms-2"></i>
                                            </span>
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <ModalRegister :show="showModalRegister" @close="toggleModal('register')"/>
    </div>
    <div v-show="showReload">
        <Reload :show="showReload" @close="toggleModal('reload')"/>
    </div>
    <div v-show="showPay">
        <Pay :show="showPay" @close="toggleModal('pay')"/>
    </div>
    <div v-show="showBalance">
        <Balance :show="showBalance" @close="toggleModal('balance')"/>
    </div>
</template>