<template>
	<div class="wrap">
		<feed-header></feed-header>
		<form action="" @submit.prevent="newFeed()" method="post">
			<form-header :header="header"></form-header>
			<form-content :content="{}"></form-content>
			<form-logic :logic="{}"></form-logic>
			<input type="submit" class="button button-primary" value="Submit">
		</form>
	</div>
</template>


<script>
	import Header from '@components/header.vue'
	import FormHeader from '@components/new-feed/form-header.vue'
	import FormContent from '@components/new-feed/form-logic.vue'
	import FormLogic from '@components/new-feed/form-content.vue'



	export default {
		data () {
			return {
				header: {
					feedByCatgory: false,
					name: '',
					activeVariation: false,
					feedCategories: [],
					refresh: 1,
					googleCategories: [],
					categories: []
				}
			}
		},
		components: {
			'feed-header': Header,
			'form-header': FormHeader,
			'form-content': FormContent,
			'form-logic': FormLogic
		},

		created () {
			this.getFeed(68);
		},
		methods: {
			newFeed () {
				var request = {
	                type: 'POST',
	                url: woogool_var.ajaxurl,
	                data: {
	                	action: 'woogool-new-feed',
	                	_wpnonce: woogool_var.nonce,
	                	header: this.header
	                },
	                success (res) {
	                    
	                },
	            };

	            this.httpRequest(request);
			},

			getFeed (postId) {
				var self = this;
				var request = {
	                type: 'POST',
	                url: woogool_var.ajaxurl,
	                data: {
	                	post_id: postId,
	                	action: 'woogool-get-feed',
	                	_wpnonce: woogool_var.nonce,
	                },
	                success (res) {
	                    self.setHeader(res.data);
	                },
	            };

	            this.httpRequest(request);
			},

			setHeader (feed) {
				this.header = feed.post_meta;
				console.log(this.header);
			}
		}
	}
</script>