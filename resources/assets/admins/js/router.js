import VueRouter from 'vue-router'
import Store from './stores/index'
import JWT from './helpers/jwt'

const routes = [
	{
		path: '',
		name: 'index',
		component: require('./components/Index'),
		meta: {authenticate: true},
	},
	{
		path: '/login',
		name: 'login',
		component: require('./components/logins/Login'),
		beforeEnter: (to, from, next) => {
			if (Store.getters.authenticate) {
				next({name:'index'});
			} else {
				next();
			}
		}
	},
	{
		path: '/password-reset',
		name: 'password-reset',
		component: require('./components/passwords/Reset'),
	},
	{
		path: '/aliyun-sms',
		name: 'aliyun-sms',
		component: require('./components/aliyuns/Sms'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/aliyun-kdi',
		name: 'aliyun-kdi',
		component: require('./components/aliyuns/Kdi'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/system',
		name: 'system',
		component: require('./components/systems/System'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/agent-set',
		name: 'agent-set',
		component: require('./components/agents/Set'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/agent-level',
		name: 'agent-level',
		component: require('./components/agents/Level'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/agent-create',
		name: 'agent-create',
		component: require('./components/agents/Create'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/site-set',
		name: 'site-set',
		component: require('./components/sites/Set'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/all-agent',
		name: 'all-agent',
		component: require('./components/agents/Index'),
		meta: {authenticate: true},
	},
	{
		path: '/client',
		name: 'client',
		component: require('./components/clients/Index'),
		meta: {authenticate: true},
	},
	{
		path: '/client-create',
		name: 'client-create',
		component: require('./components/clients/Create'),
		meta: {authenticate: true},
	},
	{
		path: '/integrals-rule',
		name: 'integrals-rule',
		component: require('./components/integrals/Rule'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/orders/:state',
		name: 'orders',
		component: require('./components/orders/Index'),
		meta: {authenticate: true},
	},
	{
		path: '/orders-create',
		name: 'orders-create',
		component: require('./components/orders/Create'),
		meta: {authenticate: true},
	},
	{
		path: '/goods',
		name: 'goods',
		component: require('./components/goods/Index'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/orders-count',
		name: 'orders-count',
		component: require('./components/orders/Count'),
		meta: {authenticate: true},
	},
	{
		path: '/menus',
		name: 'menus',
		component: require('./components/menus/Index'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/integrals-goods',
		name: 'integrals-goods',
		component: require('./components/integrals_goods/Index'),
		meta: {authenticate: true,is_admin: true},
	},
	{
		path: '/homes-swipe',
		name: 'homes-swipe',
		component: require('./components/homes/Swipe'),
		meta: {authenticate: true,home_management:true},
	},
	{
		path: '/homes-contents',
		name: 'homes-contents',
		component: require('./components/homes/Content'),
		meta: {authenticate: true,home_management:true},
	},
];

const router = new VueRouter({
	mode: 'history',
	routes
});

router.beforeEach((to, form, next) => {
	if (to.meta.authenticate) {
		if (Store.getters.authenticate) {
			next();
		} else {
			next({name:'login'});
		}
	}
	if (to.meta.is_admin) {
		if (Store.getters.role === 'admin') {
			next();
		} else {
			next({name:'index'});
		}
	}
	if (to.meta.home_management) {
		if (Store.getters.role === 'admin' || Store.getters.role === 'home_management') {
			next();
		} else {
			next({name:'index'});
		}
	}
	next();
});

export default router;