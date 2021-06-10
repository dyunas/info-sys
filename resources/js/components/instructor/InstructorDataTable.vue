<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Instructor Table
			</h5>
			<div class="card-tools">
				<button type="button" class="btn btn-sm btn-primary" @click="addNewInstructor">
					<i class="fas fa-user-plus mr-2"></i>
					Add new instructor
				</button>
			</div>
		</div>

		<div class="card-body">
			<data-table
				:url="url"
				:classes="classes"
				:data="data"
				:columns="columns"
				@on-table-props-changed="reloadTable"
			>
				<tbody slot="body" slot-scope="{ data }">
            <tr
							v-for="(item, index) in data"
							:key="index"
						>
							<td>{{ item.id }}</td>
							<td>{{ item.username }}</td>
							<td>{{ item.email }}</td>
							<td>
								<template v-for="(role, idx) in item.roles">
									<span
										:key="idx"
										class="badge badge-primary"
										style="padding: 5px 7px 5px 7px; font-size: 12px; margin-left: 3px;"
									>
										{{ role.name }}
									</span>
								</template>
							</td>
							<td>
								<data-table-cell
									:value="item"
									:name="columns[4].name"
									:classes="columns[4].classes"
									:event="columns[4].event"
									:comp="columns[4].component"
									:handler="columns[4].handler"
								/>
							</td>
            </tr>
        </tbody>
			</data-table>
		</div>
	</div>
</template>

<script>
import DataTable from "laravel-vue-datatable";
import CustomTableDesign from "../mixins/CustomTableStyle.js";
import DtViewBtn from '../inputs/DtViewBtn'

Vue.use(DataTable);

export default {
	components: {
		DtViewBtn
	},

	mixins: [CustomTableDesign],

	data() {
		return {
			url: "http://localhost:8000/api/users/instructors",
			actionUrl: "http://localhost:8000/api",
			showModal: false,
			data: {},
			isLoading: false,
			tableProps: {
				search: "",
				length: 10,
				column: "id",
				dir: "asc"
			},
			debounceDelay: 500,
			columns: [
				{
					label: "ID",
					name: "id",
					columnName: 'users.id',
					orderable: true
				},
				{
					label: "USERNAME",
					name: "username",
					columnName: 'users.username',
					orderable: true
				},
				{
					label: "EMAIL",
					name: "email",
					columnName: 'users.email',
					orderable: true
				},
				{
					label: "ROLE",
					name: "roles",
					columnName: "roles.name",
					orderable: true
				},
				{
					label: "ACTION",
					name: "view",
					orderable: false,
					classes: {
						btn: true,
						"btn-primary": true,
						"btn-sm": true
					},
					event: "click",
					handler: this.handleAction,
					component: DtViewBtn
				}
			]
		};
	},

	created() {
		this.getData(this.url);
	},

	methods: {
		getData(url = this.url, options = this.tableProps) {
			axios
				.get(url, {
					params: options
				})
				.then(response => {
					this.data = response.data;
				})
				.catch(error => {
					console.log(error.response.data);
				});
		},

		reloadTable(tableProps) {
			this.getData(this.url, tableProps);
		},

		handleAction(data) {
			window.location.href = `http://localhost:8000/users/instructors/${data.id}`;
		},

		hideModal() {
			this.showModal = false
		},

		addNewInstructor() {
			window.location.href = "http://localhost:8000/users/instructors/create";
		}
	}
}
</script>