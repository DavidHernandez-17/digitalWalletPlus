import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import Main from './components/Index.vue';
import Verification from './components/PaymentVerification.vue';
import CheckBalance from './components/CheckBalance.vue';

app.component('main-component', Main);
app.component('verification-component', Verification);
app.component('checkbalance-component', CheckBalance);

app.mount('#app');
