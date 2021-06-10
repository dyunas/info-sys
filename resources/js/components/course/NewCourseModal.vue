<template>
	<div class="modal fade" id="newCourse">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">New Course</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="hideModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form v-on:submit.prevent="submitForm" class="form-horizontal" id="newCourseForm">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group row">
								<label for="courseName" class="col-sm-2 col-form-label">Course Name:</label>
								<div class="col-lg-10">
									<input
										type="text"
										class="form-control"
										id="courseName"
										:class="{'is-invalid': $v.courseName.$error}"
										v-model.lazy="$v.courseName.$model"
										placeholder="Course Name"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.courseName.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="courseCode" class="col-sm-2 col-form-label">Course Code:</label>
								<div class="col-lg-10">
									<input
										type="text"
										class="form-control"
										id="courseCode"
										:class="{'is-invalid': $v.courseCode.$error}"
										v-model.lazy="$v.courseCode.$model"
										placeholder="Course Code"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.courseCode.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="yearLevels" class="col-sm-2 col-form-label">Year Levels:</label>
								<div class="col-lg-10">
									<input
										type="number"
										class="form-control"
										id="yearLevels"
										:class="{'is-invalid': $v.yearLevels.$error}"
										v-model.lazy="$v.yearLevels.$model"
										placeholder="Year Levels"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.yearLevels.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal" @click="hideModal">Close</button>
					<button type="submit" class="btn btn-primary" id="saveCourse">Save changes</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</template>

<script>
import { required } from "vuelidate/lib/validators";
import Swal from "sweetalert2";

export default {
	data() {
		return {
			courseName: "",
			courseCode: "",
			yearLevels: "",
		}
	},

	validations: {
		courseName: {
			required
		},
		courseCode: {
			required
		},
		yearLevels: {
			required
		}
	},

	methods: {
		hideModal() {
			this.$nextTick(() => {
				this.$v.$reset();
			});
			this.$emit("hideModal");
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const courseName = this.courseName;
				const courseCode = this.courseCode;
				const yearLevels = this.yearLevels;

				Swal.fire({
					title: "Add new course?",
					text: "",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/courses`,
							{
								courseName: courseName,
								courseCode: courseCode,
								yearLevels: yearLevels
							}
						)
						.then(response => {
							return response.data;
						})
						.catch(error => {
							Swal.fire({
								title: "Error!",
								text: `${error.response.data.message}`,
								icon: "error",
								confirmButtonText: "Done"
							});
						});
					},
					allowOutsideClick: () => !Swal.isLoading()
				}).then(result => {
					if (result.isConfirmed) {
						Swal.fire({
							title: result.value.title,
							text: result.value.message,
							icon: "success",
							confirmButtonText: "Done"
						});

						this.$emit("addNewCourse")

						this.courseName = "";
						this.courseCode = "";
						this.yearLevels = "";

						this.$nextTick(() => {
							this.$v.$reset();
						});
					}
				});
			}
		}
	}
}
</script>