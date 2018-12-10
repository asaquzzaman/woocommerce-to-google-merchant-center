woogool.Vue.directive('woogool-slide-up-down', {
	inserted: function(el) {
		var node = jQuery(el);
		
		if (node.is(':visible')) {
			node.slideUp(400);
		} else {
			node.slideDown(400);
		}
		
	},
});


woogool.Vue.directive('woogool-pretty-photo', {
	inserted: function(el) {
		var node = jQuery(el);
		
		node.prettyPhoto({
			allow_resize: true,
			social_tools: '',
			allow_expand: true,
			deeplinking: false,
		} );
		
	},
});

woogool.Vue.directive('woogool-tooltip', {
	inserted: function(el) {
		jQuery(el).tipTip();
	},
});

woogool.Vue.directive('woogool-chosen-google-categories', {
	inserted: function(el, binding, vnode) {
		jQuery(el)
			.chosen({ width: '300px' })
            .change(function(change, change_val ) {

            });
		},
});


woogool.Vue.directive('woogool-chosen', {
	inserted: function(el, binding, vnode) {
		jQuery(el)
			.chosen({ width: '300px' })
            .change(function(change, change_val ) {
                vnode.context.chosenChange(change, change_val);
            });
		},
});






