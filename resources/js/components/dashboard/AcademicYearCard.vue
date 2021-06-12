
<template>
	<div class="small-box bg-info">
		<div class="inner">
			<h3>{{academicYear}}</h3>

			<p>Academic Year</p>
		</div>
		<div class="icon">
			<i class="fas fa-calendar-alt"></i>
		</div>
	</div>
</template>

<script>
export default {
	data () {
		return {
			academicYear: ''
		}
	},

	mounted() {
		axios.get(`http://localhost:8000/api/academic-year/current_academic_year`)
		.then(response => {
			this.academicYear = `${response.data.from} - ${response.data.to}`
		});
	},
}
</script>