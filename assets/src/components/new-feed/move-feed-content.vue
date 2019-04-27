<template>
	<div>
		<google-shopping 
			v-if="header.channel.id == 'google_shopping'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</google-shopping>

		<bing-shopping 
			v-if="header.channel.id == 'bing_shopping'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</bing-shopping>

		<google-promotion 
			v-if="header.channel.id == 'google_shopping_promotion'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</google-promotion>
	</div>
</template>

<script>
	import GoogleShopping from '@components/new-feed/google-shopping/form-google-shopping.vue'
	import BingShopping from '@components/new-feed/bing-shopping/form-bing-shopping.vue'
	import GooglePromotion from '@components/new-feed/google-shopping-promotion/form-google-shopping-promotion.vue'

	export default {
		props: {
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
			},

			extAttr: {
				type: [Object],
				default () {
					return {}
				}
			},

			gAttrs: {
				type: [Object],
				default () {
					return {}
				}
			}
		},

		components: {
			'google-shopping': GoogleShopping,
			'bing-shopping': BingShopping,
			'google-promotion': GooglePromotion
		},
	}
</script>
