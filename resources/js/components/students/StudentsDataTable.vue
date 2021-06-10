<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Students Table
			</h5>
			<div class="card-tools">
				<button type="button" class="btn btn-sm btn-primary" @click="addNewStudent">
					<i class="fas fa-user-plus mr-2"></i>
					Add new student
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
			url: "http://localhost:8000/api/students",
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
					columnName: 'students.id',
					orderable: true
				},
				{
					label: "LAST NAME",
					name: "last_name",
					columnName: 'students.last_name',
					orderable: true
				},
				{
					label: "FIRST NAME",
					name: "first_name",
					columnName: "students.first_name",
					orderable: true
				},
				{
					label: "COURSE",
					name: "courses.course_name",
					columnName: "courses.course_name",
					orderable: true
				},
				{
					label: "YEAR LEVEL",
					name: "year_level",
					columnName: "students.year_level",
					orderable: true
				},
				{
					label: "SEMESTER",
					name: "semester",
					columnName: "students.semester",
					orderable: true
				},
				{
					label: "CURRICULUM",
					name: "curriculums.school_year",
					columnName: "curriculums.school_year",
					orderable: true
				},
				{
					label: "ACTION",
					name: "view",
					orderable: false,
					classes: {
						"btn": true,
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
			window.location.href = `http://localhost:8000/students/${data.id}`;
		},

		hideModal() {
			this.showModal = false
		},

		addNewStudent() {
			window.location.href = "http://localhost:8000/students/create";
		}
	}
}
</script>