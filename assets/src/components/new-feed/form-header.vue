<template>
	<div class="woogool-feed-step-1">
		
		<div class="woogool-individual-field-wrap">
			<label for="feed-name-field" class="woogool-label">Feed name</label>
			<div class="field-action-wrap">
				<input id="feed-name-field" v-model="header.name" type="text" class="woogool-field feed-name-field">
			</div>
		</div>

		<div class="woogool-individual-field-wrap">
			<label class="woogool-label">Select Country</label>
			<div class="field-action-wrap">
				<vue-woogool-multiselect
					class="header-multiselect"
					v-model="header.country"
					:options="countries" 
	                :multiple="false"
	                :close-on-select="true"
	                :clear-on-select="true"
	                :show-labels="true"
	                :searchable="true"
	                placeholder="Select Country"
	                select-label=""
	                selected-label="selected"
	                deselect-label=""
	                label="label"
	                track-by="id"
	                @input="onChangeCountry"
	                :allow-empty="true">
						
				</vue-woogool-multiselect>
				
			</div>
		</div>

	<!-- 	<channel 
			:channel="defaultChannel" 
			:propChannels="channels" 
			v-if="!extAttr.updateMode"
			@channelChange="channelChange">
			
		</channel> -->

		<div v-if="!isUpdateMode()" class="woogool-individual-field-wrap">
			<label class="woogool-label">Select Channel</label>
			<div class="field-action-wrap">
				<vue-woogool-multiselect
					class="header-multiselect"
					v-model="header.channel"
					:options="channels" 
	                :multiple="false"
	                :close-on-select="true"
	                :clear-on-select="true"
	                :show-labels="true"
	                :searchable="true"
	                placeholder="Select Channel"
	                select-label=""
	                selected-label="selected"
	                deselect-label=""
	                label="label"
	                track-by="label"
	                @input="onChangeChannel"
	                :allow-empty="false">
						
				</vue-woogool-multiselect>
				
			</div>
		</div>

		<div class="woogool-individual-field-wrap">
			<label for="enable-product-variation" class="woogool-label">Enable product variations</label>
			<div class="field-action-wrap">
				<input v-if="is_pro()" id="enable-product-variation" type="checkbox" v-model="header.activeVariation" class="woogool-field">
			</div>
			<span v-if="!is_pro()">This feature is available for <a target="_blank" href="http://wpspear.com/product-feed/">pro version</a></span>
		</div>

		<div class="woogool-individual-field-wrap">
			<label for="feed-by-category" class="woogool-label">Feed by category</label>
			<div class="field-action-wrap">
				<input id="feed-by-category" type="checkbox" v-model="header.feedByCatgory" class="woogool-field">
			</div>
		</div>


		<div v-if="header.feedByCatgory" class="woogool-individual-field-wrap">
			<label class="woogool-label">Feed by category</label>
			<div class="field-action-wrap">
				<vue-woogool-multiselect 
					class="header-multiselect"
	                v-model="header.categories" 
					:options="categories" 
	                :multiple="true"
	                :close-on-select="true"
	                :clear-on-select="true"
	                :show-labels="true"
	                :searchable="true"
	                placeholder="Select Category"
	                select-label=""
	                selected-label="selected"
	                deselect-label=""
	                label="catName"
	                track-by="catId"
	                :allow-empty="true">
						
				</vue-woogool-multiselect>
			</div>
		</div>

		<div v-if="hasGoogleCategoryMaping()" class="woogool-individual-field-wrap">
			<label class="woogool-label">Category Maping</label>
			<div class="field-action-wrap">
				<vue-woogool-multiselect 
					class="header-multiselect"
	                v-model="header.googleCategories" 
					:options="categories" 
	                :multiple="true"
	                :close-on-select="true"
	                :clear-on-select="true"
	                :show-labels="true"
	                :searchable="true"
	                placeholder="Category maping"
	                select-label=""
	                selected-label="selected"
	                deselect-label=""
	                label="catName"
	                track-by="catId"
	                :allow-empty="true">
						
				</vue-woogool-multiselect>
			</div>
		</div>

		<div v-for="(catElement, index) in header.googleCategories" :key="index" class="woogool-individual-field-wrap">
			<label class="woogool-label">{{ catElement.catName }}</label>
			<div class="field-action-wrap">
				
				<vue-woogool-multiselect
					class="header-multiselect"
					v-model="catElement.googleCat"
					:options="googleCategories" 
	                :multiple="false"
	                :close-on-select="true"
	                :clear-on-select="true"
	                :show-labels="true"
	                :searchable="true"
	                @input="setGoogleCat(catElement, $event)"
	                placeholder="Category maping"
	                select-label=""
	                selected-label="selected"
	                deselect-label=""
	                label="label"
	                track-by="id"
	                
	                :allow-empty="true">
						
				</vue-woogool-multiselect>
				<span class="help-text">Google category for the {{ catElement.catName.toLowerCase() }} item</span>
			</div>
		</div>

		<!-- <div class="woogool-individual-field-wrap">
			<label for="" class="woogool-label">Refresh interval</label>
			<div class="field-action-wrap">
				<select v-model="header.refresh">
					<option value="1">Daily</option>
					<option value="2">Hourly</option>
					<option value="3">Weekly</option>
					<option value="4">Monthly</option>
				</select>
			</div>
		</div> -->

	</div>
