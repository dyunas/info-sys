<template>
	<div class="card">
		<form v-on:submit.prevent="submitForm" class="form-horizontal">
			<div class="card-header">
				<h5 class="card-title">
					New Instructor
				</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label for="username" class="col-sm-2 col-form-label">Username:</label>
					<div class="col-lg-10">
						<input
							type="text"
							class="form-control"
							id="username"
							:class="{'is-invalid': $v.username.$error}"
							v-model.lazy="$v.username.$model"
							placeholder="Username"
						/>
						<span
							class="invalid-feedback"
							v-if="!$v.username.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-sm-2 col-form-label">Password:</label>
					<div class="col-lg-10">
						<input
							type="password"
							class="form-control"
							id="password"
							:class="{'is-invalid': $v.password.$error}"
							v-model.trim="$v.password.$model"
							placeholder="Password"
						/>
						<span
							class="invalid-feedback"
							v-if="!$v.password.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
						<span
							class="invalid-feedback"
							v-if="!$v.password.minLength"
							role="alert"
						>
							<strong>Password must have at least {{ $v.password.$params.minLength.min }} characters.</strong>
						</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="confirmPassword" class="col-sm-2 col-form-label">Confirm password:</label>
					<div class="col-lg-10">
						<input
							type="password"
							class="form-control"
							id="confirmPassword"
							:class="{'is-invalid': $v.confirmPassword.$error}"
							v-model.trim="$v.confirmPassword.$model"
							placeholder="Confirm password"
						/>
						<span
							class="invalid-feedback"
							v-if="!$v.confirmPassword.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
						<span
							class="invalid-feedback"
							v-if="!$v.confirmPassword.sameAsPassword"
							role="alert"
						>
							<strong>Password and Confirm password does not match</strong>
						</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-sm-2 col-form-label">Email Address:</label>
					<div class="col-lg-10">
						<input
							type="text"
							class="form-control"
							id="email"
							:class="{'is-invalid': $v.email.$error}"
							v-model.lazy="$v.email.$model"
							placeholder="Email Address"
						/>
						<span
							class="invalid-feedback"
							v-if="!$v.email.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
						<span
							class="invalid-feedback"
							v-if="!$v.email.email"
							role="alert"
						>
							<strong>Must be a valid email address</strong>
						</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="firstName" class="col-sm-2 col-form-label">Firstname:</label>
					<div class="col-lg-10">
						<input
							type="text"
							class="form-control"
							id="firstName"
							:class="{'is-invalid': $v.firstName.$error}"
							v-model.lazy="$v.firstName.$model"
							placeholder="Firstname"
						/>
						<span
							class="invalid-feedback"
							v-if="!$v.firstName.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="middleName" class="col-sm-2 col-form-label">Middlename:</label>
					<div class="col-lg-10">
						<input
							type="text"
							class="form-control"
							id="middleName"
							v-model="middleName"
							placeholder="Middlename"
						/>
					</div>
				</div>

				<div class="form-group row">
					<label for="lastName" class="col-sm-2 col-form-label">Lastname:</label>
					<div class="col-lg-10">
						<input
							type="text"
							class="form-control"
							id="lastName"
							:class="{'is-invalid': $v.lastName.$error}"
							v-model.lazy="$v.lastName.$model"
							placeholder="Lastname"
						/>
						<span
							class="invalid-feedback"
							v-if="!$v.lastName.required"
							role="alert"
						>
							<strong>This field is required</strong>
						</span>
					</div>
				</div>

				<div class="row mt-5">
					<div class="col-lg-12">
						<table class="table table-bordered table-sm">
							<thead>
								<tr>
									<th class="align-middle" colspan="2">Tag Subjects</th>
								</tr>
								<tr>
									<th>Subject Name:</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(v, index) in $v.subjects.$each.$iter" :key="index">
									<td width="95%">
										<v-select
											label="name"
											:options="subjectLists"
											:reduce="subjectList => subjectList.id"
											:class="{ 'is-invalid' : v.subject_id.$error }"
											v-model="v.subject_id.$model"
											placeholder="SELECT SUBJECT"
										/>
										<span class="invalid-feedback" v-if="!v.subject_id.required" role="alert">
											<strong>This field is required</strong>
										</span>
									</td>
									<td width="5%" class="text-center align-middle">
										<button type="button" class="btn btn-danger btn-sm" v-on:click="deleteRow(index, v)">
											<i class="far fa-trash-alt"></i>
										</button>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">
										<button type="button" class="btn btn-primary btn-sm" v-on:click="addRow()">
											<i class="far fa-plus-square mr-1"></i>
											Add Row
										</button>
									</td>
								</tr>
							</tfoot>
						</table>
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
import { required, sameAs, minLength, email } from "vuelidate/lib/validators";
import Swal from "sweetalert2";

export default {
	data() {
		return {
			username: "",
			password: "",
			confirmPassword: "",
			email: "",
			role: "Instructor",
			firstName: "",
			middleName: "",
			lastName: "",
			subjectLists: [],
			subjects: [{
				subject_id: ""
			}]
		}
	},

	validations: {
		username: {
			required
		},
		password: {
			required,
			minLength: minLength(4)
		},
		confirmPassword: {
			required,
			sameAsPassword: sameAs('password')
		},
		email: {
			required,
			email
		},
		firstName: {
			required
		},
		lastName: {
			required
		},
		subjects: {
			required,
			$each: {
				subject_id: { required }
			}
		}
	},

	mounted() {
		this.getListOfSubjects()
	},

	methods: {
		async getListOfSubjects() {
			const subjects = await new Promise(resolve => {
				axios.get(`http://localhost:8000/api/subjects`)
				.then(response => {
					resolve(response.data)
				})
			})

			this.subjectLists = subjects
		},

		addRow() {
			this.subjects.push({subject_id: ""});
		},

		deleteRow(index, v) {
			if(this.subjects.length > 1) {
				this.subjects.splice(index, 1)
			}
		},

		resetForm() {
			this.username = ""
			this.password = ""
			this.confirmPassword = ""
			this.email = ""
			this.firstName = ""
			this.middleName = ""
			this.lastName = ""
			this.subjects = [{subject_id: ""}]

			this.$nextTick(() => {
				this.$v.$reset();
			});
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const username = this.username
				const password = this.password
				const email    = this.email
				const firstName  = this.firstName
				const middleName = this.middleName
				const lastName   = this.lastName
				const subjects   = this.subjects

				Swal.fire({
					title: "Add instructor?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post("http://localhost:8000/api/users/instructors", {
							username: username,
							password: password,
							email: email,
							firstName: firstName,
							middleName: middleName,
							lastName: lastName,
							subjects: subjects
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

						this.username = "",
						this.password = "",
						this.confirmPassword = "",
						this.email = "",
						this.firstName = "",
						this.middleName = "",
						this.lastName = "",

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