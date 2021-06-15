<template>
	<div>
		<template v-if="subjects.length > 0">
			<template v-for="(levels, index) in year_levels">
				<div class="table-responsive" :key="index">
					<table class="table table-sm table-hover table-bordered text-nowrap">
						<thead>
							<tr>
								<th colspan="7">Year Level: {{levels}} | Semester: First Semester</th>
							</tr>
							<tr>
								<th width="10%">Code</th>
								<th width="65%">Name</th>
								<th width="5%">Unit</th>
								<th width="5%">Prelim</th>
								<th width="5%">Midterm</th>
								<th width="5%">Final</th>
								<th width="5%">GRADE</th>
							</tr>
						</thead>
						<tbody>
							<template v-for="(subject) in subjects">
								<tr v-if="parseInt(subject.year_level) === levels && subject.semester === 'First Semester'" :key="subject.id">
									<td>{{ subject.subjects.code }}</td>
									<td>{{ subject.subjects.name }}</td>
									<td>{{ subject.subjects.units }}</td>
									<td>{{ subject.prelim }}</td>
									<td>{{ subject.midterm }}</td>
									<td>{{ subject.final }}</td>
									<td>{{ subject.GPA }}</td>
								</tr>
							</template>
						</tbody>
					</table>

					<table class="table table-sm table-hover table-bordered text-nowrap">
						<thead>
							<tr>
								<th colspan="7">Year Level: {{levels}} | Semester: Second Semester</th>
							</tr>
							<tr>
								<th width="10%">Code</th>
								<th width="65%">Name</th>
								<th width="5%">Unit</th>
								<th width="5%">Prelim</th>
								<th width="5%">Midterm</th>
								<th width="5%">Final</th>
								<th width="5%">GRADE</th>
							</tr>
						</thead>
						<tbody>
							<template v-for="(subject) in subjects">
								<tr v-if="parseInt(subject.year_level) === levels && subject.semester === 'Second Semester'" :key="subject.id">
									<td>{{ subject.subjects.code }}</td>
									<td>{{ subject.subjects.name }}</td>
									<td>{{ subject.subjects.units }}</td>
									<td>{{ subject.prelim }}</td>
									<td>{{ subject.midterm }}</td>
									<td>{{ subject.final }}</td>
									<td>{{ subject.GPA }}</td>
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
		yearLevels: {
			type: Number,
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
		for(let count = 1; count <= this.yearLevels; count++) {
			this.year_levels.push(count);
		}
	}
}
</script>