</template>

<style lang="less">
	.woogool-feed-step-1 {
		padding: 10px;
   		padding-top: 18px;

		.header-next-btn-wrap {
			float: left;
		}

		.woogool-individual-field-wrap {
			display: flex;
			align-items: center;
			margin-bottom: 20px;
			&:last-child {
				margin-bottom: 0;
			}
			.help-text {
				font-style: italic;
    			font-size: 12px;
			}

			.feed-name-field {
				width: 380px;
			    height: 32px;
			    padding: 7px;
			}
			.woogool-label {
				width: 250px;
				font-size: 14px;
			}
			.header-multiselect {
				width: 380px;
				min-height: auto;
				
				.multiselect__select {
					display: none;
				}
				.multiselect__input {
					border: none;
					box-shadow: none;
					margin: 0;
					font-size: 14px;
				}
				.multiselect__element {
					.multiselect__option {
						font-weight: normal;
						white-space: normal;
						padding: 6px 12px;
						line-height: 25px;
						font-size: 14px;
					}
					
				}
				.multiselect__tags {
				    min-height: auto;
				    padding: 3px;
				    border-color: #ddd;
				    border-radius: 3px;

				    .multiselect__tag {
				    	margin-bottom: 0;
				    	overflow: visible;
				    	border-radius: 3px;
				    }
				}
			}
		}
	}

</style>

<script>
	import Mixin from '@components/new-feed/mixin'
	import Channels from '@components/new-feed/common/country-channel.js'

	export default {
		mixins: [Mixin],
		props: {
			extAttr: {
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
			header: {
				type: [Object],
				default () {
					return {}
				}
			},
		},

		data () {
			return {
				categories: [],
				googleCategories: [],
				countries: [],
				defaultChannel:{
                    label: 'Google Shopping',
                    id: 'google_shopping'
				},
				allCountries: [
	                {
	                    label: 'Google Shopping',
	                    id: 'google_shopping'
	                },
	                {
	                    label: 'Google Merchant Promotion Feed',
	                    id: 'google_shopping_promotion'
	                },
	                {
	                    label: 'Google Local Products',
	                    id: 'google_local'
	                },
	                // {
	                //     label: 'Google Products Inventory',
	                //     id: 'google_inventory'
	                // },
	                // {
	                //     label: 'Google Remarketing - DRM',
	                //     id: 'google_drm'
	                // },
	                {
	                    label: 'Facebook Ads',
	                    id: 'facebook_ads'
	                },
	                {
	                    label: 'Bing Shopping',
	                    id: 'bing_shopping'
	                },
	            ],
            	channels: [],
			}
		},

		components: {
			
		},

		created () {

			var self = this;
			this.setDefaultChannel();
			
			this.googleCategories = woogool_multi_product_var.google_categories;

		

			jQuery.each(woogool_multi_product_var.product_categories, function(index, cat) {
				self.categories.push({
					'catId': index,
					'catName': cat
				});
			});

			jQuery.each(woogool_var.countries, function(key, country) {
				self.countries.push({
					id: key,
					label: country
				});
			})
		},

		methods: {
			hasGoogleCategoryMaping () {
				var noMap = [
					'google_shopping', 
					'google_shopping_promotion', 
					'google_local', 
					'facebook_ads', 
					'bing_shopping'
				];

				var channelID = this.header.channel.id;
				
				if(noMap.indexOf(channelID) != -1) {
					return true;
				}

				return false;
			},
			isUpdateMode () {
				let feedId = parseInt(this.$route.params.feed_id);
				
				if(isNaN(feedId)) {
					return false;
				}

				return true;
			},
			changeChannel () {
				
			},
			submit () {
				var args = {
					header: this.header,
                	contentAttrs: this.contentAttrs,
                	
					callback (res) {

					}
				}
				
				this.newFeed(args);
			},
			setGoogleCat (cat, googleCat) {
				cat['googleCat'] = googleCat;
			},

			onChangeCountry (country) {
				this.getChannelByCountry(country);

				this.header.channel = {
                    label: 'Google Shopping',
                    id: 'google_shopping'
				}
			},
			setDefaultChannel () {
	            var self = this;
	            self.channels = [];

	            this.allCountries.forEach(function(channel) {
	                self.channels.push(channel);
	            });
	        },

	        getChannelByCountry (country) {
	            var self = this;

	            this.setDefaultChannel();
	            let id = country.id;

	            if( typeof Channels[id] == 'undefined' ) {
	                return;
	            }

	            Channels[id].forEach(function(channel) {
	                self.channels.push(channel);
	            });

	        },

	        onChangeChannel () {
	        	

	       	}
	
		}
	}
</script>