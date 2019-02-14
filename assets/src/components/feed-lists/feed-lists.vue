<template>
	<div>
		<feed-header></feed-header>

		<div>
			<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						
						<th>Feed Name</th>
						<th class="third">Action</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="feeds.length" v-for="(feed, key) in feeds">
						<tr>
							<td>{{ feed.post_title }}</td>
							<td>
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
							</td>
						</tr>
					</template>

					<template v-if="!feeds.length">
						<tr>
							<td colspan="2">No feed found!</td>
						</tr>
					</template>

				</tbody>
			</table>
		</div>
	</div>
</template>


<script>
	import Header from '@components/header.vue'

	export default {
		data () {
			return {
				feeds: []
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
	                    if(res.success === true) {
	                    	self.feeds = res.data.posts;
	                    }
	                },
	            };

	            this.httpRequest(request);
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
	            
	            var args = {
	                data: {
	                	feed_title: feed.post_title,
	                    feed_id: feedID,
	                    offset: 0
	                },
	                callback ($this, res) {
	                    
	                }
	            }

	            this.generateFeedFile(args);
	        },

	        downloadFeedFile (feedID) {
	        	var self = this;
	        	var url = woogool_var.ajaxurl+'?action=woogool-download-feed_file&feed_id='+feedID+'&_wpnonce='+woogool_var.nonce;

	        	window.location.href = url;
	        	
				// var request = {
	   //              type: 'POST',
	   //              url: woogool_var.ajaxurl,
	   //              data: {
	   //              	feed_id: feedID,
	   //              	action: 'woogool-download-feed_file',
	   //              	_wpnonce: woogool_var.nonce,
	   //              },

	   //              success (res) {
	                    
	   //              },
	   //          };

	   //          this.httpRequest(request);
	        }
		}
	}
</script>