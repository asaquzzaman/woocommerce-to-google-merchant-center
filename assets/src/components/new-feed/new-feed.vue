<template>
	<div class="woogool-new-feed-warp">
		<feed-header></feed-header>
		<div v-if="!is_pro()" class="woogool-notice-warning">
	        <div>With this free verion you can generate only 20 products feed. For getting unlimited go with <a target="_blank" href="http://wpspear.com/product-feed/"><strong>Pro version</strong></a></div>
	    </div>
	    <div v-if="header.channel.id =='google_shopping'" class="woogool-notice-info">
	        <div>Please check this documentation before submit form <a target="_blank" href="https://support.google.com/merchants/answer/7052112?hl=en">https://support.google.com/merchants/answer/7052112?hl=en</a></div>
	    </div>
		

		<div class="woogool-new-feed-warp">
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
				<form-header 
					v-show="stage.step == 'first'" 
					:extAttr="extAttr" 
					:header="header" 
					:test="test"
					:stage="stage">
						
				</form-header>
				
				<move-feed-content
					:header="header"
					:extAttr="extAttr" 
					:gAttrs="gAttrs"  
					:stage="stage">
						
				</move-feed-content>
				
				<form-logic 
					v-show="stage.step == 'third'" 
					:logic="logic" 
					:stage="stage">
					
				</form-logic>
				
				<button-group
					:btnMeta="buttonGroup"
					:header="header"
					:stage="stage"
					:gAttrs="gAttrs"
					:logic="logic"
					@submit="submit">
					
				</button-group>

			</form>
		</div>

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
	import Mixin from '@components/new-feed/mixin'

	import FormHeader from '@components/new-feed/form-header.vue'
	import FormLogic from '@components/new-feed/form-logic.vue'
	import ButtonGroup from '@components/new-feed/button-group.vue'
	import MoveFeedContent from '@components/new-feed/move-feed-content.vue'
	
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
					categories: [],
					country: {},
					channel: {
						label: 'Google Shopping',
						id: 'google_shopping'
					},
				},
				gAttrs: [],
				logic: [],
				loading: true,
				extAttr: {
					updateMode: false
				},
				buttonGroup: {
					isActiveSpinner: false,
					width: 0,
					refreshStatus: false,
				},
				stage: {
					step: 'first',
				},
			}
		},

		components: {
			'feed-header': Header,
			'form-header': FormHeader,
			'form-logic': FormLogic,
			'button-group': ButtonGroup,
			'move-feed-content': MoveFeedContent
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

		watch: {
			'$route' (route, prev) {
				
				if(prev.name == 'new_feed_update' && route.name == 'new_feed') {
					this.resetData(); 
				}
			}
		},

		methods: {
			resetData () {
				this.$router.push({
					name: 'reset_new_feed'
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
						self.buttonGroup.refreshStatus = true;
						self.feed_id = res.data.feed_id;
						self.createFeedFile( res.data.feed_id );
					}
				}
				
				self.buttonGroup.isActiveSpinner = true;
				self.newFeed(args);
			},

			createFeedFile (feedID, offset) {
	            var self = this;
	            offset = offset || 0;
	            self.buttonGroup.width = 0;

	            var args = {
	                data: {
	                    feed_id: feedID,
	                    offset: offset
	                },
	                callback (res) {
	                    let totalPosts = res.data.found_posts;
	                	let offset = res.data.offset;
	                	let percent = self.getProgressPercentage(totalPosts, offset);

	                	self.buttonGroup.width = percent;

	                	if(percent >= 100) {
	                		self.buttonGroup.refreshStatus = false;
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
					id:feed.header.channel,
            		label: '',
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