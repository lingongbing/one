<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">所有代理</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" class="form-control" v-model="params.username" id="username" placeholder="输入账号查询" @change="getAgent(page.current_page)">
					</div>
				</div>
				<hr>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>账号</th>
							<th>姓名</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(agent,index) in agents">
							<td @click="user_id = agent.id,show_user=true,show_client=false">{{ agent.username }}</td>
							<td @click="user_id = agent.id,show_user=true,show_client=false">{{ agent.name }}</td>
							<td @click="user_id = agent.id,show_user=false,show_client=true">
								<button class="btn btn-xs btn-block btn-default">他的客户</button>
							</td>
						</tr>
					</tbody>
					<tfoot class="text-center">
						<tr>
							<td colspan="3">
								<nav aria-label="...">
									<ul class="pager">
										<li v-show="paginate.prev_page_url" @click="getAgent(--paginate.current_page)">
											<a href="javascript:;">Previous</a>
										</li>
										<li v-show="paginate.next_page_url" @click="getAgent(++paginate.current_page)">
											<a href="javascript:;">Next</a>
										</li>
									</ul>
								</nav>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-md-6">
				<user :user_id="user_id" v-if="show_user"></user>
				<client :user_id="user_id" v-if="show_client"></client>
			</div>
		</div>
	</div>
</template>

<script>
	import User from './User';
	import Client from './Client';
	export default {
		components: {
			'User' : User,
			'Client' : Client,
		},
		data() {
			return {
				user_id: 0,
				show_user: false,
				show_client: false,
				page: {
					last_page:1,
					current_page:1,
				},
				agents: {},
				params: {
					page:1,
					username:'',
				},
				paginate: {
					current_page: 1,
					prev_page_url: '',
					next_page_url: '',
				},
			}
		},
		created() {
			this.getAgent();
		},
		methods: {
			getAgent: function (page) {
				this.params.page = page;
				window.axios.get('agents', {
					params:this.params
				}).then(response => {
					this.agents = response.data.data;
					this.paginate.current_page = response.data.meta.pagination.current_page;
					if (response.data.meta.pagination.links) {
						this.paginate.prev_page_url = response.data.meta.pagination.links.previous;
						this.paginate.next_page_url = response.data.meta.pagination.links.next;
					}
				}).catch(error => {

				});
			},
			setData: function (data) {
				this.agents = data.data;
				this.page.last_page = data.last_page;
				this.page.current_page = data.current_page;
			},
		}
	}
</script>

<style scoped>

</style>