export default {
	data () {
		return {
			'stage': {
				step: 'first',
			},
			loopLimit: woogool_multi_product_var.request_amount,
			loopStart: 1
		}
	},
	watch: {
		stage: {
			handler (stage) {
				window.localStorage.setItem('woogoolStageStep', stage.step);
			},

			deep: true
		}
	},
	created () {
		var step = localStorage.getItem('woogoolStageStep');

		if(step) {
			this.stage.step = step;
		}
	},
	methods: {
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

		createXmlFile (args) {
			var self = this;
			var request = {
                type: 'POST',
                url: woogool_var.ajaxurl,
                data: args.data,

                success (res) {
                    if( typeof args.callback !== 'undefined' ) {
                        args.callback(self, res);
                    }
                },
            };

            self.httpRequest(request);
		},

		generateFeedFile (args) {
			var self = this;

            this.createXmlFile({ 
        		data: {
        			feed_id: args.data.feed_id,
        			feed_title: args.data.feed_title,	
        			action: 'woogool-create-xml-file',
			        _wpnonce: woogool_var.nonce,
        		},
        		
        		callback ($this, res) {

        			if(res.success === false) {
		        		return;
		        	}
        			self.feedLoop(args);
        		}
            });
		},

		feedLoop (args) {
			var self = this;

			var pre_define = {
	                data: {
	                	feed_id: false,
	                  	action: 'woogool-generate-feed-file',
                        offset: 0,
	                	_wpnonce: woogool_var.nonce,
	                },
	                callback: false,
	            };

            args = jQuery.extend(true, pre_define, args );
            
			var request = {
                type: 'POST',
                url: woogool_var.ajaxurl,
                data: args.data,

                success (res) {
                	
                    if(res.data.has_product) {
                        args.data.offset = res.data.offset;
                        self.feedLoop(args);
                    }
                    // if( typeof args.callback === 'function' ) {
                    //     args.callback( self,  res );
                    // }

                    // if( 
                    // 	request.data.page >= self.loopLimit
                    // 	&&
                    // 	res.data.fetch_all_product !== true 
                    // ) {
                    // 	self.loopStart = parseInt(self.loopLimit) + 1;
                    // 	self.loopLimit = parseInt(self.loopLimit) + parseInt(woogool_multi_product_var.request_amount);
                    	
                    // 	self.feedLoop(args);
                    // }
                },
            };
            self.httpRequest(request);

            // for (var i = self.loopStart; i <= self.loopLimit; i++) {
            // 	request.data.page = i;
            // 	self.httpRequest(request);
            // }
		},
	}
}