<template>
	<div class="woogool-new-feed-warp">
		<!-- <feed-header></feed-header> -->
		

		<div v-if="loading" class="loadmoreanimation">
	        <div class="load-spinner">
	            <div class="rect1"></div>
	            <div class="rect2"></div>
	            <div class="rect3"></div>
	            <div class="rect4"></div>
	            <div class="rect5"></div>
	        </div>
	    </div>

		<form v-if="!loading" class="woogool-new-feed-form" action="" @submit.prevent="submit()" method="post">
			<form-header v-show="stage.step == 'first'" :extAttr="extAttr" :header="header" :stage="stage"></form-header>
			<google-shopping v-show="stage.step == 'second'" :extAttr="extAttr" :gAttrs="gAttrs"  :stage="stage"></google-shopping>
			<form-logic v-show="stage.step == 'third'" :logic="logic" :stage="stage"></form-logic>
			
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
					<div v-if="isActiveSpinner" :class="refreshStatus ? 'progress-bar-left-normal progress-wrap': 'progress-bar-left-minues progress-wrap'">
						<div :class="'progress-bar'">
							<div class="bar completed" :style="'width:'+ width +'%'"></div>
						</div> 
						<span class="number">{{ width+'%' }}</span>
					</div>

					<span v-if="isActiveSpinner" class="woogool-spinner"></span>
					<a v-if="feed_id" href="#" class="button button-secondary cancel-btn" @click.prevent="cancel()">{{ 'Cancel' }}</a>
					<a v-if="feed_id" href="#" class="button button-primary save-btn" @click.prevent="submit()">{{ 'Update' }}</a>
					<a v-if="!feed_id" href="#" class="button button-primary save-btn" @click.prevent="submit()">{{ 'Save' }}</a>
					<div class="woogool-clearfix"></div>
				</div>
			</div>
			<!-- <a href="#" class="button button-primary" @click.prevent="createFeedFile(80)">{{ 'Generate Feed File' }}</a> -->

		</form>
	</div>
</template>

<style lang="less">
	.woogool-new-feed-warp {
		.woogool-notice-warning {
			margin: 0px 0 1px;
			background: #fff;
		    border-left: 4px solid #ffb900;
		    box-shadow: 0 1px 1px 0 rgba( 0, 0, 0, 0.1 );
		    padding: 8px 12px;
		}
		.woogool-notice-info {
			margin: 0px 0 1px;
			margin-top: 10px;
			border-left: 4px solid #00a0d2;
			background: #fff;
		    box-shadow: 0 1px 1px 0 rgba( 0, 0, 0, 0.1 );
		    padding: 8px 12px;
		}
	}
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
    			display: flex;
    			align-items: center;
    			.woogool-spinner {
    				margin-right: 10px;
    			}
    			.cancel-btn {
    				margin-right: 10px;
    			}
    		}
    	}

    	.progress-bar {
			width: 52px;
		    background: #D7DEE2;
		    height: 5px;
		    border-radius: 3px;
		   	margin: 3px 0 0 0;
		}
		.completed {
	    	background: #1A9ED4;
		    height: 5px;
		    border-radius: 3px;
	    }
		.progress-bar-left-normal {
			position: relative;
		    left: 0;
		}
		.progress-bar-left-minues {
			position: relative;
		    left: -9999em;
		}
		.progress-wrap {
			display: flex;
			align-items: center;
			margin-right: 10px;

			.number {
				line-height: 1;
				font-size: 10px;
				margin-left: 10px;
			}
		}
	}

</style>


<script>
	import Header from '@components/header.vue'
	import FormHeader from '@components/new-feed/google-shopping/form-header.vue'
	import FormContent from '@components/new-feed/google-shopping/form-google-shopping.vue'
	import FormLogic from '@components/new-feed/google-shopping/form-logic.vue'
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
					categories: [],
					country: {},
					channel: {
						label: 'Google Shopping',
						id: 'google_shopping'
					},
				},
				gAttrs: [],
				fAttrs: [],
				logic: [],
				isActiveSpinner: false,
				width: 0,
				refreshStatus: false,
				loading: true,
				extAttr: {
					updateMode: false
				}
			}
		},
		watch: {
			'$route' (route, old) { 
                if(old.name === 'edit_google_shopping') {
                	this.feed_id = false;
                	this.header = jQuery.extend({}, this.header, {
						feedByCatgory: false,
						name: '',
						activeVariation: false,
						feedCategories: [],
						refresh: 1,
						googleCategories: [],
						categories: []
					});
					this.gAttrs = [];
					this.logic = [];
                }
            }
		},
		components: {
			'feed-header': Header,
			'form-header': FormHeader,
			'google-shopping': FormContent,
			'form-logic': FormLogic,
		},

		created () {
			var feed_id = this.$route.params.feed_id;

			if(feed_id) {
				this.getFeed(feed_id);
				this.feed_id = feed_id;
				this.extAttr.updateMode = true;
			} else {
				this.loading = false;
			}
			
		},
		methods: {
			cancel () {
				this.$router.push({
					name: 'feed_lists'
				});
			},
			isValidate () {
				if(this.header.name === '') {
					alert('Feed name is required!');
					return false;
				}

				return true;
			},

			submit () {
				var self = this;
				if(!this.isValidate()) {
					return;
				}
				var args = {
					data: {
						feed_id: self.feed_id,
						header: self.header,
                		contentAttrs: self.gAttrs,
                		logic: self.logic	
					},
					callback (res) {
						self.refreshStatus = true;
						self.feed_id = res.data.feed_id;
						self.createFeedFile( res.data.feed_id );
					}
				}
				self.isActiveSpinner = true;
				self.newFeed(args);
			},

			createFeedFile (feedID, offset) {
	            var self = this;
	            offset = offset || 0;
	            self.width = 0;

	            var args = {
	                data: {
	                    feed_id: feedID,
	                    offset: offset
	                },
	                callback (res) {
	                    let totalPosts = res.data.found_posts;
	                	let offset = res.data.offset;
	                	let percent = self.getProgressPercentage(totalPosts, offset);

	                	self.width = percent;

	                	if(percent >= 100) {
	                		self.refreshStatus = false;
	                		self.cancel();
	                	}
	                }
	            }

	            this.generateFeedFile(args);
	        },
	        getProgressPercentage(total, set) {
	        	if(total <= 0) return 100;

                let progress        = ( 100 * set ) / total;

            	return isNaN( progress ) ? 0 : progress.toFixed(0);
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
	                	self.loading = false;
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

				this.header.channel = {
					'label': 'Google Shopping',
					'id': 'google_shopping'
				};

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