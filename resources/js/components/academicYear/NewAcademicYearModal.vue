<template>
	<div class="modal fade" id="newAcadYear">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">New Academic Year</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="hideModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form v-on:submit.prevent="submitForm" class="form-horizontal" id="newAcadYearForm">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group row">
								<label for="from" class="col-sm-2 col-form-label">From:</label>
								<div class="col-lg-10">
									<input
										type="text"
										class="form-control"
										id="from"
										:class="{'is-invalid': $v.from.$error}"
										v-model.lazy="$v.from.$model"
										placeholder="FROM"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.from.required"
										role="alert"
									>
										<strong>This field is required</strong>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="to" class="col-sm-2 col-form-label">To:</label>
								<div class="col-lg-10">
									<input
										type="text"
										class="form-control"
										id="to"
										:class="{'is-invalid': $v.to.$error}"
										v-model.lazy="$v.to.$model"
										placeholder="TO"
									/>
									<span
										class="invalid-feedback"
										v-if="!$v.to.required"
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
					<button type="submit" class="btn btn-primary" id="saveSubject">Save</button>
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
			from: "",
			to: "",
		}
	},

	validations: {
		from: {
			required
		},
		to: {
			required
		},
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
				const from  = this.from;
				const to    = this.to;

				Swal.fire({
					title: "Add academic year?",
					text: "",
					showCancelButton: true,
					confirmButtonText: `Confirm`,
					showLoaderOnConfirm: true,
					preConfirm: function(result) {
						return axios.post(`http://localhost:8000/api/academic-year`,
							{
								from: from,
								to: to,
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

						this.$emit("addNewAcadYear");

						this.from = "";
						this.to = "";

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