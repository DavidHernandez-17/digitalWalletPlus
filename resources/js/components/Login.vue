<script setup>
import { ref } from 'vue';
import AppLayout from './Layout.vue';

const isLoading = ref(false);
const showButton = ref(true);

</script>

<template>
    <AppLayout>
        <template #content>
            <div class="container-xl px-4">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                        <div class="margin-top-login">
                            <div class="card-body p-5 text-center">
                                <!-- <img class="logo-login-lateral" src="/assets/img/brand/wallet_main.jpg" alt="vista principal"/> -->
                                <div class="h1 text-primary larger-text"><strong>Billetera digital</strong><h5>plus <i class="fa-regular fa-copyright small"></i></h5></div>
                                <p class="small text-white">Elige una de estas opciones de acuerdo con lo que necesitas. Nunca fue tan fácil administrar tu dinero</p>

                                <form>
                                    <div class="col-md-10 offset-1 offset-sm-1">
                                        <!-- <div class="message">
                                            <p v-if="message.length">
                                                <span :class="styles" v-for="error in message" :key="error.id">{{ error }}</span>                                                    
                                            </p>
                                        </div> -->
                                        <div class="row">
                                            <div class="btn-group mt-3">
                                                <button @click.prevent="submitForm" :disabled="isLoading" 
                                                    class="btn btn-lg btn-light m-1"
                                                    v-show="showButton"
                                                    type="submit">
                                                    Registrarse
                                                </button>
                                                <button @click.prevent="submitForm" class="btn btn-lg btn-primary">
                                                    <span v-if="isLoading">
                                                        <i class="fa-solid fa-spinner fa-spin ms-2"></i>
                                                    </span>
                                                <i class="fa-regular fa-circle-check"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="btn-group mt-3">
                                                <button @click.prevent="submitForm" :disabled="isLoading" 
                                                    class="btn btn-lg btn-light m-1"
                                                    v-show="showButton"
                                                    type="submit">
                                                    Recargar
                                                </button>
                                                <button @click.prevent="submitForm" class="btn btn-lg btn-primary">
                                                    <span v-if="isLoading">
                                                        <i class="fa-solid fa-spinner fa-spin ms-2"></i>
                                                    </span>
                                                    <i class="fa-solid fa-bolt"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="btn-group mt-3">
                                                <button @click.prevent="submitForm" :disabled="isLoading" 
                                                    class="btn btn-lg btn-light m-1"
                                                    v-show="showButton"
                                                    type="submit">
                                                    Pagar
                                                </button>
                                                <button @click.prevent="submitForm" class="btn btn-lg btn-primary">
                                                    <span v-if="isLoading">
                                                        <i class="fa-solid fa-spinner fa-spin ms-2"></i>
                                                    </span>
                                                    <i class="fa-solid fa-dollar-sign"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="btn-group mt-3">
                                                <button @click.prevent="submitForm" :disabled="isLoading" 
                                                    class="btn btn-lg btn-light m-1"
                                                    v-show="showButton"
                                                    type="submit">
                                                    Saldo
                                                </button>
                                                <button @click.prevent="submitForm" class="btn btn-lg btn-primary">
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
            </div>
        </template>
    </AppLayout>
</template>