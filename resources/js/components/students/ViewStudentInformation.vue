<template>
	<div>
		<div class="card card-primary">
			<div class="card-header">
				<h5 class="card-title">
					Student Information:
				</h5>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="comp_name">
								COMPLETE NAME
							</label>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
									<div class="form-control form-outline">
										{{record[0].student.last_name}}
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
									<div class="form-control form-outline">
										{{record[0].student.first_name}}
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
									<div class="form-control form-outline">
										{{record[0].student.middle_name}}
									</div>
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
							<div class="form-control form-outline">
								{{record[0].student.gender}}
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="bdate">
								BIRTHDATE
							</label>
							<div class="form-control form-outline">
								{{record[0].student.bdate}}
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="age">
								AGE
							</label>
							<div class="form-control form-outline">
								{{record[0].student.age}}
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="email">EMAIL ADDRESS</label>
							<div class="form-control form-outline">
								{{record[0].student.email}}
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label for="contactNumber">CONTACT NUMBER</label>
							<div class="form-control form-outline">
								{{record[0].student.contact_number}}
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="address">ADDRESS</label>
							<div class="form-control form-outline">
								{{record[0].student.address}}
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="province">PROVINCE</label>
							<div class="form-control form-outline">
								{{record[0].student.province}}
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="municipality">CITY/MUNICIPALITY</label>
							<div class="form-control form-outline">
								{{record[0].student.municipal}}
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="barangay">BARANGAY</label>
							<div class="form-control form-outline">
								{{record[0].student.barangay}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-primary">
			<div class="card-header">
				<h5 class="card-title">Academic Information:</h5>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="course">COURSE</label>
							<div class="form-control form-outline">
								{{record[0].student.courses.course_name}}
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-3">
						<div class="form-group">
							<label for="yearLevel">YEAR LEVEL</label>
							<div class="form-control form-outline">
								{{record[0].student.year_level}}
							</div>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="form-group">
							<label for="curriculum">CURRICULUM</label>
							<div class="form-control form-outline">
								{{record[0].student.curriculums.school_year}}
							</div>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="form-group">
							<label for="semester">SEMESTER</label>
							<div class="form-control form-outline">
								{{record[0].student.semester}}
							</div>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="form-group">
							<label for="semester">ACADEMIC YEAR</label>
							<div class="form-control form-outline">
								{{record[0].student.acad_year}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card card-primary">
			<div class="card-header">
				<h5 class="card-title">
					Subjects:
				</h5>
			</div>

			<div class="card-body p-0">
				<student-grades :year-levels="record[0].student.courses.year_levels" :subjects="record[0].student.graded_subjects" :acad-year="record[0].student.acad_year"></student-grades>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		auth: {
			type: Object,
			required: true
		}
	},

	data () {
		return {
			record: []
		}
	},

	mounted() {
		this.getStudentRecord(this.auth.id)
	},

	methods: {
		getStudentRecord(id) {
			axios.get(`http://localhost:8000/api/students/${id}`)
			.then(response => {
				this.record = response.data
			})
		}
	},
}
</script>