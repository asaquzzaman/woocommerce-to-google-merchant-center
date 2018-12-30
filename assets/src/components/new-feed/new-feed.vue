<template>
	<div class="">
		<feed-header></feed-header>
		<form action="" @submit.prevent="submit()" method="post">
			<form-header v-show="stage.step == 'first'" :header="header" :stage="stage"></form-header>
			<form-content v-show="stage.step == 'second'" :gAttrs="contentAttrs"  :stage="stage"></form-content>
			<form-logic v-show="stage.step == 'third'" :logic="logic" :stage="stage"></form-logic>
			
			
			<a href="#" class="button button-primary" @click.prevent="submit()">{{ 'Save' }}</a>
			<a href="#" class="button button-primary" @click.prevent="createFeedFile(80)">{{ 'Generate Feed File' }}</a>

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
				feed_id: false,
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
			this.getFeed(80);
			this.feed_id = 80;
		},
		methods: {
			submit () {
				var self = this;
				var args = {
					data: {
						feed_id: self.feed_id,
						header: self.header,
                		contentAttrs: self.contentAttrs,
                		logic: self.logic	
					},
					callback (res) {
						self.feed_id = res.data.feed_id;
					}
				}
				
				self.newFeed(args);
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
	                    self.setContentAttrs(res.data);
	                    self.setLogic(res.data);
	                },
	            };

	            this.httpRequest(request);
			},

			setHeader (feed) {
				this.header = feed.header;
				this.header.activeVariation = this.setBoolen(feed.header.activeVariation);
				this.header.feedByCatgory = this.setBoolen(feed.header.feedByCatgory);
			},

			setContentAttrs (feed) {
				this.contentAttrs = feed.contentAttrs;
			},

			setLogic (feed) {
				this.logic = feed.logic;
			},

			createFeedFile (feedID) {
				var self = this;

				var args = {
					data: {
						feed_id: feedID,
						feed_title: self.header.name
					},
					callback ($this, res) {

					}
				}

				this.generateFeedFile(args);
			}
		},

	}
</script>