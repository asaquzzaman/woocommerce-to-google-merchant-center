<template>
	<div class="woogool-individual-field-wrap">
		<label class="woogool-label">Select Channel</label>
		<div class="field-action-wrap">
			<vue-woogool-multiselect
				class="header-multiselect"
				v-model="channel"
				:options="propChannels" 
                :multiple="false"
                :close-on-select="true"
                :clear-on-select="true"
                :show-labels="true"
                :searchable="true"
                placeholder="Select Channel"
                select-label=""
                selected-label="selected"
                deselect-label=""
                label="label"
                track-by="id"
                @input="changeChannel"
                :allow-empty="false">
					
			</vue-woogool-multiselect>
			
		</div>
	</div>
</template>


<script>
	import Mixin from '@components/new-feed/mixin'

	export default {
		mixins: [Mixin],

		props: {
			propChannels: {
				type: [Array],
				default () {
					return [];
				}
			},

			channel: {
				type: [Object],
				default() {

					return {
	                    label: 'Google Shopping',
	                    id: 'google_shopping'
					}
				}
			}
		},

		data () {
			return {
				
			}
		},
		created () {
			this.setDefaultChannel();
		},

		methods: {
			setDefaultChannel () {
				let index = this.getIndex( this.channels, this.$route.name, 'id' );

				if(index != -1) {
					this.channel = this.channels[index];
				}
			}
		}

	}
</script>











