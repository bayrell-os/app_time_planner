import Vue from 'vue';
import VueRouter from 'vue-router';
import Main from './pages/Main.vue';
import TaskList from './pages/TaskList.vue';

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
			},
			{
				path: '/tasks/',
				component: TaskList,
				props: { default: true, namespace: ["page", "TaskList"] }
			}
		],
	});
	
	params["store"].registerModule(["page", "Main"], Main.buildStore());
	params["store"].registerModule(["page", "TaskList"], TaskList.buildStore());
	
	return params;
}
