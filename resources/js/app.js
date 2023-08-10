import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import Main from './components/Login.vue';
app.component('main-component', Main);

app.mount('#app');
