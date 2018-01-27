import VueRouter from 'vue-router'

const routes = [
	{
		path: '/',
		name: 'home',
		component: require('./components/homes/Index'),
	},
	{
		path: '/orders',
		name: 'orders',
		component: require('./components/orders/Index'),
	},
];

const router = new VueRouter({
	mode: 'history',
	routes
});

export default router;