import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import Main from './components/Index.vue';
import Verification from './components/PaymentVerification.vue';

app.component('main-component', Main);
app.component('verification-component', Verification);

app.mount('#app');
