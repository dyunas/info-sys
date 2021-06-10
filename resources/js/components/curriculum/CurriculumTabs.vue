<template>
	<div>
		<template v-if="subjects.length > 0">
			<template v-for="(levels, index) in year_levels">
				<div class="table-responsive" :key="index">
					<table class="table table-sm table-hover table-bordered text-nowrap">
						<thead>
							<tr>
								<th colspan="4">Year Level: {{levels}} | Semester: First Semester</th>
							</tr>
							<tr>
								<th width="70%">Name</th>
								<th width="10%">Code</th>
								<th width="10%">Unit</th>
								<th width="10%">Pre-Req</th>
							</tr>
						</thead>
						<tbody>
							<template v-for="(subject) in subjects">
								<tr v-if="parseInt(subject.year_level) === levels && subject.semester === 'First Semester'" :key="subject.id">
									<td>{{ subject.name }}</td>
									<td>{{ subject.code }}</td>
									<td>{{ subject.units }}</td>
									<td>{{ subject.pre_req }}</td>
								</tr>
							</template>
						</tbody>
					</table>

					<table class="table table-sm table-hover table-bordered text-nowrap">
						<thead>
							<tr>
								<th colspan="4">Year Level: {{levels}} | Semester: Second Semester</th>
							</tr>
							<tr>
								<th width="70%">Name</th>
								<th width="10%">Code</th>
								<th width="10%">Unit</th>
								<th width="10%">Pre-Req</th>
							</tr>
						</thead>
						<tbody>
							<template v-for="(subject) in subjects">
								<tr v-if="parseInt(subject.year_level) === levels && subject.semester === 'Second Semester'" :key="subject.id">
									<td>{{ subject.name }}</td>
									<td>{{ subject.code }}</td>
									<td>{{ subject.units }}</td>
									<td>{{ subject.pre_req }}</td>
								</tr>
							</template>
						</tbody>
					</table>
				</div>
			</template>
		</template>
	</div>
</template>

<script>
export default {
	props: {
		curriculum: {
			type: Object,
			required: true
		},
		subjects: {
			type: Array,
			required: true
		}
	},

	data () {
		return {
			year_levels: []
		}
	},

	mounted() {
		for(let count = 1; count <= this.curriculum.course.year_levels; count++) {
			this.year_levels.push(count);
		}
	}
}
</script>