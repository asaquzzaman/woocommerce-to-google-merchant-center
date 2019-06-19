<template>
	<div>
		<google-shopping 
			v-if="header.channel.id == 'google_shopping'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</google-shopping>

		<google-promotion 
			v-if="header.channel.id == 'google_shopping_promotion'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</google-promotion>

		<google-local 
			v-if="header.channel.id == 'google_local'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</google-local>

		<facebook-ads 
			v-if="header.channel.id == 'facebook_ads'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</facebook-ads>

		<bing-shopping 
			v-if="header.channel.id == 'bing_shopping'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</bing-shopping>

		<yandex-attributes 
			v-if="header.channel.id == 'yandex'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</yandex-attributes>

		<fruugo-attributes 
			v-if="header.channel.id == 'fruugous' || header.channel.id == 'fruugouk'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</fruugo-attributes>

		<manomano-attributes 
			v-if="header.channel.id == 'manomano'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</manomano-attributes>

		<custom-feed 
			v-if="header.channel.id == 'custom_feed'"
			v-show="stage.step == 'second'" 
			:extAttr="extAttr" 
			:gAttrs="gAttrs"  
			:stage="stage">
				
		</custom-feed>
	</div>
</template>

<script>
	import GoogleShopping from '@components/new-feed/google-shopping/form-google-shopping.vue'
	import BingShopping from '@components/new-feed/bing-shopping/form-bing-shopping.vue'
	import GooglePromotion from '@components/new-feed/google-shopping-promotion/form-google-shopping-promotion.vue'
	import FacebookAds from '@components/new-feed/facebook-ads/form-facebook-ads.vue'
	import GoogleLocal from '@components/new-feed/google-local/form-google-local.vue'
	import YandexAttributes from '@components/new-feed/yandex/form-yandex-attributes.vue'
	import FruugoAttributes from '@components/new-feed/fruugous/form-fruugous-attributes.vue'
	import CustomFeed from '@components/new-feed/custom-feed/form-custom-feed.vue'
	import Manomano from '@components/new-feed/manomano/form-manomano-attributes.vue'

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
			'google-promotion': GooglePromotion,
			'facebook-ads': FacebookAds,
			'google-local': GoogleLocal,
			'custom-feed': CustomFeed,
			'yandex-attributes': YandexAttributes,
			'fruugo-attributes': FruugoAttributes,
			'manomano-attributes': Manomano
		},
	}
</script>
