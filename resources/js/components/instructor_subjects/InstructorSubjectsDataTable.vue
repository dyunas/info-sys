<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Subjects
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
import DtViewBtn from '../inputs/DtViewBtn'
import NewSubjectModal from "../subject/NewSubjectModal";

Vue.use(DataTable);

export default {
	props: {
		authId: {
			type: Number,
			required: true
		}
	},

	components: {
		DtViewBtn,
		NewSubjectModal
	},

	mixins: [CustomTableDesign],

	data() {
		return {
			url: `http://localhost:8000/api/instructor/subjects/${this.authId}`,
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
					label: "SUBJECT NAME",
					name: "name",
					orderable: true
				},
				{
					label: "CODE",
					name: "code",
					orderable: true
				},
				{
					label: "UNITS",
					name: "units",
					orderable: true
				},
				{
					label: "PRE-REQUISITE",
					name: "pre_req",
					orderable: true
				},
				{
					label: "YEAR LEVELS",
					name: "year_level",
					orderable: true
				},
				{
					label: "SEMESTER",
					name: "semester",
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
					console.log(response.data)
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
			const id = data.id;

			window.location.href = `http://localhost:8000/instructor/subjects/${id}`;
		},

		hideModal() {
			this.showModal = false
		},

		addNewSubject() {
			this.reloadTable()
		}
	}
}
</script>