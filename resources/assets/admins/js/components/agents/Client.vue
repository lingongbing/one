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
					<nav aria-label="...">
						<ul class="pager">
							<li v-show="paginate.prev_page_url" @click="getItems(--paginate.current_page)">
								<a href="javascript:;">Previous</a>
							</li>
							<li v-show="paginate.next_page_url" @click="getItems(++paginate.current_page)">
								<a href="javascript:;">Next</a>
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
				},
				paginate: {
					current_page: 1,
					prev_page_url: '',
					next_page_url: '',
				},
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
				this.params.page = page;
				this.params.parent_id = this.user_id;
				window.axios.get('users', {
					params: this.params
				}).then(response => {
					this.items = response.data.data;
					this.paginate.current_page = response.data.meta.pagination.current_page;
					if (response.data.meta.pagination.links) {
						this.paginate.prev_page_url = response.data.meta.pagination.links.previous;
						this.paginate.next_page_url = response.data.meta.pagination.links.next;
					}
				});
			}
		}
	}
</script>

<style scoped>

</style>