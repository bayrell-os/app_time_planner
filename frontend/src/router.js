import Vue from 'vue';
import VueRouter from 'vue-router';
import Main from './pages/Main.vue';

export default function(params)
{
	params["router"] = new VueRouter({
		mode: 'history',
		base: '/',
		routes:
		[
			{
				path: '/',
				component: Main,
				props: { default: true, namespace: ["page", "Main"] }
			}
		],
	});
	
	params["store"].registerModule(["page", "Main"], Main.buildStore());
	
	return params;
}
