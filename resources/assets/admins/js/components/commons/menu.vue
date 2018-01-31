<template>
	<div class="nav">
		<div class="nav-top">
			<div id="mini" style="border-bottom:1px solid rgba(255,255,255,.1)" @click="toggleMini()"><img
					src="/images/mini.png"></div>
		</div>
		<ul>
			<li class="nav-item">
				<a href="javascript:;" @click="toggleMenu('nav-item-order')" id="nav-item-order"><i
						class="my-icon nav-icon icon_2"></i><span>订单管理</span><i class="my-icon nav-more"></i></a>
				<ul>
					<li>
						<router-link :to="{ name: 'orders-create' }" tag="a">
							<span>新增订单</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'orders' , params: { state : 1 } }" tag="a">
							<span>正在交易</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'orders' , params: { state : 2 } }" tag="a">
							<span>已经完成</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'orders-count' }" tag="a">
							<span>交易统计</span>
						</router-link>
					</li>
					<li v-show="this.$store.getters.role == 'admin'">
						<router-link :to="{ name: 'goods' }" tag="a">
							<span>商品管理</span>
						</router-link>
					</li>
				</ul>
			</li>
			<li class="nav-item" v-show="this.$store.getters.role == 'admin'">
				<a href="javascript:;" @click="toggleMenu('nav-item-proxy')" id="nav-item-proxy"><i
						class="my-icon nav-icon icon-user"></i><span>代理管理</span><i class="my-icon nav-more"></i></a>
				<ul>
					<li>
						<router-link :to="{ name: 'agent-create'}" tag="a">
							<span>新增代理</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'agent-level'}" tag="a">
							<span>代理级别</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'agent-set'}" tag="a">
							<span>权限设置</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'all-agent'}" tag="a">
							<span>所有代理</span>
						</router-link>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a href="javascript:;" @click="toggleMenu('nav-item-client')" id="nav-item-client"><i
						class="my-icon nav-icon icon-users"></i><span>客户管理</span><i class="my-icon nav-more"></i></a>
				<ul>
					<li>
						<router-link :to="{ name: 'client-create'}" tag="a">
							<span>新增客户</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'client'}" tag="a">
							<span>所有客户</span>
						</router-link>
					</li>
				</ul>
			</li>
			<li class="nav-item" v-show="this.$store.getters.role == 'admin'">
				<a href="javascript:;" @click="toggleMenu('nav-item-integral')" id="nav-item-integral"><i
						class="my-icon nav-icon icon_3"></i><span>积分管理</span><i class="my-icon nav-more"></i></a>
				<ul>
					<li>
						<router-link :to="{ name: 'integrals-rule'}" tag="a">
							<span>积分规则</span>
						</router-link>
					</li>
					<li>
						<a href="#">
							<router-link :to="{ name: 'index', params: { userId: 123 }}" tag="span">积分兑换商品设置
							</router-link>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item"
			    v-show="this.$store.getters.role == 'admin' || this.$store.getters.role == 'home_management'">
				<a href="javascript:;" @click="toggleMenu('nav-item-index')" id="nav-item-index"><i
						class="my-icon nav-icon icon_3"></i><span>首页管理</span><i class="my-icon nav-more"></i></a>
				<ul>
					<li>
						<router-link :to="{ name: 'homes-swipe'}" tag="a">
							<span>首页轮播图设置</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'homes-contents'}" tag="a">
							<span>首页内容管理</span>
						</router-link>
					</li>
					<li>
						<a href="#">
							<router-link :to="{ name: 'index', params: { userId: 123 }}" tag="span">通知发送</router-link>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item" v-show="this.$store.getters.role == 'admin'">
				<a href="javascript:;" @click="toggleMenu('nav-item-system')" id="nav-item-system"><i
						class="my-icon nav-icon icon-shezhichilun"></i><span>系统管理</span><i class="my-icon nav-more"></i></a>
				<ul>
					<li>
						<router-link :to="{ name: 'password-reset'}" tag="a">
							<span>更改密码</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'site-set'}" tag="a">
							<span>网站logo级版权设置</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'menus'}" tag="a">
							<span>菜单栏管理</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'aliyun-sms'}" tag="a">
							<span>阿里云短信设置</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'aliyun-kdi'}" tag="a">
							<span>阿里云云市场快递查询设置</span>
						</router-link>
					</li>
					<li>
						<router-link :to="{ name: 'system'}" tag="a">
							<span>系统运行状态</span>
						</router-link>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		data() {
			return {}
		},
		created() {

		},
		methods: {
			toggleMenu: function (dom_id) {
				if (!$('.nav').hasClass('nav-mini')) {
					if ($('#' + dom_id).next().css('display') == "none") {
						//展开未展开
						$('.nav-item').children('ul').slideUp(300);
						$('#' + dom_id).next('ul').slideDown(300);
						$('#' + dom_id).parent('li').addClass('nav-show').siblings('li').removeClass('nav-show');
					} else {
						//收缩已展开
						$('#' + dom_id).next('ul').slideUp(300);
						$('.nav-item.nav-show').removeClass('nav-show');
					}
				}
			},
			toggleMini: function () {
				if (!$('.nav').hasClass('nav-mini')) {
					$('.nav-item.nav-show').removeClass('nav-show');
					$('.nav-item').children('ul').removeAttr('style');
					$('.nav').addClass('nav-mini');
				} else {
					$('.nav').removeClass('nav-mini');
				}
			}
		}
	}
