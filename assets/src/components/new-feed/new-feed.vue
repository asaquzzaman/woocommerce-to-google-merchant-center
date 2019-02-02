<template>
	<div class="">
		<feed-header></feed-header>
		<form class="woogool-new-feed-form" action="" @submit.prevent="submit()" method="post">
			<form-header v-show="stage.step == 'first'" :header="header" :stage="stage"></form-header>
			<form-content v-show="stage.step == 'second'" :gAttrs="gAttrs"  :stage="stage"></form-content>
			<form-logic v-show="stage.step == 'third'" :logic="logic" :stage="stage"></form-logic>
			
			<div class="button-group">
				<div class="btn-wrap first-btn-wrap" v-show="stage.step == 'first'">
					<a href="#" class="button button-primary" @click.prevent="changeStage('second')">{{ 'Next' }}</a>
				</div>

				<div class="btn-wrap second-btn-wrap" v-show="stage.step == 'second'">
					<a href="#" class="button button-primary" @click.prevent="changeStage('first')">{{ 'Prev' }}</a>
					<a href="#" class="button second-btn button-primary" @click.prevent="addCustomField('first')">{{ 'Add custom field' }}</a>
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
					<a href="#" class="button button-primary save-btn" @click.prevent="submit()">{{ 'Save' }}</a>
					<div class="woogool-clearfix"></div>
				</div>
			</div>
			<!-- <a href="#" class="button button-primary" @click.prevent="createFeedFile(80)">{{ 'Generate Feed File' }}</a> -->

		</form>
	</div>
</template>

<style lang="less">
	.woogool-new-feed-form {
		background: #f8f8f8;
    	border: 1px solid #ddd;
    	border-top: none;

    	.button-group {
    		display: flex;
    		margin-bottom: 12px;
    		margin-top: 12px;

    		.second-btn-wrap, .third-btn-wrap {
    			.button {
    				margin-right: 10px;
    			}
    			.second-btn {
    				margin-right: 3px;
    			}
    		}

    		.btn-wrap {
    			padding-left: 10px;
    			flex: 1;
    		}

    		.save-btn-wrap {
    			padding-right: 10px;
    		}
    	}
	}

</style>


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
				gAttrs: [],
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
			var feed_id = this.$route.params.feed_id;

			if(feed_id) {
				this.getFeed(feed_id);
				this.feed_id = feed_id;
			}
			
		},
		methods: {
			submit () {
				var self = this;
				var args = {
					data: {
						feed_id: self.feed_id,
						header: self.header,
                		contentAttrs: self.gAttrs,
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
				this.gAttrs = feed.contentAttrs;
			},

			setLogic (feed) {
				this.logic = feed.logic;
			}
		},

	}
</script>