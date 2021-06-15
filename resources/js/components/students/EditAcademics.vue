<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Edit Academics
			</h5>
		</div>

		<form v-on:submit.prevent="submitForm" class="form-horizontal" id="newCourseForm">
		<div class="card-body">
			<fieldset class="mt-4">
				<legend class="h6 text-uppercase font-weight-bold">Academic Information:</legend>

				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="course">COURSE</label>
							<v-select
								id="course"
								label="course_name"
								:options="courses"
								:reduce="course => course.id"
								v-model="$v.form.course.$model"
								:class="{ 'is-invalid' : $v.form.course.$error }"
								placeholder="SELECT COURSE"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.course.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-3">
						<div class="form-group">
							<label for="yearLevel">YEAR LEVEL</label>
							<v-select
								id="yearLevel"
								:options="yearLevels"
								v-model="$v.form.yearLevel.$model"
								:class="{ 'is-invalid' : $v.form.yearLevel.$error }"
								placeholder="SELECT YEAR LEVEL"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.yearLevel.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="form-group">
							<label for="curriculum">CURRICULUM</label>
							<v-select
								id="curriculum"
								label="school_year"
								:options="curriculums"
								:reduce="curriculum => curriculum.id"
								v-model="$v.form.curriculum.$model"
								:class="{ 'is-invalid' : $v.form.curriculum.$error }"
								placeholder="SELECT CURRICULUM"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.curriculum.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="form-group">
							<label for="semester">SEMESTER</label>
							<v-select
								id="semester"
								:options="semesters"
								v-model="$v.form.semester.$model"
								:class="{ 'is-invalid' : $v.form.semester.$error }"
								placeholder="SELECT SEMESTER"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.semester.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="form-group">
							<label for="acadYear">ACADEMIC YEAR</label>
							<v-select
								id="acadYear"
								:options="academicYears"
								v-model="$v.form.acadYear.$model"
								:class="{ 'is-invalid' : $v.form.acadYear.$error }"
								placeholder="SELECT ACADEMIC YEAR"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.acadYear.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		
		<div class="card-footer">
			<button type="submit" class="btn btn-primary btn-sm">
				<i class="fas fa-pencil-alt"></i>
				Update
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
			courses: [],
			yearLevels: [],
			curriculums: [],
			semesters: ['First Semester', 'Second Semester'],
			academicYears: [],
			form: {
				yearLevel: this.yearLevel,
				semester: this.semester,
				course: this.course.id,
				curriculum: this.curriculum.id,
				acadYear: this.acadYear,
			}
		}
	},

	validations: {
		form: {
			yearLevel: {
				required
			},
			semester: {
				required
			},
			course: {
				required
			},
			curriculum: {
				required
			},
			acadYear: {
				required
			},
		}
	},

	watch: {
		"form.course": function(newValue, oldValue) {
			this.getYearLevelsOfCourse(oldValue, newValue)
			this.getCurriculumsOfCourse(oldValue, newValue)
		},
	},

	mounted() {
		this.getData();
		this.getAcademicYears();
	},

	methods: {
		resetForm() {
			this.form = {
				yearLevel: this.yearLevel,
				semester: this.semester,
				course: this.course.id,
				curriculum: this.curriculum.id,
				acadYear: this.acadYear
			}

			this.$nextTick(() => {
				this.$v.$reset();
			});
		},

		async getData() {
			await this.getListOfCourses();
			await this.getYearLevelsOfCourse('',this.course.id);
			await this.getCurriculumsOfCourse('',this.course.id);
		},

		getAcademicYears() {
			axios.get(`http://localhost:8000/api/academic-year`)
			.then(response => {
				const list = [];
				response.data.forEach(el => {
					list.push(`${el.from} - ${el.to}`);
				})

				this.academicYears = list
			})
		},

		getListOfCourses() {
			axios.get(`http://localhost:8000/api/courses`)
			.then(response => {
				this.courses = response.data
			})
		},

		getYearLevelsOfCourse(oldVal, newVal) {
			this.yearLevels = [];

			if (oldVal !== "") {
				this.form.yearLevel = ""
			}

			axios.get(`http://localhost:8000/api/courses/get_year_levels?id=${newVal}`)
			.then(response => {
				const levels = [];

				for(let i=1;i <= response.data[0].year_levels;i++) {
					levels.push(i);
				}

				this.yearLevels = levels
			})
		},

		getCurriculumsOfCourse(oldVal, newVal) {
			this.curriculums = []

			if (oldVal !== "") {
				this.form.curriculum = ""
			}

			axios.get(`http://localhost:8000/api/curriculums/get_curriculums_by_course?id=${newVal}`)
			.then(response => {
				this.curriculums = response.data
			})
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const studId = this.studId
				const yearLevel = this.form.yearLevel 
				const semester = this.form.semester 
				const course = this.form.course 
				const curriculum = this.form.curriculum
				const acadYear = this.form.acadYear

				Swal.fire({
					title: "Update academics?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/students/${studId}/update_academics`, {
							data: {
								yearLevel: yearLevel,
								semester: semester,
								course: course,
								curriculum: curriculum,
								acadYear: acadYear,
							},
							_method: "PATCH"
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