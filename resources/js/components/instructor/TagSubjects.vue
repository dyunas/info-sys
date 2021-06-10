<template>
	<div class="card">
		<form v-on:submit.prevent="submitForm" class="form-horizontal">
			<div class="card-header">
				<h5 class="card-title">
					Tag Subjects
				</h5>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-sm">
					<thead>
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
	props: {
		data: {
			type: Object,
			required: true
		}
	},

	data() {
		return {
			subjectLists: [],
			subjects: [{subject_id: ""}]
		}
	},

	validations: {
		subjects: {
			required,
			$each: {
				subject_id: { required }
			}
		}
	},

	mounted() {
		this.getListOfSubjects();
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
			
			if (this.data.subjects.length > 0) {
				const subjects = []
				this.data.subjects.forEach(el => {
					subjects.push({subject_id: el.id})
				});

				this.subjects = subjects
			}
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
			this.subjects = [{subject_id: ""}]

			this.$nextTick(() => {
				this.$v.$reset();
			});
		},

		submitForm() {
			this.$v.$touch()

			if (!this.$v.$invalid) {
				const id = this.data.id
				const subjects = this.subjects

				Swal.fire({
					title: "Tag subjects to instructor?",
					text:"",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/users/instructors/${id}/tag_subjects`, {
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