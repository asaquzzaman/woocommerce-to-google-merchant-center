<template>
	<div>
		step third
		<div>
			<a href="#" class="button button-primary" @click.prevent="changeStage('second')">{{ 'Prev' }}</a>
			<input type="submit" class="button button-primary" value="Submit">
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
			logic: {
				type: [Object],
				default () {
					return {}
				}
			}
		}
	}
</script>