<template>
	<div class="card card-primary">
		<div class="card-header">
			<h5 class="card-title">
				{{subject.code}} - {{subject.name}} Student List
			</h5>
		</div>

		<div class="card-body p-0 table-responsive">
			<table class="table table-sm table-bordered table-hover text-nowrap">
				<thead>
					<tr>
						<th width="25%">Last Name</th>
						<th width="25%">First Name</th>
						<th width="25%">Middle Name</th>
						<th width="5%" class="text-center">Prelim</th>
						<th width="5%" class="text-center">Midterm</th>
						<th width="5%" class="text-center">Final</th>
						<th width="5%" class="text-center">GPA</th>
						<th width="5%" class="text-center">ACTION</th>
					</tr>
				</thead>

				<tbody>
					<tr v-for="(row, index) in list" :key="index">
						<td>{{row.students.last_name}}</td>
						<td>{{row.students.first_name}}</td>
						<td>{{row.students.middle_name}}</td>
						<td><input :disabled="(row.is_locked) ? true : false" v-model="row.prelim" v-on:input="computeGPA(row.prelim, row.midterm, row.final, index)" type="number" class="form-control"/></td>
						<td><input :disabled="(row.is_locked) ? true : false" v-model="row.midterm" v-on:input="computeGPA(row.prelim, row.midterm, row.final, index)" type="number" class="form-control"/></td>
						<td><input :disabled="(row.is_locked) ? true : false" v-model="row.final" v-on:input="computeGPA(row.prelim, row.midterm, row.final, index)" type="number" class="form-control"/></td>
						<td><input v-model="row.GPA" disabled class="form-control"/></td>
						<td>
							<button type="button" :disabled="(row.is_locked) ? true : false" v-on:click.prevent="saveState(row, index)" v-if="row.prelim === 0 || row.midterm === 0 || row.final === 0" class="btn btn-sm btn-primary">
								<i class="far fa-save"></i>
							</button>
							<button type="button" :disabled="(row.is_locked) ? true : false" v-on:click.prevent="lockState(row, index)" v-if="row.prelim !== 0 && row.midterm !== 0 && row.final !== 0" class="btn btn-sm btn-danger">
								<i class="fas fa-lock"></i>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
import Swal from "sweetalert2";

export default {
	props: {
		instructorId: {
			type: Number,
			required: true
		},
		subjectId: {
			type: Number,
			required: true
		},
		subject: {
			type: Object,
			required: true
		}
	},

	data () {
		return {
			list: []
		}
	},

	mounted() {
		this.getStudentList()
	},

	methods: {
		getStudentList() {
			axios.get(`http://localhost:8000/api/instructor/subjects/get_student_list?instructor=${this.instructorId}&subject=${this.subjectId}`)
			.then(response => {
				this.list = response.data
			})
		},

		computeGPA(prelim, midterm, final, index) {
			const parsedPrelim = (prelim !== null) ? parseFloat(prelim) : 0; 
			const parsedMidterm = (midterm !== null) ? parseFloat(midterm) : 0;
			const parsedFinal = (final !== null) ? parseFloat(final) : 0;
			const gpa = Math.round(((parsedPrelim + parsedMidterm + parsedFinal) / 3 ) * 100) / 100;
			
			this.list[index].GPA = gpa;
		},

		saveState(row, index) {
			Swal.fire({
				title: 'Saving',
				didOpen: () => {
					Swal.showLoading()
					return axios.post(`http://localhost:8000/api/instructor/subjects/update_grades`, {
						data: {
							id: row.id,
							prelim: row.prelim,
							midterm: row.midterm,
							final: row.final,
							GPA: row.GPA,
						},
						_method: 'PATCH'
					})
					.then(response => {
						Swal.hideLoading()

						Swal.fire({
							title: "Saved!",
							icon: "success",
							confirmButtonText: "Done"
						});
					})
					.catch(error => {
						Swal.hideLoading()

						Swal.fire({
							title: "Error!",
							text: "Error occured while saving. Please try again",
							icon: "error",
							confirmButtonText: "Done"
						});
					})
				},
				allowOutsideClick: false
			})
		},

		lockState(row, index) {
			Swal.fire({
				title: 'Saving',
				didOpen: () => {
					Swal.showLoading()
					return axios.post(`http://localhost:8000/api/instructor/subjects/update_grades`, {
						data: {
							id: row.id,
							prelim: row.prelim,
							midterm: row.midterm,
							final: row.final,
							GPA: row.GPA,
							locked: 1
						},
						_method: 'PATCH'
					})
					.then(response => {
						Swal.hideLoading()

						this.list[index].is_locked = 1

						Swal.fire({
							title: "Locked and Saved!",
							icon: "success",
							confirmButtonText: "Done"
						});
					})
					.catch(error => {
						Swal.hideLoading()

						Swal.fire({
							title: "Error!",
							text: "Error occured while saving. Please try again",
							icon: "error",
							confirmButtonText: "Done"
						});
					})
				},
				allowOutsideClick: false
			})
		}
	}
}
</script>