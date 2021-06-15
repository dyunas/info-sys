<template>
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">
				Edit Student Information
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
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary btn-sm">
				<i class="fas fa-pencil-alt"></i>
				Update
			</button>

			<button class="btn btn-danger btn-sm" v-on:click="resetForm">
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
	props:{
		student: {
			type: Object,
			required: true
		}
	},

	data () {
		return {
			dataMap: PhpJson,
			provinces: [],
			municipals: [],
			barangays: [],
			form: {
				firstName: this.student.first_name,
				middleName: this.student.middle_name,
				lastName: this.student.last_name,
				gender: this.student.gender,
				bdate: this.student.bdate,
				contactNumber: this.student.contact_number,
				email: this.student.email,
				address: this.student.address,
				province: this.student.province,
				municipal: this.student.municipal,
				barangay: this.student.barangay,
			}
		}
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
	},

	mounted() {
		this.mapProvince();
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

		resetForm() {
			this.form = {
				firstName: this.student.first_name,
				middleName: this.student.middle_name,
				lastName: this.student.last_name,
				gender: this.student.gender,
				bdate: this.student.bdate,
				contactNumber: this.student.contact_number,
				email: this.student.email,
				address: this.student.address,
				province: this.student.province,
				municipal: this.student.municipal,
				barangay: this.student.barangay,
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
				const id = this.student.id

				Swal.fire({
					title: "Add curriculum?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/students/${id}`, {
							data: {
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
					allowOutsideClick: () => !Swal.isLoading()
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