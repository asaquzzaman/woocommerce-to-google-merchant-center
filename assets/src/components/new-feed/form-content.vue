<template>
	<div>
		step second
		<div>
			<a href="#" class="button button-primary" @click.prevent="changeStage('first')">{{ 'Prev' }}</a>
			<a href="#" class="button button-primary" @click.prevent="changeStage('third')">{{ 'Next' }}</a>
		</div>
	</div>
</template>

<script>
	import Mixin from '@components/new-feed/mixin'

	export default {
		mixins: [Mixin],
		props: {
			stage: {
				type: [Object],
				default () {
					return {}
				}
			},
			content: {
				type: [Object],
				default () {
					return {}
				}
			}
		}
	}
</script>