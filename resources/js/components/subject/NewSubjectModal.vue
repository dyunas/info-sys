<template>
	<div class="modal fade" id="newCourse">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">New Subject</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="hideModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form v-on:submit.prevent="submitForm" class="form-horizontal" id="newCourseForm">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group row">
								<label for="subjectName" class="col-sm-2 col-form-label">Subject Name:</label>
								<div class="col-lg-10">
									<input
										type="text"
										class="form-control"
										id="subjectName"
										:class="{'is-invalid': $v.subjectName.$error}"
										v-model.lazy="$v.subjectName.$model"
										placeholder="Course Name"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.subjectName.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="subjectCode" class="col-sm-2 col-form-label">Course Code:</label>
								<div class="col-lg-10">
									<input
										type="text"
										class="form-control"
										id="subjectCode"
										:class="{'is-invalid': $v.subjectCode.$error}"
										v-model.lazy="$v.subjectCode.$model"
										placeholder="Course Code"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.subjectCode.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="units" class="col-sm-2 col-form-label">Units:</label>
								<div class="col-lg-10">
									<input
										type="text"
										class="form-control"
										id="units"
										:class="{'is-invalid': $v.units.$error}"
										v-model.lazy="$v.units.$model"
										placeholder="Units"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.units.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="preRequisite" class="col-sm-2 col-form-label">Pre-Requisite:</label>
								<div class="col-lg-10">
									<select
										type="text"
										class="form-control"
										id="preRequisite"
										v-model.lazy="preRequisite"
									>
										<option disabled value="">Choose pre-requisite</option>
										<template v-for="(row, index) in preReqOptions">
											<option :key="index" :value="row.code">{{row.code}} - {{row.name}}</option>
										</template>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label for="yearLevel" class="col-sm-2 col-form-label">Year Level:</label>
								<div class="col-lg-10">
									<input
										type="number"
										class="form-control"
										id="yearLevel"
										:class="{'is-invalid': $v.yearLevel.$error}"
										v-model.lazy="$v.yearLevel.$model"
										placeholder="Year Levels"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.yearLevel.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="semester" class="col-sm-2 col-form-label">Semester:</label>
								<div class="col-lg-10">
									<select
										type="text"
										class="form-control"
										:option="['First Semester', 'Second Semester']"
										id="semester"
										:class="{'is-invalid': $v.semester.$error}"
										v-model.lazy="$v.semester.$model"
									>
										<option disabled value="">Please select semester</option>
										<option>First Semester</option>
										<option>Second Semester</option>
									</select>
									<span
										class="invalid-feedback"
										v-if="!$v.semester.required"
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
					<button type="submit" class="btn btn-primary" id="saveSubject">Save subject</button>
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
			subjectName: "",
			subjectCode: "",
			units: "",
			preRequisite: "",
			yearLevel: "",
			semester: "",
			preReqOptions: [],
		}
	},

	validations: {
		subjectName: {
			required
		},
		subjectCode: {
			required
		},
		units: {
			required
		},
		yearLevel: {
			required
		},
		semester: {
			required
		}
	},

	mounted() {
		this.getSubjects()
	},

	methods: {
		hideModal() {
			this.$nextTick(() => {
				this.$v.$reset();
			});
			this.$emit("hideModal");
		},

		getSubjects() {
			axios.get('http://localhost:8000/api/subjects')
			.then(response => {
				response.data.forEach(el => {
					this.preReqOptions.push({'code': el.code, 'name': el.name });
				});
			})
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const subjectName  = this.subjectName;
				const subjectCode  = this.subjectCode;
				const units 			 = this.units;
				const preRequisite = this.preRequisite;
				const yearLevel 	 = this.yearLevel;
				const semester 		 = this.semester;

				Swal.fire({
					title: "Add new subject?",
					text: "",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/subjects`,
							{
								subjectName: subjectName,
								subjectCode: subjectCode,
								units: units,
								preRequisite: preRequisite,
								yearLevel: yearLevel,
								semester: semester
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

						this.$emit("addNewSubject");

						this.subjectName = "";
						this.subjectCode = "";
						this.units = "";
						this.preRequisite = "";
						this.yearLevel = "";
						this.semester = "";

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