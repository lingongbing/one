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
								<nav aria-label="Page navigation">
									<ul class="pagination">
										<li :class="{'disabled': page.current_page == 1}" @click="getAgent(page.current_page-1)">
											<a href="javascript:void(0);" aria-label="Previous">
												<span aria-hidden="true">&laquo;</span>
											</a>
										</li>
										<li :class="{'disabled': page.current_page == page.last_page}" @click="getAgent(page.current_page+1)">
											<a href="javascript:void(0);" aria-label="Next">
												<span aria-hidden="true">&raquo;</span>
											</a>
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
			}
		},
		created() {
			this.getAgent(1);
		},
		methods: {
			getAgent: function (page) {
				if (page < 1 || page > this.page.last_page)
				{
					return;
				}
				this.params.page = page;
				axios.get('/agent', {
					params:this.params
				}).then(response => {
					if (response.data.data[0])
					{
						this.setData(response.data);
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