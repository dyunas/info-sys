<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Curriculums Table
			</h5>
			<div class="card-tools">
				<button type="button" class="btn btn-sm btn-primary" @click="addNewCurriculum">
					<i class="far fa-plus-square mr-2"></i>
					Add new curriculum
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
			url: "http://localhost:8000/api/curriculums",
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
					columnName: "curriculums.id",
					orderable: true
				},
				{
					label: "COURSE NAME",
					name: "course.course_name",
					columnName: "course.course_name",
					orderable: true
				},
				{
					label: "SCHOOL YEAR",
					name: "school_year",
					columnName: "curriculums.school_year",
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
			const id = data.id;

			window.location.href = `http://localhost:8000/curriculums/${id}`
		},

		hideModal() {
			this.showModal = false
		},

		addNewCurriculum() {
			window.location.href = 'http://localhost:8000/curriculums/create';
		}
	}
}
</script>