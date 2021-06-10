<template>
	<div class="card">
		<form v-on:submit.prevent="submitForm" class="form-horizontal">
			<div class="card-header">
				<h5 class="card-title">
					Adding subjects to: {{ curriculum.course.course_name }}
				</h5>
				<div class="card-tools">
					<button type="button" class="btn btn-sm btn-primary" @click.prevent="addRow">
						<span class="fas fa-plus"></span>
						Add row
					</button>
				</div>
			</div>
			<div class="card-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="20%">YEAR LEVEL</th>
							<th width="30%">SEMESTER</th>
							<th width="45%">SUBJECTS</th>
							<th width="5%"></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(v, index) in $v.subjects.$each.$iter" :key="index">
							<td>
								<v-select
									:options="yearLevels"
									:class="{'is-invalid': v.year_level.$error}"
									v-model.lazy="v.year_level.$model"
									v-on:input="getListOfSubjects(v.year_level.$model, v.semester.$model, index)"
									placeholder="Select year level"
								/>
								<span class="invalid-feedback" v-if="!v.year_level.required" role="alert">
									<strong>This field is required</strong>
								</span>
							</td>
							<td>
								<v-select
									:options="semesters"
									:class="{'is-invalid': v.semester.$error}"
									v-model.lazy="v.semester.$model"
									v-on:input="getListOfSubjects(v.year_level.$model, v.semester.$model, index)"
									placeholder="Select semester"
								/>
								<span class="invalid-feedback" v-if="!v.semester.required" role="alert">
									<strong>This field is required</strong>
								</span>
							</td>
							<td>
								<v-select
									label="name"
									:options="subjectList[index]"
									:class="{'is-invalid': v.subject.$error}"
									v-model.lazy="v.subject.$model"
									placeholder="Select subject"
								/>
								<span class="invalid-feedback" v-if="!v.subject.required" role="alert">
									<strong>This field is required</strong>
								</span>
							</td>
							<td>
								<a
									href="#"
									class="text-danger"
									style="font-size: 1.3em"
									@click.prevent="deleteRow(index)"
								>
									<span class="fas fa-times"></span>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary btn-sm">
					<i class="far fa-paper-plane"></i>
					Submit
				</button>
				<button type="reset" class="btn btn-primary btn-sm" @click="resetForm">
					<i class="fas fa-undo-alt"></i>
					Reset
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
		curriculum: {
			type: Object,
			required: true
		}
	},

	data() {
		return {
			yearLevels: [],
			subjectList: [],
			semesters: ['First Semester', 'Second Semester'],
			subjects: [{subject: "", year_level: "", semester: ""}]
		}
	},

	validations: {
		subjects: {
			required,
			$each: {
				subject: { required },
				year_level: { required },
				semester: { required },
			}
		}
	},

	mounted() {
		for(let i = 1;i <= this.curriculum.course.year_levels;i++) {
			this.yearLevels.push(i);
		}
	},

	methods: {
		addRow() {
			this.subjects.push({subject: "", year_level: "", semester: "", subjects: []});
		},

		deleteRow(index) {
			if(this.subjects.length > 1) {
				this.subjects.splice(index, 1)
			}
		},

		getListOfSubjects(yearLevel, semester, index) {
			axios.get(`http://localhost:8000/api/subjects/get_available_subjects_by?year_level=${yearLevel}&semester=${semester}`)
			.then(response => {
				const subjects = [];

				response.data.forEach(el => {
					subjects.push({id: el.id, name: el.name, code: el.code});
				});

				this.subjectList.splice(index, 0, subjects)
			})
		},

		resetForm() {
			this.subjects = [{subject: "", year_level: "", semester: ""}]

			this.$nextTick(() => {
				this.$v.$reset();
			});
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const id = this.curriculum.id
				const subjects = this.subjects

				Swal.fire({
					title: "Add Subject?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/curriculums/${id}/add_subjects`, {
							id,
							subjects
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
					allowOutsideClick: () => !Swal.isLoading()
				}).then((result) => {
					if (result.isConfirmed) {
						Swal.fire({
							title: result.value.title,
							text: result.value.message,
							icon: "success",
							confirmButtonText: "Done"
						});

						//

						this.$nextTick(() => {
							this.$v.$reset();
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
	},
}
</script>