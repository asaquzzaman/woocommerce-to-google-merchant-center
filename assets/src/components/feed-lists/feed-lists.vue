<template>
	<div class="woogool-feed-lists-wrap">
		<feed-header></feed-header>

		<div>
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						
						<th>Feed Name</th>
						<th>Download link</th>
						<th class="third">Action</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="feeds.length" v-for="(feed, key) in feeds">
						<tr>
							<td>{{ feed.post_title }}</td>
							<td><a target="_blank" :href="feed.feed_url">{{ feed.feed_url }}</a></td>
							<td>
								<div class="list-action-wrap">
									<div class="actions">
										<router-link
											:to="{
												name: 'edit_feed', 
												params: {
													feed_id: feed.ID
												}
											}">

											Edit
										</router-link>|
										<a href="#" @click.prevent="deleteFeed(feed.ID)">Delete</a>|
										<a href="#" @click.prevent="createFeedFile(feed.ID, feed)">Refresh</a>|
										<!-- @click.prevent="downloadFeedFile(feed.ID) -->
										<a :href="feed.feed_url" target="_blank" ref="noopener">Download</a> 
									</div>
									<div :class="feed.refreshStatus ? 'progress-bar-left-normal progress-wrap': 'progress-bar-left-minues progress-wrap'">
										<div :class="'progress-bar'">
											<div class="bar completed" :style="'width:'+ width +'%'"></div>
										</div> 
										<span class="number">{{ width+'%' }}</span>
									</div>
								</div>
							</td>
						</tr>
					</template>

					<template v-if="loading">
						<tr>
							<td colspan="3">
								<div  class="loadmoreanimation">
						            <div class="load-spinner">
						                <div class="rect1"></div>
						                <div class="rect2"></div>
						                <div class="rect3"></div>
						                <div class="rect4"></div>
						                <div class="rect5"></div>
						            </div>
						        </div>
						    </td>
						</tr>
					</template>

					<template v-if="!loading && !feeds.length">
						<tr>
							<td colspan="3">No feed found!</td>
						</tr>
					</template>

				</tbody>
			</table>
		</div>
	</div>
</template>

<style lang="less">
	.woogool-feed-lists-wrap {
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

	export default {
		data () {
			return {
				feeds: [],
				loading: true,
				width: 0
			}
		},
		components: {
			'feed-header': Header
		},

		created () {
			this.getFeeds();
		},

		methods: {
			getFeeds () {
				var self = this;

				var request = {
	                type: 'GET',
	                url: woogool_var.ajaxurl,
	                data: {
	                	action: 'woogool-get-feeds',
	                	_wpnonce: woogool_var.nonce,
	                },

	                success (res) {
	                	self.loading = false;
	                	self.addMeta(res.data.posts);
	                    if(res.success === true) {
	                    	self.feeds = res.data.posts;
	                    }
	                },
	            };

	            this.httpRequest(request);
			},

			addMeta (metas) {
				metas.forEach(function(meta, index) {
					meta['refreshStatus'] = false;
				});
			},

			deleteFeed (feedId) {
				var self = this;

				if(!confirm('Are you sure!')) {
					return;
				}

				var request = {
	                type: 'POST',
	                url: woogool_var.ajaxurl,
	                data: {
	                	feed_id: feedId,
	                	action: 'woogool-get-feed-delete',
	                	_wpnonce: woogool_var.nonce,
	                },

	                success (res) {
	                    if(res.success === true) {
	                    	var index = self.getIndex(self.feeds, feedId, 'ID');

	                    	if(index !== false) {
	                    		self.feeds.splice(index, 1);
	                    	}
	                    }
	                },
	            };

	            this.httpRequest(request);
			},

			createFeedFile (feedID, feed) {
	            var self = this;
	            feed.refreshStatus = true;
	            self.width = 0;

	            var args = {
	                data: {
	                	feed_title: feed.post_title,
	                    feed_id: feedID,
	                    offset: 0
	                },
	                callback (res) {
	                	let totalPosts = res.data.found_posts;
	                	let offset = res.data.offset;
	                	let percent = self.getProgressPercentage(totalPosts, offset);

	                	self.width = percent;

	                	if(percent >= 100) {
	                		feed.refreshStatus = false;
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

	        downloadFeedFile (feedID) {
	        	var self = this;
	        	var url = woogool_var.ajaxurl+'?action=woogool-download-feed_file&feed_id='+feedID+'&_wpnonce='+woogool_var.nonce;

	        	window.location.href = url;
	        	
	        }
		}
	}
</script>





