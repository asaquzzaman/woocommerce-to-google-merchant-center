export default {
	data () {
		return {
			stage: {
				step: 'first',
			},
			loopLimit: woogool_multi_product_var.request_amount,
			loopStart: 1,
            channels: [
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
            ]
		}
	},
	watch: {
		stage: {
			handler (stage) {
				//window.localStorage.setItem('woogoolStageStep', stage.step);
			},

			deep: true
		}
	},
	created () {
		// var step = localStorage.getItem('woogoolStageStep');

		// if(step) {
			//this.stage.step = step;
		//}
	},
	methods: {
        changeChannel (channel) {
            if(channel.id == 'google_shopping') {
                this.gotoGoogleShopping();
            }

            if(channel.id == 'facebook_ads') {
                this.gotoFacebookAds();
            }

            if(channel.id == 'bing_shopping') {
                this.gotoBingShopping();
            }

            if(channel.id == 'google_shopping_promotion') {
                this.gotoGoogleShoppingPromotion();
            }

            if(channel.id == 'google_local') {
                this.gotoGoogleLocal();
            }

            if(channel.id == 'google_drm') {
                this.gotoGoogleDRM();
            }

            if(channel.id == 'google_inventory') {
                this.gotoGoogleInventory();
            }
        },
        gotoGoogleLocal () {
            this.$router.push({
                name: 'google_local'
            });
        },
        gotoGoogleDRM () {
            this.$router.push({
                name: 'google_drm'
            });
        },
        gotoGoogleInventory () {
            this.$router.push({
                name: 'google_inventory'
            });
        },
        gotoBingShopping () {
            this.$router.push({
                name: 'bing_shopping'
            });
        },
        gotoGoogleShopping () {
            this.$router.push({
                name: 'google_shopping'
            });
        },
        gotoFacebookAds () {
            this.$router.push({
                name: 'facebook_ads'
            });
        },
        gotoGoogleShoppingPromotion () {
            this.$router.push({
                name: 'google_shopping_promotion'
            });
        },
		newFeed (args) {
			var self = this,
            pre_define = {
                data: {
                	feed_id: false,
                  	action: 'woogool-new-feed',
                	_wpnonce: woogool_var.nonce,
                },
                callback: false,
            },
            args = jQuery.extend(true, pre_define, args );

			var request = {
                type: 'POST',
                url: woogool_var.ajaxurl,
                data: args.data,
                // data: {
                // 	action: 'woogool-new-feed',
                // 	_wpnonce: woogool_var.nonce,
                // 	header: this.header,
                // 	contentAttrs: this.contentAttrs
                // },
                success (res) {
                    if( typeof args.callback === 'function' ) {
                        args.callback.call( self,  res );
                    }
                },
            };

            this.httpRequest(request);
		},
        
		changeStage (step) {
			this.stage.step = step;
		},

		setBoolen (value) {
			if(value.toLowerCase() === 'true') {
				return true;
			}

			if(value.toLowerCase() === 'false') {
				return false;
			}

			return '';
		},

        addMappingField () {
            this.gAttrs.push({
                'type': 'mapping',
                'format': 'required'
            });
        },

        addCustomField () {
            this.gAttrs.push({
                'type': 'custom',
                'format': 'required'
            });
        },

        addFields (type) {
            var filter = {
                type: type,
                if_cond: 'id',
                condition: 'condition',
                value: '',
                then: 'exclude',
                is: ''
            }

            this.logic.push(filter);
        },
	}
}