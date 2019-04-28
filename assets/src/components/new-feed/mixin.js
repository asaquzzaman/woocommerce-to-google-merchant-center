

export default {
	data () {
		return {
            feed_id: false,

			loopLimit: woogool_multi_product_var.request_amount,
			loopStart: 1,
            

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
		
	},
	methods: {
        cancel () {
            this.$router.push({
                name: 'feed_lists'
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
            if(this.validate(step)) {
                this.stage.step = step;
            }
		},

        validate (step) {
            if(step != 'second') {
                return true;
            }

            if(this.header.name == '') {
                alert('Feed name required!');

                return false;
            }

            if(jQuery.isEmptyObject(this.header.country)) {
                alert('Please select your country!');

                return false;
            }

            return true;
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