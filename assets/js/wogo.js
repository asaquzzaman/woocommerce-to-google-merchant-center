;(function($) {
    var WOGO = {
        init: function() {

            $('.wogo-form').on( 'click', '.wogo-more-field', this.addMore );
            $('.wogo-form').on( 'click', '.wogo-remove-more', this.removeMore );
            $('.wogo-form-product').on( 'submit',  this.formValidation );
            $('.wogo-form').on( 'click', '.wogo-product-field-addMore', this.addMoreGroup );
            $('.wogo-form').on( 'click', '.wogo-product-field-remove', this.removeMoreGroup );
            $('.wogo-delete-product').on('click', this.deleteProduct);
            $('.wogo-form').on( 'change', '.product_id', this.changeProduct );
        },

        changeProduct: function() {
            var self = $(this),
                data = {
                    product_id : self.val(),
                    action : 'change_product',
                    _wpnonce: wogo_var.nonce
                };

            $.post( wogo_var.ajaxurl, data, function( res ) {
                if ( res.success ) {
                    window.location.href = res.data.url;
                }
            });
        },

        deleteProduct: function(e) {
            e.preventDefault();
            if ( !confirm( 'Are you sure?' ) ) {
                return;
            }
            var self = $(this),
                data = {
                    merchant_product_id : self.data('merchant_product_id'),
                    merchant_id : self.data('merchant_id'),
                    post_id: self.data('post_id'),
                    action : 'delete_product',
                    _wpnonce: wogo_var.nonce
                };

            $.post( wogo_var.ajaxurl, data, function( res ) {
                if ( res.success ) {
                    alert( res.data.success_msg );
                    location.reload()
                } else {
                    window.location.href = res.data.url;
                }
            });
        },

        removeMoreGroup: function(e) {
            e.preventDefault();
            var self = $(this),
                wrap = self.closest('.wogo-form-field').parent('.wogo-form-field'),
                remove_wrap = wrap.find( '.wogo-product-field-child-wrap' );
            if ( remove_wrap.length > 1 ) {
                remove_wrap.last().remove();
            }
        },

        addMoreGroup: function(e) {
            e.preventDefault();
            var self = $(this),
                wrap = self.closest('.wogo-form-field').parent('.wogo-form-field'),
                length = wrap.find('.wogo-product-field-child-wrap').length,
                current_lenght = length - 1;
                clone_wrap = wrap.find( '.wogo-product-field-child-wrap' ).last(),
                clone = clone_wrap.clone(),
                all_name = clone.find('input, textare, select');

            $.each( all_name, function( index, value ) {
                var this_val = $(value),
                    name = this_val.attr('name'),
                    new_name = name.replace('['+current_lenght+']', '['+length+']');
                this_val.attr('name', new_name );
            });

            clone_wrap.after(clone);
        },

        formValidation: function(e) {
            e.preventDefault();
            var form = $(this),
                submited_data = form.serialize().replace(/[^&]+=&/g, '').replace(/&[^&]+=$/g, '');
            validate = WOGO.formValidator( form );
            if( ! validate ) {
                return false;
            }
            var spinner = form.find('.wogo-spinner-wrap');
            spinner.addClass('wogo-spinner');
            $.post( wogo_var.ajaxurl, submited_data, function(res) {
                spinner.removeClass('wogo-spinner');

                if ( res.success ) {
                    $('.wogo-submit-notification')
                        .addClass('updated')
                        .removeClass('error')
                        .html('<div class="wogo-success"><strong>'+res.data.success_msg+'</strong></div>');

                    $('body,html').animate({scrollTop: 10 }, 'slow');
                } else {
                    if ( res.data.authentication_fail ) {
                        location.reload();
                    } else {
                        $('.wogo-submit-notification').addClass('updated error')
                            .html(
                                '<div class="wogo-error-code">Error code :'+res.data.error_code+'</div>'+
                                '<div class="error-message">Error message: '+res.data.error_msg+'</div>'
                            );
                        $('body,html').animate({scrollTop: 10 }, 'slow');
                    }
                }
            });

            return false;
        },

        formValidator: function( form ) {
            var required = form.find('[data-wogo_validation="1"]'),
                validate = true,
                scroll_selector = [];

            form.find('.wogo-notification').remove();

            $.each( required, function( key, field ) {
                var self = $(field),
                    field_wrap = self.closest('.wogo-form-field'),
                    has_dependency = self.data('wogo_dependency');

                if ( has_dependency ) {
                    var dependency_handelar = form.find('[data-'+has_dependency+']'),
                        dependency_handelar_val = dependency_handelar.data(has_dependency);

                    if( dependency_handelar_val == 'checked' ) {
                        if ( !$(dependency_handelar).is(':checked') ) {
                            return;
                        }
                    }
                }

                if( self.data('wogo_required') && ( self.val() === '' || self.val() === null ) ) {

                    validate = false;
                    field_wrap.find('.wogo-notification').remove();
                    field_wrap.append('<div class="wogo-notification">'+self.data('wogo_required_error_msg')+'</div>');
                    scroll_selector.push(self);
                }

                if ( validate && self.data('wogo_email') ) {
                    validate = wogoGeneral.validateEmail( self.val() );
                    if ( validate === false ) {
                        field_wrap.find('.wogo-notification').remove();
                        field_wrap.append('<div class="wogo-notification">'+self.data('wogo_email_error_msg')+'</div>');
                        scroll_selector.push(self);
                    }
                }
            });

            if( ! validate ) {
                $('body,html').animate({scrollTop: scroll_selector[0].offset().top - 100});
            }

            return validate;
        },

        removeMore: function(e) {
            e.preventDefault();
            var self = $(this);
            self.closest('.wogo-form-field').remove();
        },

        addMore: function(e) {
            e.preventDefault();
            var self = $(this),
                self_wrap = self.closest('.wogo-form-field'),
                name = self_wrap.find( 'input, select, textare' ).data('field_name'),
                clone = self_wrap.clone(),
                remove_icon = '<i class="wogo-remove-more">-</i>',
                remove_icon_length = $(clone).find('.wogo-remove-more').length,
                append_field = ( remove_icon_length === 0 ) ? $(clone).find('.wogo-more-field').after(remove_icon) : '',

                all_name = clone.find('input, textare, select').attr( 'name', name );

            self_wrap.after(clone);
        },
    }
    WOGO.init();

})(jQuery);