</script>

<style scoped>
	@charset "utf-8";
	/* 以下实际使用若已初始化可删除 .nav height父级需逐级设置为100%*/
	body, html {
		height: 100%;
		background: #E2E2E2
	}
	
	body, ul {
		margin: 0;
		padding: 0
	}
	
	body {
		font: 14px "微软雅黑", "宋体", "Arial Narrow", HELVETICA;
		-webkit-text-size-adjust: 100%;
	}
	
	li {
		list-style: none
	}
	
	a {
		text-decoration: none;
	}
	
	/* 以上实际使用若已初始化可删除 */
	
	/* nav */
	.nav {
		width: 220px;
		height: 100%;
		background: #263238;
		transition: all .3s;
	}
	
	.nav a {
		display: block;
		overflow: hidden;
		padding-left: 20px;
		line-height: 46px;
		max-height: 46px;
		color: #ABB1B7;
		transition: all .3s;
	}
	
	.nav a span {
		margin-left: 30px;
	}
	
	.nav-item {
		position: relative;
	}
	
	.nav-item.nav-show {
		border-bottom: none;
	}
	
	.nav-item ul {
		display: none;
		background: rgba(0, 0, 0, .1);
	}
	
	.nav-item.nav-show ul {
		display: block;
	}
	
	.nav-item > a:before {
		content: "";
		position: absolute;
		left: 0px;
		width: 2px;
		height: 46px;
		background: #34A0CE;
		opacity: 0;
		transition: all .3s;
	}
	
	.nav .nav-icon {
		font-size: 20px;
		position: absolute;
		margin-left: -1px;
	}
	
	/* 此处修改导航图标 可自定义iconfont 替换*/
	.icon_1::after {
		content: "\e62b";
	}
	
	.icon_2::after {
		content: "\e669";
	}
	
	.icon_3::after {
		content: "\e61d";
	}
	
	/*---------------------*/
	.nav-more {
		float: right;
		margin-right: 20px;
		font-size: 12px;
		transition: transform .3s;
	}
	
	/* 此处为导航右侧箭头 如果自定义iconfont 也需要替换*/
	.nav-more::after {
		content: "\e621";
	}
	
	/*---------------------*/
	.nav-show .nav-more {
		transform: rotate(90deg);
	}
	
	.nav-show, .nav-item > a:hover {
		color: #FFF;
		background: rgba(0, 0, 0, .1);
	}
	
	.nav-show > a:before, .nav-item > a:hover:before {
		opacity: 1;
	}
	
	.nav-item li:hover a {
		color: #FFF;
		background: rgba(0, 0, 0, .1);
	}
	
	/* nav-mini */
	.nav-mini.nav {
		width: 60px;
	}
	
	.nav-mini.nav .nav-icon { /* margin-left:-2px; */
	}
	
	.nav-mini.nav .nav-item > a span {
		display: none;
	}
	
	.nav-mini.nav .nav-more {
		margin-right: -20px;
	}
	
	.nav-mini.nav .nav-item ul {
		position: absolute;
		top: 0px;
		left: 60px;
		width: 180px;
		z-index: 99;
		background: #3C474C;
		overflow: hidden;
	}
	
	.nav-mini.nav .nav-item:hover {
		background: rgba(255, 255, 255, .1);
	}
	
	.nav-mini.nav .nav-item:hover .nav-item a {
		color: #FFF;
	}
	
	.nav-mini.nav .nav-item:hover a:before {
		opacity: 1;
	}
	
	.nav-mini.nav .nav-item:hover ul {
		display: block;
	}
</style>