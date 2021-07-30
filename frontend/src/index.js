import "./main.scss";

import { createApp } from 'vue'
import App from './App.vue'
import Router from './Router'
import Store from './Store'

createApp(App)
	.use(Store)
	.use(Router)
	.mount('#app')
