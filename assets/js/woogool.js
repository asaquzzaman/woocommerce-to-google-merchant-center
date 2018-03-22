;(function($) {
    var WOOGOOL = {
        init: function() {

            $('.woogool').on( 'click', '.woogool-more-field', this.addMore );
            $('.woogool').on( 'click', '.woogool-remove-more', this.removeMore );
            $('.woogool .woogool-form-product').on( 'submit',  this.formValidation );
            $('.woogool').on( 'click', '.woogool-product-field-addMore', this.addMoreGroup );
            $('.woogool').on( 'click', '.woogool-product-field-remove', this.removeMoreGroup );
            $('.woogool-delete-product').on('click', this.deleteProduct);
            $('.woogool').on( 'change', '.product_id', this.changeProduct );
            $('.woogool').on( 'change', '.woogool-all-product-checkbox-feed', this.allProductHide );
            $('#woogool-feed-metabox-wrap').on('change', '.woogool-all-product-checkbox', this.feedDefault );
            $('.woogool').on( 'change', '.woogool-target-country-drop', this.targetCountry );

            this.chosen();
            this.allProductHide();
            this.datePicker();
            this.feedDefault();
            this.initTipTip();
            this.googleCatSet();
        },

        initTipTip: function() {
            // $( 'body .woogool-help-tip' ).tipTip( {
            //     defaultPosition: "top",
            //     fadeIn: 100,
            //     fadeOut: 100,
            //     class: 'woogool-feed-toltip'
            // } );
        },

        newFeed: function(e) {
            e.preventDefault();
            
            var self = $(this),
                count = self.find('.woogool-count');

            self.find('.woogool-new-feed-btn').prop('disabled', true);
            self.find('.woogool-spinner').show();
            
            wp.ajax.send('woogool-new-feed', {
                data: {
                    form_data: self.serialize(),
                    _wpnonce: woogool_var.nonce 
                },
                success: function(res) {
                    if ( res.woogool_continue === true ) {
                        var number = parseInt( count.text() ) + parseInt( res.count );
                        count.html( number );
                        WOOGOOL.feedContinue(res);
                    } else {
                        window.location.href = res.redirect;
                    }
                },
                error: function() {
                    self.find('.woogool-new-feed-btn').prop('disabled', false);
                    self.find('.woogool-spinner').hide();
                }
            });
        },

        feedContinue: function(res) {
            var count = $('.woogool-feed-form').find('.woogool-count');
            
            wp.ajax.send('woogool-new-feed-continue', {
                data: {
                    form_data: res,
                    _wpnonce: woogool_var.nonce 
                },
                success: function(res) {
                    if ( res.woogool_continue === true ) {
                        var number = parseInt( count.text() ) + parseInt( res.count );
                        count.html( number );
                        WOOGOOL.feedContinue(res);
                    } else {
                        window.location.href = res.redirect;
                    }
                },
                error: function() {
                    self.find('.woogool-new-feed-btn').prop('disabled', false);
                    self.find('.woogool-spinner').hide();
                }
            });
        },

        targetCountry: function(e) {
            e.preventDefault();
            
            var self = $(this),
                val  = self.val(),
                country = jQuery.parseJSON( woogool_var.country_details );
            
            if ( val == '-1' ) {
                $('.woogool-content-language').val('-1').closest('.woogool-hidden').hide();
                $('.woogool-currency-field').val( ' ' ).closest('.woogool-hidden').hide();
                return;
            }
            
            $.each( country, function( key, value ) {

                if ( key == val ) {
                    var language_code = value.language_code,
                        currency = value.currency_code;
                    
                    $('.woogool-content-language').val( language_code ).closest('.woogool-hidden').show();
                    $('.woogool-currency-field').val( currency ).closest('.woogool-hidden').show();
                }
            });

            
        },

        feedDefault: function() {
            var check = $('.woogool-all-product-checkbox');
            $.each( check, function( key, val ) {
                if ( $(val).prop('checked') ) {
                    $(val).closest('.woogool-form-field').siblings('.woogool-form-field').hide();
                } else {
                   $(val).closest('.woogool-form-field').siblings('.woogool-form-field').show();
                }
            });
        },

        datePicker: function() {
            $('.woogool-date-picker').datepicker({
                dateFormat: "yy-mm-dd",
                changeYear: true,
                changeMonth: true,
                numberOfMonths: 1,
            });
        },
        allProductHide: function() {
            var self = $('.woogool-all-product-checkbox-feed'),
                self_val = self.val();

            if ( self_val === 'all' ) {
                $('.woogool-product-chosen-field-wrap').hide();
                $('.woogool-product-category-chosen-field-wrap').hide();
            }

            if ( self_val === 'individual' ) {
                $('.woogool-product-chosen-field-wrap').show();
                $('.woogool-product-category-chosen-field-wrap').hide();
            }

            if ( self_val === 'category' ) {
                $('.woogool-product-chosen-field-wrap').hide();
                $('.woogool-product-category-chosen-field-wrap').show();
            }
        },
        chosen: function() {

            $('.woogool .woogool-chosen')
                .chosen({ width: '300px' })
                .change(function(change, change_val ) {

                    if( change_val.deselected && $(change.target).hasClass('woogool-google-cat') ) {
                        WOOGOOL.categoryRemove( $(change.target), change_val );
                        WOOGOOL.catVisibleStatus();
                    } 

                    if ( change_val.selected && $(change.target).hasClass('woogool-google-cat') ) {
                        WOOGOOL.categoryMap( $(change.target), change_val );
                        WOOGOOL.catVisibleStatus();
                    }
                });

        },

        catVisibleStatus: function() {
            var wrap = $('.woogool-category-map-wrap'),
                li   = wrap.find('.woogool-cat-map-li');

            if ( li.length ) {
                wrap.show();
            } else {
                wrap.hide();
            }
        },

        categoryRemove: function( self, deselectd_val ) {
            var name = 'cat_map['+deselectd_val.deselected+']'; 
           
            $('input[name="'+name+'"]').closest('.woogool-cat-map-li').remove();
        },

        categoryMap: function( self, selectd_val ) {
            var cat_text = self.find('option[value="'+selectd_val.selected+'"]').text(),
                cat_field = $('#woogool-hidden-field').find('.woogool-cat-map-li').clone();
            
            cat_field.find('.woogool-cat-title').text(cat_text);
            cat_field.find('.woogool-cat-map-field').attr('name', 'cat_map['+selectd_val.selected+']');
            cat_field.find('.woogool-cat-select').addClass('woogool-chosen-custom');
                

            $('.woogool-category-map-wrap').find('.woogool-google-cat-ul').append(cat_field);
            
            WOOGOOL.googleCatSet();
              
        },

        googleCatSet: function() {
            $('.woogool .woogool-chosen-custom')
                .chosen({ width: '300px' })
                .change(function(ele, val) {
                    var li = $(this).closest('.woogool-cat-map-li');
                    li.find('.woogool-cat-map-field').attr('value', val.selected);
                });
        },

        changeProduct: function() {
            var self = $(this),
                data = {
                    product_id : self.val(),
                    action : 'change_product',
                    _wpnonce: woogool_var.nonce
                };

            $.post( woogool_var.ajaxurl, data, function( res ) {
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
                    _wpnonce: woogool_var.nonce
                };

            $.post( woogool_var.ajaxurl, data, function( res ) {
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
                wrap = self.closest('.woogool-form-field').parent('.woogool-form-field'),
                remove_wrap = wrap.find( '.woogool-product-field-child-wrap' );
            if ( remove_wrap.length > 1 ) {
                remove_wrap.last().remove();
            }
        },

        addMoreGroup: function(e) {
            e.preventDefault();
            var self = $(this),
                wrap = self.closest('.woogool-form-field').parent('.woogool-form-field'),
                length = wrap.find('.woogool-product-field-child-wrap').length,
                current_lenght = length - 1;
                clone_wrap = wrap.find( '.woogool-product-field-child-wrap' ).last(),
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
            validate = WOOGOOL.formValidator( form );
            if( ! validate ) {
                return false;
            }
            var spinner = form.find('.woogool-spinner-wrap');
            spinner.addClass('woogool-spinner');
            $.post( woogool_var.ajaxurl, submited_data, function(res) {
                spinner.removeClass('woogool-spinner');

                if ( res.success ) {
                    $('.woogool-submit-notification')
                        .addClass('updated')
                        .removeClass('error')
                        .html('<div class="woogool-success"><strong>'+res.data.success_msg+'</strong></div>');

                    $('body,html').animate({scrollTop: 10 }, 'slow');
                } else {
                    if ( res.data.authentication_fail ) {
                        location.reload();
                    } else {
                        $('.woogool-submit-notification').addClass('updated error')
                            .html(
                                '<div class="woogool-error-code">Error code : '+res.data.error_code+'</div>'+
                                '<div class="error-message">Error message : '+res.data.error_msg+'</div>'
                            );
                        $('body,html').animate({scrollTop: 10 }, 'slow');
                    }
                }
            });

            return false;
        },

        formValidator: function( form ) {
            var required = form.find('[data-woogool_validation="1"]'),
                validate = true,
                scroll_selector = [];

            form.find('.woogool-notification').remove();

            $.each( required, function( key, field ) {
                var self = $(field),
                    field_wrap = self.closest('.woogool-form-field'),
                    has_dependency = self.data('woogool_dependency');

                if ( has_dependency ) {
                    var dependency_handelar = form.find('[data-'+has_dependency+']'),
                        dependency_handelar_val = dependency_handelar.data(has_dependency);

                    if( dependency_handelar_val == 'checked' ) {
                        if ( !$(dependency_handelar).is(':checked') ) {
                            return;
                        }
                    }
                }

                if ( self.is('select') && self.data('woogool_required') && self.val() === '-1' ) {
                    validate = false;
                    field_wrap.find('.woogool-notification').remove();
                    field_wrap.append('<div class="woogool-notification">'+self.data('woogool_required_error_msg')+'</div>');
                    scroll_selector.push(self);
                }

                if( self.data('woogool_required') && ( self.val() === '' || self.val() === null ) ) {
                    validate = false;
                    field_wrap.find('.woogool-notification').remove();
                    field_wrap.append('<div class="woogool-notification">'+self.data('woogool_required_error_msg')+'</div>');
                    scroll_selector.push(self);
                }

                if ( validate && self.data('woogool_email') ) {
                    validate = woogoolGeneral.validateEmail( self.val() );
                    if ( validate === false ) {
                        field_wrap.find('.woogool-notification').remove();
                        field_wrap.append('<div class="woogool-notification">'+self.data('woogool_email_error_msg')+'</div>');
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
            self.closest('.woogool-form-field').remove();
        },

        addMore: function(e) {
            e.preventDefault();
            var self = $(this),
                self_wrap = self.closest('.woogool-form-field'),
                name = self_wrap.find( 'input, select, textare' ).data('field_name'),
                clone = self_wrap.clone(),
                remove_icon = '<i class="woogool-remove-more">-</i>',
                remove_icon_length = $(clone).find('.woogool-remove-more').length,
                append_field = ( remove_icon_length === 0 ) ? $(clone).find('.woogool-more-field').after(remove_icon) : '',

                all_name = clone.find('input, textare, select').attr( 'name', name );

            self_wrap.after(clone);
        },
    }
    WOOGOOL.init();

})(jQuery);