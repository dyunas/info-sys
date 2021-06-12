<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				System Logs
			</h5>
		</div>

		<div class="card-body">
			<data-table
				:url="url"
				:classes="classes"
				:data="data"
				:columns="columns"
				@on-table-props-changed="reloadTable"
			/>
		</div>
	</div>
</template>

<script>
import DataTable from "laravel-vue-datatable";
import CustomTableDesign from "../mixins/CustomTableStyle.js";

export default {
	mixins: [CustomTableDesign],

	data () {
		return {
			url: `http://localhost:8000/api/system-logs`,
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
					orderable: true
				},
				{
					label: "LOG",
					name: "log",
					orderable: true
				},
				{
					label: "DATE",
					name: "log_date",
					orderable: true
				},
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
					console.log(response.data)
					this.data = response.data;
				})
				.catch(error => {
					console.log(error.response.data);
				});
		},

		reloadTable(tableProps) {
			this.getData(this.url, tableProps);
		}
	}
}
</script>