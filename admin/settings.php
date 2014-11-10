<?php
/**
 * All kinds of form field are generator
 */
class WOGO_Admin_Settings {
	private static $_instance;

    /**
     * Class instantiate
     * @return object
     */
    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new WOGO_Admin_Settings();
        }

        return self::$_instance;
    }

    /**
     * Generate form select field
     * @param  string $name
     * @param  array $element
     * @return string
     */
	function select_field( $name, $element ) {

        $extra                  = '';
        $element['id']          = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $element['class']       = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $element['disabled']    = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $element['extra']       = isset( $element['extra'] ) ? $element['extra'] : array();
        $element['label']       = isset( $element['label'] ) ? $element['label'] : '';
        $element['option']      = isset( $element['option'] ) ? $element['option'] : array();
        $element['selected']    = isset( $element['selected'] ) ? $element['selected'] : '';
        $element['desc']        = isset( $element['desc'] ) ? $element['desc'] : '';
        $element['action_hook'] = isset( $element['action_hook'] ) ? $element['action_hook'] : '';
        $element['required']    = ( isset( $element['extra']['data-wogo_required'] ) &&  ( $element['extra']['data-wogo_required'] === true ) ) ? '*' : '';

        if( is_array( $element['extra'] ) && count( $element['extra'] ) ) {
            foreach( $element['extra'] as $key => $action ) {
                $extra .= esc_attr( $key ) .'="'. esc_attr( $action ).'" ';
            }
        }

        $html = sprintf( '<label for="%1s">%2s<em>%3s</em></label>', $element['id'], $element['label'], $element['required'] );
        $html .= sprintf( '<select class="%1$s" name="%2$s" id="%3$s" %4$s %5$s>', $element['class'], $name, $element['id'], $element['disabled'], $extra );
        foreach ( $element['option'] as $key => $label ) {
            $html .= sprintf( '<option value="%1$s" %2$s >%3$s</option>', esc_attr( $key ), selected( $element['selected'], $key, false ), esc_attr( $label ) );
        }

        $html .= sprintf( '</select>' );
        $html .= sprintf( '<span class="wogo-clear"></span><span class="description"> %s</span>', $element['desc'] );

        ob_start();
        $this->wrap_start( $element );
       	echo '<div id="wogo-select" class="wogo-form-field">';
        echo $html;

        //do_action( 'wogo_select_' . $element['action_hook'] );
        echo '</div>';
        $this->wrap_close( $element );
        return ob_get_clean();
    }

    /**
     * Multiple select form field generator
     * @param  string $name
     * @param  array $element
     * @return string
     */
    function multiple_select_field( $name, $element ) {

        $extra                  = '';
        $element['id']          = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $element['class']       = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $element['disabled']    = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $element['extra']       = isset( $element['extra'] ) ? $element['extra'] : array();
        $element['label']       = isset( $element['label'] ) ? $element['label'] : '';
        $element['option']      = isset( $element['option'] ) ? $element['option'] : array();
        $element['selected']    = isset( $element['selected'] ) ? $element['selected'] : '';
        $element['desc']        = isset( $element['desc'] ) ? $element['desc'] : '';
        $element['action_hook'] = isset( $element['action_hook'] ) ? $element['action_hook'] : '';
        $element['required']    = ( isset( $element['extra']['data-wogo_required'] ) &&  ( $element['extra']['data-wogo_required'] === true ) ) ? '*' : '';

        if( is_array( $element['extra'] ) && count( $element['extra'] ) ) {
            foreach( $element['extra'] as $key => $action ) {
                $extra .= esc_attr( $key ) .'="'. esc_attr( $action ).'" ';
            }
        }

        $html = sprintf( '<label for="%1s">%2s<em>%3s</em></label>', $element['id'], $element['label'], $element['required'] );
        $html .= sprintf( '<select multiple class="%1$s" name="%2$s" id="%3$s" %4$s %5$s>', $element['class'], $name, $element['id'], $element['disabled'], $extra );
        foreach ( $element['option'] as $key => $label ) {
            $html .= sprintf( '<option value="%1$s" %2$s >%3$s</option>', esc_attr( $key ), selected( $element['selected'], $key, false ), esc_attr( $label ) );
        }

        $html .= sprintf( '</select>' );
        $html .= sprintf( '<span class="wogo-clear"></span><span class="description"> %s</span>', $element['desc'] );

        ob_start();
        $this->wrap_start( $element );
        echo '<div id="wogo-multi-select" class="wogo-form-field">';
        echo $html;

        //do_action( 'wogo_select_' . $element['action_hook'] );
        echo '</div>';
        $this->wrap_close( $element );
        return ob_get_clean();
    }

    /**
     * Text form field generator
     * @param  string $name
     * @param  array $element
     * @return string
     */
    function text_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $extra               = '';
        $element_id          = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $element_class       = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $element_disabled    = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $element_extra       = isset( $element['extra'] ) ? $element['extra'] : array();
        $element_label       = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $element_desc        = isset( $element['desc'] ) ? $element['desc'] : '';
        $element_value       = isset( $element['value'] ) ? esc_attr( $element['value'] ) : '';
        $element_placeholder = isset( $element['placeholder'] ) ? esc_attr( $element['placeholder'] ) : '';
        $element_type        = isset( $element['type'] ) ? esc_attr( $element['type'] ) : 'text';
        $element_required    = ( isset( $element['extra']['data-wogo_required'] ) &&  ( $element['extra']['data-wogo_required'] === true ) ) ? '*' : '';

        if( is_array( $element_extra ) && count( $element_extra ) ) {
            foreach( $element_extra as $key => $action ) {
                $extra .= esc_attr( $key ) .'="'. esc_attr( $action ) . '" ';
            }
        }

        ob_start();
        $this->wrap_start( $element );
        ?>
        <div class="wogo-form-field wogo-text">

            <label for="<?php echo $element_id; ?>"><?php echo $element_label; ?><em><?php echo $element_required; ?></em></label>
            <input type="text" name="<?php echo $name; ?>" value="<?php echo $element_value; ?>" placeholder="<?php echo $element_placeholder; ?>" class="<?php echo $element_class; ?>" id="<?php echo $element_id; ?>" <?php echo $element_disabled; ?> <?php echo $extra; ?> />
            <?php do_action( 'settings_text_field', $name, $element ); ?>
            <span class="wogo-clear"></span><span class="description"><?php echo $element_desc; ?></span>

        </div>
        <?php
        $this->wrap_close( $element );
        return ob_get_clean();
    }

    /**
     * Hidden form field generator
     * @param  string $name
     * @param  array $element
     * @return string
     */
    function hidden_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $extra            = '';
        $element['id']    = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $element['class'] = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $element['extra'] = isset( $element['extra'] ) ? $element['extra'] : array();
        $element['value'] = isset( $element['value'] ) ? esc_attr( $element['value'] ) : '';

        if( is_array( $element['extra'] ) && count( $element['extra'] ) ) {
            foreach( $element['extra'] as $key => $action ) {
                $extra .= esc_attr( $key ) .'='. esc_attr( $action ) . ' ';
            }
        }


        $html = sprintf( '<input type="hidden" name="%1$s" value="%2$s" class="%3$s" id="%4$s" %5$s />', $name,
            $element['value'], $element['class'], $element['id'], $extra );

        ob_start();
        $this->wrap_start( $element );
        echo '<div id="wogo-hidden">';
        echo $html;

        echo '</div>';
        $this->wrap_close( $element );
        return ob_get_clean();
    }

    /**
     * Radio form field generator
     * @param  string $name
     * @param  array $element
     * @return string
     */
    function radio_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $element['required'] = ( isset( $element['required'] ) &&  ( $element['required'] == 'required' ) ) ? '*' : '';
        $label = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $html = sprintf( '<label for="">%1$s<em>%2$s</em></label>', $label, $element['required'] );

        $fields = isset( $element['fields'] ) ? $element['fields'] : array();

        foreach( $fields as $field ) {
            $extra_attr = '';
            $value      = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
            $id         = isset( $field['id'] ) ? esc_attr( $field['id'] ) : 'wogo_' .$name .'_'. $value;
            $class      = isset( $field['class'] ) ? esc_attr( $field['class'] ) : esc_attr( $name );
            $disabled   = isset( $field['disabled'] ) ? esc_attr( $field['disabled'] ) : '';
            $extra      = isset( $field['extra'] ) ? $field['extra'] : array();
            $label      = isset( $field['label'] ) ? esc_attr( $field['label'] ) : '';
            $checked    = isset( $field['checked'] ) ? esc_attr( $field['checked'] ) : '';

            if( is_array( $extra ) && count( $extra ) ) {
                foreach( $extra as $key => $action ) {
                    $extra_attr .= esc_attr( $key ) .'='. esc_attr( $action ) . ' ';
                }
            }

            $html .= sprintf( '<input type="radio" name="%1$s" value="%2$s" class="%3$s" id="%4$s" %5$s %6$s %7$s />', $name, $value, $class, $id, $disabled, $extra_attr, checked( $value, $checked, false ) );
            $html .= sprintf( '<label class="wogo-radio" for="%1s">%2s</label>', $id, $label );

        }

        $desc = isset( $element['desc'] ) ? esc_attr( $element['desc'] ) : '';
        $html .= sprintf( '<span class="wogo-clear"></span><span class="description">%s</span>', $desc );
        ob_start();
        $this->wrap_start( $element );
        echo '<div id="wogo-radio" class="wogo-form-field">';
        echo $html;
        echo '</div>';
        $this->wrap_close( $element );
        return ob_get_clean();
    }

    /**
     * Checkbox form field generator
     * @param  string $name
     * @param  array $element
     * @return string
     */
    function checkbox_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $element['required'] = ( isset( $element['required'] ) &&  ( $element['required'] == 'required' ) ) ? '*' : '';
        $label = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $html = sprintf( '<label for="">%1$s<em>%2$s</em></label>', $label, $element['required'] );

        $fields = isset( $element['fields'] ) ? $element['fields'] : array();

        foreach( $fields as $field ) {
            $extra_attr = '';
            $value      = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
            $id         = isset( $field['id'] ) ? esc_attr( $field['id'] ) : 'wogo_' .$name .'_'. $value;
            $class      = isset( $field['class'] ) ? esc_attr( $field['class'] ) : esc_attr( $name );
            $disabled   = isset( $field['disabled'] ) ? esc_attr( $field['disabled'] ) : '';
            $extra      = isset( $field['extra'] ) ? $field['extra'] : array();
            $label      = isset( $field['label'] ) ? esc_attr( $field['label'] ) : '';
            $checked    = isset( $field['checked'] ) ? esc_attr( $field['checked'] ) : '';

            if( is_array( $extra ) && count( $extra ) ) {
                foreach( $extra as $key => $action ) {
                    $extra_attr .= esc_attr( $key ) .'='. esc_attr( $action ) . ' ';
                }
            }

            $html .= sprintf( '<input type="checkbox" name="%1$s" value="%2$s" class="%3$s" id="%4$s" %5$s %6$s %7$s />', $name, $value, $class, $id, $disabled, $extra_attr, checked( $checked, $value, false ) );
            $html .= sprintf( '<label class="wogo-checkbox" for="%1s">%2s</label>', $id, $label );

        }

        $desc = isset( $element['desc'] ) ? esc_attr( $element['desc'] ) : '';
        $html .= sprintf( '<span class="wogo-clear"></span><span class="description">%s</span>', $desc );
        ob_start();
        $this->wrap_start( $element );
        echo '<div class="wogo-form-field">';
        echo $html;
        echo '</div>';
        $this->wrap_close( $element );
        return ob_get_clean();
    }

    /**
     * Textarea form field generator
     * @param  string $name
     * @param  array $element
     * @return string
     */
    function textarea_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $extra               = '';
        $element['id']       = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $element['class']    = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $element['disabled'] = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $element['extra']    = isset( $element['extra'] ) ? $element['extra'] : array();
        $element['label']    = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $element['desc']     = isset( $element['desc'] ) ? esc_attr( $element['desc'] ) : '';
        $element['value']    = isset( $element['value'] ) ? esc_attr( $element['value'] ) : '';
        $element['required']    = ( isset( $element['extra']['data-wogo_required'] ) &&  ( $element['extra']['data-wogo_required'] === true ) ) ? '*' : '';

        if( is_array( $element['extra'] ) && count( $element['extra'] ) ) {
            foreach( $element['extra'] as $key => $action ) {
                $extra .= esc_attr( $key ) .'='. esc_attr( $action ).' ';
            }
        }

        $html = sprintf( '<label for="%1s">%2s<em>%3s</em></label>', $element['id'], $element['label'], $element['required'] );
        $html .= sprintf( '<textarea name="%1$s" class="%2$s" id="%3$s" %4$s %5$s >%6$s</textarea>', $name,
                $element['class'], $element['id'], $element['disabled'], $extra, $element['value'] );
        $html .= sprintf( '<span class="wogo-clear"></span><span class="description">%s</span>', $element['desc'] );
        ob_start();
        $this->wrap_start( $element );
        echo '<div class="wogo-form-field">';
        echo $html;
        echo '</div>';
        $this->wrap_close( $element );
        return ob_get_clean();
    }

    function html_field( $name, $element ) {
        $text = isset( $element['html'] ) ? $element['html'] : '';

        ob_start();
            $this->wrap_start( $element );
            if ( !empty( $text ) ) {
                echo '<div class="wogo-form-field wogo-html">';
                echo $text;
                echo '</div>';
            }
            $this->wrap_close( $element );
        return ob_get_clean();
    }

    /**
     * Form field previous wrap generator
     * @param  array $element
     * @return string
     */
    function wrap_start( $element ) {

        $wrap_attr = ( isset( $element['wrap_attr'] ) && is_array( $element['wrap_attr'] ) ) ? $element['wrap_attr'] : array();
        $wrap_start_tag = isset( $element['wrap_start_tag'] ) ? $element['wrap_start_tag'] : 'div';
        $attr = '';
        if( isset( $element['wrap_start'] ) && $element['wrap_start'] ) {
            foreach ( $wrap_attr as $id => $value) {
                $attr .= esc_attr( $id ) .'="'. esc_attr( $value ).'" ';
            }

            echo '<' . $wrap_start_tag .' '. $attr .'>';
        }
    }

    /**
     * Form field after wrap
     * @param  array $element
     * @return string
     */
    function wrap_close( $element ) {
        $wrap_close_tag = isset( $element['wrap_close_tag'] ) ? $element['wrap_close_tag'] : 'div';
        if( isset( $element['wrap_close'] ) && $element['wrap_close'] ) {
            echo '</' . $wrap_close_tag .'>';
        }
    }
}