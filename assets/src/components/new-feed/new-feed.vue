<template>
	<div class="">
		<feed-header></feed-header>
		<form action="" @submit.prevent="newFeed()" method="post">
			<form-header v-show="stage.step == 'first'" :header="header" :stage="stage"></form-header>
			<form-content v-show="stage.step == 'second'" :gAttrs="contentAttrs"  :stage="stage"></form-content>
			<form-logic v-show="stage.step == 'third'" :logic="logic" :stage="stage"></form-logic>
			
			<div>
				<!-- <span v-if="step == 'first'">
					<a href="#" class="button button-primary" @click.prevent="changeStage('second')">{{ 'Next' }}</a>
				</span> -->

				<!-- <span v-if="step == 'second'">
					<a href="#" class="button button-primary" @click.prevent="changeStage('first')">{{ 'Prev' }}</a>
					<a href="#" class="button button-primary" @click.prevent="changeStage('third')">{{ 'Next' }}</a>
				</span>

				<span >
					
					<input type="submit" class="button button-primary" value="Submit">
				</span> -->

			</div>
		</form>
	</div>
</template>


<script>
	import Header from '@components/header.vue'
	import FormHeader from '@components/new-feed/form-header.vue'
	import FormContent from '@components/new-feed/form-content.vue'
	import FormLogic from '@components/new-feed/form-logic.vue'
	import Mixin from '@components/new-feed/mixin'

	export default {
		mixins: [Mixin],
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
				},
				contentAttrs: [],
				logic: []
			}
		},
		components: {
			'feed-header': Header,
			'form-header': FormHeader,
			'form-content': FormContent,
			'form-logic': FormLogic
		},

		created () {
			this.getFeed(69);
		},
		methods: {
			newFeed () {
				console.log(this.contentAttrs); return;
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
			}
		}
	}
</script>