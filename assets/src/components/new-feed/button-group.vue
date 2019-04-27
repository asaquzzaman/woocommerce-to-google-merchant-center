<template>
	<div class="button-group">

		<div class="btn-wrap first-btn-wrap" v-show="stage.step == 'first'">
			<a href="#" class="button button-primary" @click.prevent="changeStage('second')">{{ 'Next' }}</a>
		</div>

		<div class="btn-wrap second-btn-wrap" v-show="stage.step == 'second'">
			<a href="#" class="button button-primary" @click.prevent="changeStage('first')">{{ 'Prev' }}</a>
			<!-- <a href="#" class="button second-btn button-primary" @click.prevent="addCustomField('first')">{{ 'Add custom field' }}</a> -->
			<a href="#" class="button button-primary" @click.prevent="addMappingField()">{{ 'Add mapping field' }}</a>
			<a href="#" class="button button-primary" @click.prevent="changeStage('third')">{{ 'Next' }}</a>
		</div>

		<div class="btn-wrap third-btn-wrap" v-show="stage.step == 'third'">
			<a href="#" class="button button-primary" @click.prevent="changeStage('second')">{{ 'Prev' }}</a>
			<a href="#" class="button second-btn button-primary" @click.prevent="addFields('filter')">{{ '+ Filter' }}</a>
			<a href="#" class="button button-primary" @click.prevent="addFields('rule')">{{ '+ Rule' }}</a>
			<a href="#" class="button button-primary" @click.prevent="addFields('value')">{{ '+ Value' }}</a>
		</div>

		<div class="save-btn-wrap">
			<div v-if="btnMeta.isActiveSpinner" :class="btnMeta.refreshStatus ? 'progress-bar-left-normal progress-wrap': 'progress-bar-left-minues progress-wrap'">
				<div :class="'progress-bar'">
					<div class="bar completed" :style="'width:'+ btnMeta.width +'%'"></div>
				</div> 
				<span class="number">{{ btnMeta.width+'%' }}</span>
			</div>

			<span v-if="btnMeta.isActiveSpinner" class="woogool-spinner"></span>
			<a v-if="feed_id" href="#" class="button button-secondary cancel-btn" @click.prevent="cancel()">{{ 'Cancel' }}</a>
			<a v-if="feed_id" href="#" class="button button-primary save-btn" @click.prevent="submit()">{{ 'Update' }}</a>
			<a v-if="!feed_id" href="#" class="button button-primary save-btn" @click.prevent="submit()">{{ 'Save' }}</a>
			<div class="woogool-clearfix"></div>
		</div>
	</div>
</template>

<script>
	import Mixin from '@components/new-feed/mixin'

	export default {
		mixins: [Mixin],
		props: {
			btnMeta: {
				type: [Object],
				default () {
					return {}
				}
			},
			header: {
				type: [Object],
				default () {
					return {}
				}
			},
			stage: {
				type: [Object],
				default () {
					return {}
				}
			}
		},
		methods: {
			cancel () {
				this.$router.push({
					name: 'feed_lists'
				});
			},
			submit () {
				this.$emit('submit');
			}
		}
	}
</script>