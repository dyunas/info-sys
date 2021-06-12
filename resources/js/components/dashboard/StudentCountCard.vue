<template>
	<div class="small-box bg-info">
		<div class="inner">
			<h3>{{count}}</h3>

			<p>Students</p>
		</div>
		<div class="icon">
			<i class="fas fa-user-graduate"></i>
		</div>
	</div>
</template>

<script>
export default {
	data () {
		return {
			count: 0
		}
	},

	mounted() {
		axios.get(`http://localhost:8000/api/students/count`)
		.then(response => {
			this.count = response.data;
		});
	}
}
</script>