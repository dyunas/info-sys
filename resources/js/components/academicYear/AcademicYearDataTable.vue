<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Academic Year Table
			</h5>
			<div class="card-tools">
				<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newAcadYear" @click="showModal = true">
					<i class="far fa-plus-square mr-2"></i>
					Add new academic year
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
			/>
		</div>

		<new-academic-year-modal v-if="showModal" @hideModal="hideModal" @addNewAcadYear="addNewAcadYear"/>
	</div>
</template>

<script>
import DataTable from "laravel-vue-datatable";
import CustomTableDesign from "../mixins/CustomTableStyle.js";
import NewAcademicYearModal from "../academicYear/NewAcademicYearModal";

Vue.use(DataTable);

export default {
	components: {
		NewAcademicYearModal
	},

	mixins: [CustomTableDesign],

	data() {
		return {
			url: "http://localhost:8000/api/academic-year",
			actionUrl: "http://localhost:8000/api",
			showModal: false,
			data: {},
			isLoading: false,
			tableProps: {
				search: "",
				length: 10,
				column: "id",
				dir: "desc"
			},
			debounceDelay: 500,
			columns: [
				{
					label: "ID",
					name: "id",
					orderable: true
				},
				{
					label: "FROM",
					name: "from",
					orderable: true
				},
				{
					label: "TO",
					name: "to",
					orderable: true
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
			const id = data.id;

			alert(id);
		},

		hideModal() {
			this.showModal = false
		},

		addNewAcadYear() {
			this.reloadTable()
		}
	}
}
</script>