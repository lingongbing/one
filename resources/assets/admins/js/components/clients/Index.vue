<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">所有客户</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-12" v-show="is_show_clients">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" class="form-control" v-model="params.username" placeholder="输入账号查询"
						       @change="params.from = 0,getClients()">
						<input type="text" class="form-control" v-model="params.name" placeholder="输入姓名查询"
						       @change="params.from = 0,getClients()">
						<input type="text" class="form-control" v-model="params.mobile" placeholder="输入电话查询"
						       @change="params.from = 0,getClients()">
						<input type="text" class="form-control" v-model="params.wechat" placeholder="输入微信查询"
						       @change="params.from = 0,getClients()">
						<input type="text" class="form-control" v-model="params.region" placeholder="输入地区查询"
						       @change="params.from = 0,getClients()">
						<v-select v-model="agent" :options="agents" v-if="this.$store.getters.role === 'admin'" @search="agentSearch"></v-select>
					</div>
				</div>
				<hr>
				<table class="table table-hover">
					<thead>
					<tr>
						<th>账号</th>
						<th>姓名</th>
						<th>手机</th>
						<th>微信</th>
						<th>地区</th>
						<th>注册时间</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="item in clients"
					    @click="is_show_clients = false,is_show_client = true,user_id = item.id">
						<td>{{ item.username }}</td>
						<td>{{ item.name }}</td>
						<td>{{ item.mobile }}</td>
						<td>{{ item.wechat }}</td>
						<td>{{ item.region }}</td>
						<td>{{ item.created_at }}</td>
					</tr>
					</tbody>
					<tfoot class="text-center">
					<tr>
						<td colspan="6">
							<nav aria-label="...">
								<ul class="pager">
									<li v-show="params.from > 0" @click="previousPage">
										<a href="javascript:void(0);" aria-label="Previous">
											<span aria-hidden="true">Previous</span>
										</a>
									</li>
									<li v-show="params.from < params.total && params.total - params.from > params.size" @click="nextPage">
										<a href="javascript:void(0);" aria-label="Next">
											<span aria-hidden="true">Next</span>
										</a>
									</li>
								</ul>
							</nav>
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-md-12" v-show="is_show_client">
				<div class="col-md-12">
					<button class="btn btn-default" type="button"
					        @click="is_show_clients = true,is_show_client = false,user_id = 0">返回
					</button>
					<hr>
				</div>
				<div class="col-md-6">
					<edit-user-form :user_id="user_id"></edit-user-form>
				</div>
				<div class="col-md-6">
					<skin-form :user_id="user_id"></skin-form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import EditUserForm from './EditUserForm';
	import SkinForm from './SkinForm';
	import vSelect from 'vue-select'
	export default {
		components: {
			SkinForm,
			EditUserForm,
			vSelect
		},
		data() {
			return {
				user_id: 0,
				is_show_client: false,
				is_show_clients: true,
				params: {
					from: 0,
					size: 10,
					total: 0,
					name: '',
					mobile: '',
					wechat: '',
					region: '',
					parent_id: '',
					username: '',
				},
				parent_id: 0,
				agent: {'label':'输入姓名手机或账号搜索代理','value':0},
				agents: [
					{'label':'输入姓名手机或账号搜索代理','value':0}
				],
				client: {},
				clients: {},
				agents_index: 0,
			}
		},
		watch:{
			agent:function () {
				this.params.from = 0;
				if (this.agent)
				{
					this.params.parent_id = this.agent.id;
				}
				this.getClients();
			}
		},
		created() {
			this.getClients();
		},
		methods: {
			getClients: function () {
				axios.get('clients', {params: this.params}).then(response => {
					this.clients = response.data.data;
					this.params.size = response.data.size;
					this.params.total = response.data.total;
					if (response.data.from) {
						this.params.from = response.data.from;
					}
				})
			},
			nextPage: function () {
				this.params.from = Number(this.params.from) + Number(this.params.size);
				if (this.params.from > this.params.total || this.params.total < this.params.size) {
					this.params.from = 0;
					return;
				}
				this.getClients();
			},
			previousPage: function () {
				this.params.from = Number(this.params.from) - Number(this.params.size);
				if (this.params.from < 0) {
					this.params.from = 0;
					return;
				}
				this.getClients();
			},
			agentSearch:function (search) {
				axios.get('/es/agents',{
					params:{
						keyword:search
					}
				}).then(response => {
					this.agents = response.data.data;
					this.agents.forEach(function (item) {
						item.label = item.name + ' ' + item.mobile + ' ' + item.username;
					})
				})
			},
		}
	}
</script>

<style scoped>

</style>