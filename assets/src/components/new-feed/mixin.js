export default {
	data () {
		return {
			stage: {
				step: 'first',
			},
			loopLimit: woogool_multi_product_var.request_amount,
			loopStart: 1
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