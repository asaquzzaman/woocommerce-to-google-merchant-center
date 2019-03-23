<template>
	<div class="woogool-new-feed-warp">
		<feed-header></feed-header>
		<div v-if="!is_pro()" class="woogool-notice-warning">
	        <div>With this free verion you can generate only 20 products feed. For getting unlimited go with <a target="_blank" href="http://wpspear.com/product-feed/"><strong>Pro version</strong></a></div>
	    </div>
	    <div v-if="$route.name=='googel_shopping'" class="woogool-notice-info">
	        <div>Please check this documentation before submit form <a target="_blank" href="https://support.google.com/merchants/answer/7052112?hl=en">https://support.google.com/merchants/answer/7052112?hl=en</a></div>
	    </div>
		<!-- <div>
			<label>Select Channel</label>
			<select v-model="channel">
				<option value="">-Select-</option>
				<option value="google_shopping">Google Shopping</option>
				<option value="facebook_ads">Facebook Ads</option>
			</select>
		</div> -->

		<router-view></router-view>
	</div>
</template>

<style lang="less">
	.woogool-new-feed-warp {

	}

</style>


<script>
	import Header from '@components/header.vue'
	import Mixin from '@components/new-feed/mixin'
	
	export default {
		mixins: [Mixin],
		data () {
			return {
				channel: ''
			}
		},
		watch: {
			'$route' (route) {
	            if(route.name === 'new_feed') {
	            	this.setDefaultRoute();
	            }
	        }
		},
		components: {
			'feed-header': Header
		},

		created () {
			this.setDefaultRoute();
		},

		methods: {
			setDefaultRoute() {
				if(this.$route.name == 'new_feed') {
					this.gotoGoogleShopping();
				}

				if(this.$route.name == 'google_shopping') {
					this.gotoGoogleShopping();
				}

				if(this.$route.name == 'facebook_ads') {
					this.gotoFacebookAds();
				}
			}
		},

	}
</script>