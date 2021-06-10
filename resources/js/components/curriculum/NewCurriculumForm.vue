<template>
	<div class="card">
		<form v-on:submit.prevent="submitForm" class="form-horizontal">
			<div class="card-header">
				<h5 class="card-title">
					New Curriculum
				</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label for="course" class="col-sm-2 col-form-label">Course:</label>
					<div class="col-lg-10">
						<select
							class="form-control"
							id="course"
							:class="{'is-invalid': $v.course.$error}"
							v-model.lazy="$v.course.$model"
							placeholder="Course"
						>
							<option value="" disabled>Select course</option>
							<option v-for="(item, index) in courseOptions" :key="index" :value="item.id">
								{{ item.code }} - {{ item.name }}									
							</option>
						</select>
						<span
							class="invalid-feedback"
							v-if="!$v.course.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="academicYear" class="col-sm-2 col-form-label">Academic Year:</label>
					<div class="col-lg-10">
						<select
							class="form-control"
							id="academicYear"
							:class="{'is-invalid': $v.academicYear.$error}"
							v-model.lazy="$v.academicYear.$model"
							placeholder="Academic Year"
						>
							<option value="" disabled>Select academic year</option>
							<option v-for="(item, index) in acadYearOptions" :key="index">
								{{ item.from }} - {{ item.to }}									
							</option>
						</select>
						<span
							class="invalid-feedback"
							v-if="!$v.academicYear.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
					</div>
				</div>
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
	data() {
		return {
			course: "",
			academicYear: "",
			courseOptions: [],
			acadYearOptions: [],
		}
	},

	validations: {
		course: {
			required
		},
		academicYear: {
			required,
		},
	},

	mounted() {
		this.getListOfCourses()
		this.getListOfAcademicYear()
	},

	methods: {
		resetForm() {
			this.course = "",
			this.academicYear = "",

			this.$nextTick(() => {
				this.$v.$reset();
			});
		},

		getListOfCourses() {
			axios.get("http://localhost:8000/api/courses")
			.then(response => {
				console.log(response)
				response.data.forEach(el => {
					this.courseOptions.push({'id': el.id, 'code': el.code, 'name': el.course_name });
				});
			});
		},

		getListOfAcademicYear()
		{
			axios.get("http://localhost:8000/api/academic-year")
			.then(response => {
				console.log(response)
				response.data.data.forEach(el => {
					this.acadYearOptions.push({'from': el.from, 'to': el.to });
				});
			});
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const course = this.course
				const academicYear = this.academicYear

				Swal.fire({
					title: "Add curriculum?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post("http://localhost:8000/api/curriculums", {
							course: course,
							academicYear: academicYear,
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

						this.course.value = "",
						this.academicYear.value = "",

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