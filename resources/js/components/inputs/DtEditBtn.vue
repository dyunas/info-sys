<template>
	<button :class="classes" @click="click(data)" type="button" data-toggle="modal" data-target="#editModal">
		<span>
			<i class="fa fa-edit" aria-hidden="true"></i>
		</span>
		{{ name }}
	</button>
</template>

<script>
export default {
	props: {
		data: {},
		name: {},
		click: {
			type: Function,
			default: () => {}
		},
		classes: {
			type: Object,
			default: () => ({ 
				'btn': true,
				'btn-primary': true,
				'btn-sm': true,
			}),
		},
	}
}
</script>