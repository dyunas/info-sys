<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				New Student
			</h5>
		</div>

		<form v-on:submit.prevent="submitForm" class="form-horizontal" id="newCourseForm">
		<div class="card-body">
			<fieldset>
				<legend class="h6 text-uppercase font-weight-bold">Student Information:</legend>

				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="comp_name">
								COMPLETE NAME
							</label>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
									<input
										type="text"
										class="form-control"
										:class="{ 'is-invalid' : $v.form.lastName.$error }"
										placeholder="LAST NAME"
										v-model.trim="$v.form.lastName.$model"
									/>
									<span class="invalid-feedback" v-if="!$v.form.lastName.required" role="alert">
										<strong>This field is required</strong>
									</span>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
									<input
										type="text"
										class="form-control"
										:class="{ 'is-invalid' : $v.form.firstName.$error }"
										placeholder="GIVEN NAME"
										v-model.trim="$v.form.firstName.$model"
									/>
									<span class="invalid-feedback" v-if="!$v.form.firstName.required" role="alert">
										<strong>This field is required</strong>
									</span>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
									<input
										type="text"
										class="form-control"
										placeholder="MIDDLE NAME"
										v-model.trim="form.middleName"
									/>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="gender">
								GENDER
							</label>
							<v-select
								id="gender"
								:options="['MALE', 'FEMALE']"
								v-model="$v.form.gender.$model"
								:class="{ 'is-invalid' : $v.form.gender.$error }"
								placeholder="SELECT GENDER"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.gender.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="bdate">
								BIRTHDATE
							</label>
							<input
								id="bdate"
								type="date"
								class="form-control"
								:class="{ 'is-invalid' : $v.form.bdate.$error }"
								placeholder="YYYY/MM/DD"
								v-model.trim="$v.form.bdate.$model"
							/>
							<span class="invalid-feedback" v-if="!$v.form.bdate.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="age">
								AGE
							</label>
							<input
								id="age"
								type="text"
								class="form-control"
								v-model.trim="form.age"
								:disabled="true"
							/>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="email">EMAIL ADDRESS</label>
							<input
								id="email"
								type="text"
								class="form-control"
								:class="{ 'is-invalid' : $v.form.email.$error }"
								placeholder="E-MAIL ADDRESS"
								v-model.trim="$v.form.email.$model"
							/>
							<span class="invalid-feedback" v-if="!$v.form.email.required" role="alert">
								<strong>This field is required</strong>
							</span>
							<span class="invalid-feedback" v-if="!$v.form.email.email" role="alert">
								<strong>Should be a valid e-mail address</strong>
							</span>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label for="contactNumber">CONTACT NUMBER</label>
							<input
								id="contactNumber"
								type="text"
								class="form-control"
								:class="{ 'is-invalid' : $v.form.contactNumber.$error }"
								name="contact_num"
								v-model.trim="$v.form.contactNumber.$model"
								placeholder="09XXXXXXXXX"
							/>
							<span class="invalid-feedback" v-if="!$v.form.contactNumber.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="address">ADDRESS</label>
							<input
								type="text"
								class="form-control"
								:class="{ 'is-invalid' : $v.form.address.$error }"
								placeholder="HOUSE NO., STREED NAME"
								v-model.trim="$v.form.address.$model"
							/>
							<span class="invalid-feedback" v-if="!$v.form.address.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="province">PROVINCE</label>
							<v-select
								id="province"
								label="value"
								:options="provinces"
								v-model="$v.form.province.$model"
								:class="{ 'is-invalid' : $v.form.province.$error }"
								placeholder="SELECT PROVINCE"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.province.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="municipality">CITY/MUNICIPALITY</label>
							<v-select
								id="municipality"
								label="municipal"
								:options="municipals"
								:reduce="municipal => municipal.municipal"
								v-model="$v.form.municipal.$model"
								:class="{ 'is-invalid' : $v.form.municipal.$error }"
								placeholder="SELECT CITY/MUNICIPALITY"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.municipal.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="barangay">BARANGAY</label>
							<v-select
								id="barangay"
								label="value"
								:options="barangays"
								v-model="$v.form.barangay.$model"
								:class="{ 'is-invalid' : $v.form.barangay.$error }"
								placeholder="SELECT BARANGAY"
							></v-select>
							<span class="invalid-feedback" v-if="!$v.form.barangay.required" role="alert">
								<strong>This field is required</strong>
							</span>
						</div>
					</div>
				</div>
			</fieldset>

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
					<div class="col-lg-4">
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

					<div class="col-lg-4">
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

					<div class="col-lg-4">
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
				</div>
			</fieldset>

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
				<i class="fas fa-user-plus"></i>
				Add student
			</button>

			<button type="reset" class="btn btn-danger btn-sm" v-on:click="resetForm">
				<i class="fas fa-undo"></i>
				Clear
			</button>
		</div>
		</form>
	</div>
</template>

<script>
import { required, email } from "vuelidate/lib/validators";
import Swal from "sweetalert2";
import PhpJson from '../../../../public/json/ph_demographics.json'

