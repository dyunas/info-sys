<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Add Subjects
			</h5>
		</div>

		<form v-on:submit.prevent="submitForm" class="form-horizontal" id="newCourseForm">
		<div class="card-body">
			<fieldset class="mt-4">
				<legend class="h6 text-uppercase font-weight-bold">Subjects:</legend>

				<div class="row">
					<div class="col-lg-12">
						<table class="table table-sm table-bordered">
							<thead>
								<tr>
									<th width="55%">Subject Name</th>
									<th width="40%">Instructor</th>
									<th width="5%"></th>
								</tr>
							</thead>

							<tbody>
								<tr v-for="(v, index) in $v.form.subjects.$each.$iter" :key="index">
									<td>
										<v-select
											label="name"
											:options="subjects"
											:reduce="subject => subject.id"
											:class="{ 'is-invalid' : v.subject_id.$error }"
											v-model.lazy="v.subject_id.$model"
											v-on:input="getListOfInstructors(v.subject_id.$model, index)"
											placeholder="Choose subject"
										/>
										<span class="invalid-feedback" v-if="!v.subject_id.required" role="alert">
											<strong>This field is required</strong>
										</span>
									</td>
									<td>
										<v-select
											label="name"
											:options="instructors[index]"
											:class="{ 'is-invalid' : v.instructor_id.$error }"
											v-model.lazy="v.instructor_id.$model"
											placeholder="Choose instructor"
										/>
										<span class="invalid-feedback" v-if="!v.instructor_id.required" role="alert">
											<strong>This field is required</strong>
										</span>
									</td>
									<td>
										<button class="btn btn-sm btn-danger" v-on:click.prevent="deleteRow(index)">
											<i class="far fa-trash-alt"></i>
										</button>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">
										<button type="button" class="btn btn-sm btn-primary" v-on:click.prevent="addRow">
											<span class="fas fa-plus"></span>
											Add row
										</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</fieldset>
		</div>
		
		<div class="card-footer">
			<button type="submit" class="btn btn-primary btn-sm">
				<i class="far fa-plus-square"></i>
				Add
			</button>

			<button type="reset" class="btn btn-danger btn-sm" v-on:click="resetForm">
				<i class="fas fa-undo"></i>
				Undo
			</button>
		</div>
		</form>
	</div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import Swal from "sweetalert2";

export default {
	props: {
		studId: {
			type: Number,
			required: true
		},
		course: {
			type: Object,
			required: true
		},
		curriculum: {
			type: Object,
			required: true
		},
		semester: {
			type: String,
			required: true
		},
		yearLevel: {
			type: Number,
			required: true
		},
		acadYear: {
			type: String,
			required: true
		}
	},

	data () {
		return {
			subjects: [],
			instructors: [],
			form: {
				yearLevel: this.yearLevel,
				semester: this.semester,
				course: this.course.id,
				curriculum: this.curriculum.id,
				acadYear: this.acadYear,
				subjects: [{
					subject_id: "",
					instructor_id: "",
				}],
			}
		}
	},

	validations: {
		form: {
			subjects: {
				required,
				$each: {
					subject_id: {required},
					instructor_id: {required},
				},
			}
		}
	},

	mounted() {
		this.getData();
	},

	methods: {
		resetForm() {
			this.form = {
				subjects: [{
					subject_id: "",
					instructor_id: "",
				}],
			}

			this.$nextTick(() => {
				this.$v.$reset();
			});
		},

		async getData() {
			this.getListOfSubjects(this.form.course, this.form.yearLevel, this.form.semester, this.form.curriculum);
		},

		getListOfSubjects(course, yearLevel, semester, curriculum) {
			axios.get(`http://localhost:8000/api/subjects/get_list_of_subjects_by?course=${course}&yearLevel=${yearLevel}&semester=${semester}&curriculum=${curriculum}`)
			.then(response => {
				this.subjects = response.data
			})
		},

		getListOfInstructors(id, index) {
			axios.get(`http://localhost:8000/api/users/instructors/get_list_of_instructors_by?subject_id=${id}`)
			.then(response => {
				const instructors = [];

				response.data.forEach(el => {
					instructors.push({id: el.id, name: el.name})					
				});

				this.instructors.splice(index, 0, instructors);
			})
		},

		addRow() {
			this.form.subjects.push({subject_id: "", instructor_id: ""});
		},

		deleteRow(index) {
			if(this.form.subjects.length > 1) {
				this.form.subjects.splice(index, 1)
				this.instructors.splice(index, 1)
			}
		},

		
		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const studId = this.studId
				const subjects = this.form.subjects
				const semester = this.semester
				const yearlevel = this.yearLevel
				const acadYear = this.acadYear

				Swal.fire({
					title: "Add subjects?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/students/${studId}/add_subjects`, {
							subjects: subjects,
							semester: semester,
							yearlevel: yearlevel,
							acadYear: acadYear
						})
						.then(response => {
							return response.data;
						})
						.catch(() => {
							Swal.fire({
								title: "Error!",
								text: `${error.response.data.message}`,
								icon: "error",
								confirmButtonText: "Done"
							});
						});
					},
					allowOutsideClick: true//() => !Swal.isLoading()
				}).then((result) => {
					if (result.isConfirmed) {
						Swal.fire({
							title: result.value.title,
							text: result.value.message,
							icon: "success",
							confirmButtonText: "Done"
						});
					}
				});
			} else {
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000
				});

				Toast.fire({
					icon: 'info',
					title: 'You are missing some fields. Please fill up the entire form.'
				})
			}
		}
	}
}
</script>