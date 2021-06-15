<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Courses Table
			</h5>
			<div class="card-tools">
				<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newCourse" @click="showModal = true">
					<i class="far fa-plus-square mr-2"></i>
					Add new course
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

		<new-course-modal v-if="showModal" @hideModal="hideModal" @addNewCourse="addNewCourse"/>
	</div>
</template>

<script>
import DataTable from "laravel-vue-datatable";
import CustomTableDesign from "../mixins/CustomTableStyle.js";
import DtEditBtn from '../inputs/DtEditBtn'
import NewCourseModal from "../course/NewCourseModal";

Vue.use(DataTable);

export default {
	components: {
		DtEditBtn,
		NewCourseModal
	},

	mixins: [CustomTableDesign],

	data() {
		return {
			url: "http://localhost:8000/api/courses",
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
					label: "COURSE NAME",
					name: "course_name",
					orderable: true
				},
				{
					label: "CODE",
					name: "code",
					orderable: true
				},
				{
					label: "YEAR LEVELS",
					name: "year_levels",
					orderable: true
				},
				{
					label: "ACTION",
					name: "Edit",
					orderable: false,
					classes: {
						btn: true,
						"btn-primary": true,
						"btn-sm": true
					},
					event: "click",
					handler: this.handleAction,
					component: DtEditBtn
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

		addNewCourse() {
			this.reloadTable()
		}
	}
}
</script>