export default {
	data() {
		return {
			dataMap: PhpJson,
			provinces: [],
			municipals: [],
			barangays: [],
			courses: [],
			yearLevels: [],
			curriculums: [],
			subjects: [],
			instructors: [],
			semesters: ['First Semester', 'Second Semester'],
			form: {
				firstName: "",
				middleName: "",
				lastName: "",
				gender: "",
				bdate: "",
				contactNumber: "",
				email: "",
				address: "",
				province: "",
				municipal: "",
				barangay: "",
				yearLevel: "",
				semester: "",
				course: "",
				curriculum: "",
				subjects: [{
					subject_id: "",
					instructor_id: "",
				}],
			}
		};
	},

	validations: {
		form: {
			firstName: {
				required
			},
			lastName: {
				required
			},
			gender: {
				required
			},
			bdate: {
				required
			},
			contactNumber: {
				required
			},
			email: {
				required,
				email
			},
			address: {
				required
			},
			province: {
				required
			},
			municipal: {
				required
			},
			barangay: {
				required
			},
			yearLevel: {
				required
			},
			course: {
				required
			},
			curriculum: {
				required
			},
			semester: {
				required
			},
			subjects: {
				required,
				$each: {
					subject_id: {required},
					instructor_id: {required},
				},
			}
		}
	},

	watch: {
		"form.province": function(value) {
			if (value !== '') {
				this.mapMunicapalsByProvince(value)
			}
		},

		"form.municipal": function(value) {
			if (value !== '') {
				this.mapBarangaysByMunicipal(value)
			}
		},

		"form.course": function(value) {
			if (value !== '') {
				this.form.curriculum = ""
				this.form.yearLevel = ""
				this.getYearLevelsOfCourse(value)
				this.getCurriculumsOfCourse(value)
			}
		},

		"form.semester": function(value) {
			if(value !== '') {
				if (this.form.course !== '' && this.form.yearLevel !== '' && this.form.curriculum) {
					this.getListOfSubjects(this.form.course, this.form.yearLevel, this.form.semester, this.form.curriculum)
				}
			}
		}
	},

	mounted() {
		this.mapProvince();
		this.getListOfCourses();
	},

	methods: {
		mapProvince() {
			this.dataMap.demographics.forEach(province => this.provinces.push(province.province))
		},

		mapMunicapalsByProvince(province = value) {
			this.municipals = []
			this.barangays = []
			this.municpal = ''
			this.barangay = ''

			const municipals = this.dataMap.demographics.find(el => {
				return (el.province === province)
			})

			municipals.municipals.forEach(
				municipal => this.municipals.push(
					{municipal: municipal.municipal, barangay: municipal.barangay_list}
				)
			)
		},

		mapBarangaysByMunicipal(municipal = value) {
			this.barangays = []
			this.barangay = ''

			const barangays = this.municipals.find(brgy => {
				return (brgy.municipal === municipal)
			})

			this.barangays = barangays.barangay
		},

		getListOfCourses() {
			axios.get(`http://localhost:8000/api/courses`)
			.then(response => {
				this.courses = response.data
			})
		},

		getYearLevelsOfCourse(id = value) {
			axios.get(`http://localhost:8000/api/courses/get_year_levels?id=${id}`)
			.then(response => {
				const levels = [];

				for(let i=1;i <= response.data[0].year_levels;i++) {
					levels.push(i);
				}

				this.yearLevels = levels
			})
		},

		getCurriculumsOfCourse(id = value) {
			axios.get(`http://localhost:8000/api/curriculums/get_curriculums_by_course?id=${id}`)
			.then(response => {
				this.curriculums = response.data
			})
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

		resetForm() {
			this.form = {
				firstName: "",
				middleName: "",
				lastName: "",
				gender: "",
				bdate: "",
				contactNumber: "",
				email: "",
				address: "",
				province: "",
				municipal: "",
				barangay: "",
				yearLevel: "",
				semester: "",
				course: "",
				curriculum: "",
				subjects: [{
					subject_id: "",
					instructor_id: "",
				}],
			}

			this.$nextTick(() => {
				this.$v.$reset();
			});
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const firstName = this.form.firstName 
				const middleName = this.form.middleName 
				const lastName = this.form.lastName 
				const gender = this.form.gender 
				const bdate = this.form.bdate
				const contactNumber = this.form.contactNumber
				const email = this.form.email
				const address = this.form.address 
				const province = this.form.province 
				const municipal = this.form.municipal 
				const barangay = this.form.barangay 
				const yearLevel = this.form.yearLevel 
				const semester = this.form.semester 
				const course = this.form.course 
				const curriculum = this.form.curriculum 
				const subjects = this.form.subjects 

				Swal.fire({
					title: "Add curriculum?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post("http://localhost:8000/api/students", {
							firstName: firstName,
							middleName: middleName,
							lastName: lastName,
							gender: gender,
							bdate: bdate,
							contactNumber: contactNumber,
							email: email,
							address: address,
							province: province,
							municipal: municipal,
							barangay: barangay,
							yearLevel: yearLevel,
							semester: semester,
							course: course,
							curriculum: curriculum,
							subjects: subjects,
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

						this.resetForm()
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