<template>
	<div>
		<thead>
		<div class="form-inline">
			<div class="form-group">
				<input type="text" class="form-control" v-model="params.username" id="username" placeholder="账号" @change="getItems(this.current_page)">
			</div>
		</div>
		</thead>
		<hr>
		<table class="table table-hover" v-show="items[0]">
			<tbody>
			<tr v-for="item in items">
				<td>{{ item.username }}</td>
				<td>{{ item.name }}</td>
				<td>{{ item.mobile }}</td>
			</tr>
			</tbody>
			<tfoot class="text-center">
			<tr>
				<td colspan="3">
					<nav aria-label="Page navigation">
						<ul class="pagination">
							<li :class="{'disabled': pages.current_page == 1}"
							    @click="--params.page,getItems(pages.current_page -1)">
								<a href="javascript:void(0);" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
								</a>
							</li>
							<li :class="{'disabled': pages.current_page == pages.last_page}"
							    @click="++params.page,getItems(pages.current_page +1)">
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
		<div v-show="!items[0]" class="text-center">
			<span v-show="params.username">没有找到这个客户</span>
			<span v-show="!params.username">他没有客户</span>
			
		</div>
	</div>
</template>

<script>
	export default {
		props: [
			'user_id'
		],
		data() {
			return {
				items: {},
				pages: {
					last_page: 1,
					current_page: 1,
				},
				params: {
					page: 1,
					username: '',
				}
			}
		},
		watch: {
			user_id: function () {
				this.getItems();
			}
		},
		created: function () {
			this.getItems(1);
		},
		methods: {
			getItems: function (page) {
				if (page < 1 || page > this.pages.last_page)
				{
					return;
				}
				this.params.page = page;
				axios.get('/agent-of-client/' + this.user_id, {
					params: this.params
				}).then(response => {
					this.setData(response.data);
				}).catch(error => {

				});
			},
			setData: function (data) {
				this.items = data.data;
				this.pages.last_page = data.last_page;
				this.pages.current_page = data.current_page;
			}
		}
	}
</script>

<style scoped>

</style>