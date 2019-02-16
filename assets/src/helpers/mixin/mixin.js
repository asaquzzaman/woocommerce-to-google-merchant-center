export default {
	methods: {

        httpRequest (property) {

            return jQuery.ajax(property);
        },

		/**
         * Get index from array object element
         *
         * @param   itemList
         * @param   id
         *
         * @return  int
         */
        getIndex  ( itemList, id, slug) {
            var index = false;

            jQuery.each(itemList, function(key, item) {
        
                if (item[slug] == id) {
                    index = key;
                }
            });

            return index;
        },

        ucfirst (word) {
            return word.replace(/\w/, c => c.toUpperCase())
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

                    // if(typeof args.callback === 'function') {
                    //     args.callback(res);
                    // }

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
                    } else {
                        if(typeof self.isActiveSpinner !== 'undefined') {
                            self.isActiveSpinner = false;
                        }
                    }
                    if( typeof args.callback === 'function' ) {
                        args.callback(res);
                    }

                    // if( 
                    //  request.data.page >= self.loopLimit
                    //  &&
                    //  res.data.fetch_all_product !== true 
                    // ) {
                    //  self.loopStart = parseInt(self.loopLimit) + 1;
                    //  self.loopLimit = parseInt(self.loopLimit) + parseInt(woogool_multi_product_var.request_amount);
                        
                    //  self.feedLoop(args);
                    // }
                },
            };
            self.httpRequest(request);

            // for (var i = self.loopStart; i <= self.loopLimit; i++) {
            //  request.data.page = i;
            //  self.httpRequest(request);
            // }
        },
	}
}