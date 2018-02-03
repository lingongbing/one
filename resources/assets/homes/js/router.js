import VueRouter from 'vue-router';
import Store from './stores/index';

const routes = [
	{
		path: '',
		name: 'home',
		component: require('./components/homes/Index'),
	},
	{
		path: '/orders',
		name: 'orders',
		component: require('./components/orders/Index'),
		meta: {authorizations: true},
	},
	{
		path: '/authorizations',
		name: 'authorizations',
		component: require('./components/authorizations/Create'),
	},
	{
		path: '/password/reset',
		name: 'password-reset',
		component: require('./components/passwords/Reset'),
	},
	{
		path: '/users/create',
		name: 'user-create',
		component: require('./components/users/Create'),
	},
	{
		path: '/orders/:order',
		name: 'orders-show',
		component: require('./components/orders/Show'),
		meta: {authorizations: true},
	},
	{
		path: '/users/show',
		name: 'users-show',
		component: require('./components/users/User'),
		meta: {authorizations: true},
	},
	{
		path: '/skins/show',
		name: 'skins-show',
		component: require('./components/skins/Skins'),
		meta: {authorizations: true},
	},
	{
		path: '/integrals/exchange',
		name: 'integrals-exchange',
		component: require('./components/integrals/Exchange'),
		meta: {authorizations: true},
	},
	{
		path: '/integrals/query',
		name: 'integrals-query',
		component: require('./components/integrals/Query'),
		meta: {authorizations: true},
	},
];

const router = new VueRouter({
	mode: 'history',
	routes
});

router.beforeEach((to, form, next) => {
	if (to.matched.some(record => record.meta.authorizations)) {
		if (Store.getters.authenticate) {
			next();
		} else {
			next({name: 'authorizations'});
		}
	} else {
		next();
	}
});

export default router;