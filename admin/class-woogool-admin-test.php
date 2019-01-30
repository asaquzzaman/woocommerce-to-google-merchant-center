<?php

class WooGool_Admin_Feed {
    
    private $number_per_page = 20;

    private $google_cat = array();
    private $feed_settings = array();
    protected $start_time = 0;
    
    /**
     * @var The single instance of the class
     * 
     */
    protected static $_instance = null;

    protected $found_posts = 0;
    protected $fetch_all_product = false;

    /**
     * Main woogool Instance
     *
     * @static
     * @see woogool()
     * @return woogool - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct() {
  
        add_action( 'admin_init', array( $this, 'test' ) );

    }

    function test() {
       //$this->auto_test_filter();
       // $this->auto_test_rule();
       // $this->auto_test_value();
    }

    public function auto_test_value() {

        $dropdowns       = woogool_product_attribute_with_optgroups();
        $cond_fun        = woogool_condition_maping_func();
        $product_val_fun = woogool_product_value_maping_func();
        $compare         = woogool_product_attributes_maping_func();
        $wc_product      = wc_get_product(148);
        $dropdowns       = wp_list_pluck( $dropdowns, 'attributes' );
        $product_attrs   = [];
        $logical         = [];
        $product_val     = [];
        $results         = [];
        
        foreach ( $dropdowns as $key => $dropdown ) {
            $product_attrs = array_merge( $product_attrs, $dropdowns[$key] );
        }
        
        foreach ( $product_attrs as $func_key => $product_attr ) {
            //$func_key = 'custom_attributes_attribute_water';
            $call = empty( $product_val_fun[$func_key] ) ? '' : $product_val_fun[$func_key];

            if ( function_exists( $call ) ) {
                $prod_val = $call( $wc_product );
                
            } else {
                $prod_val = woogool_get_product_dynamic_value( $wc_product, $func_key );
            };

            $product_val[$func_key] = $prod_val;
        }
         
        foreach ( $product_attrs as $attr => $label ) {
            
            foreach ( $cond_fun as $logic => $logic_fun ) {
                foreach ( $product_attrs as $attr2 => $label2 ) {
                    $input_val = is_array( $product_val[$attr2] ) ? implode( '|', $product_val[$attr2] ) : $product_val[$attr2];
                    
                    $settings['logic'] = maybe_unserialize([[
                        [
                            'type'      =>  'value',
                            'if_cond'   =>  $attr,
                            'condition' =>  $logic,
                            'value'     =>  $input_val,
                            'then'      =>  '',
                            'is'        =>  '120',
                        ],
                    ]]);

                    $call = empty( $compare[$attr] ) ? '' : $compare[$attr];
                    
                    if ( function_exists( $call ) ) {
                        $compare_val = $call( $wc_product, $settings );    
                    } else {
                        $compare_val = woogool_get_product_compare_dynamic_value( $wc_product, $settings, $attr );    
                    }
                    

                    $set_attr['if']            = $attr;
                    $set_attr['product_value'] = $product_val[$attr];
                    $set_attr['condition']     = $logic;
                    $set_attr['input_value']   = $input_val;
                    $set_attr['replace_with']  = '120';
                    $set_attr['return']        = $compare_val;

                    $results[$attr][] = $set_attr;
                }
            }

            woopr($results); die();
        }   
    }

    public function auto_test_rule() {
        $db_settings = array (
            //jus ignore this array
            array (
                'type'      =>  'filter',
                'if_cond'   =>  'rating_total',
                'condition' =>  'contains',
                'value'     =>  'accessories|clothing|decor|hoodies|music',
                'then'      =>  'exclude',
                'is'        =>  '',
            ),
            //just work with this array
            array (
                'type'      =>  'rule',
                'if_cond'   =>  'id',
                'condition' =>  'contains',
                'value'     =>  'accessories|clothing|decor|hoodies|music',
                'then'      =>  'id',
                'is'        =>  '120',
            ),
            //ignore this array
            array (
                'type'      =>  'value',
                'if_cond'   =>  'id',
                'condition' =>  'contains',
                'value'     =>  '',
                'then'      =>  'exclude',
                'is'        =>  ''
            )
        );

        $dropdowns       = woogool_product_attribute_with_optgroups();
        $cond_fun        = woogool_condition_maping_func();
        $product_val_fun = woogool_product_value_maping_func();
        $compare         = woogool_product_attributes_maping_func();
        $wc_product      = wc_get_product(143);
        $dropdowns       = wp_list_pluck( $dropdowns, 'attributes' );
        $product_attrs   = [];
        $logical         = [];
        $product_val     = [];
        $results         = [];

        foreach ( $dropdowns as $key => $dropdown ) {
            $product_attrs = array_merge( $product_attrs, $dropdowns[$key] );
        }
        
        foreach ( $product_attrs as $func => $product_attr ) {

            $call = empty( $product_val_fun[$func] ) ? '' : $product_val_fun[$func];

            if ( function_exists( $call ) ) {
                $prod_val = $call( $wc_product );
                
            } else {
                $prod_val = woogool_get_product_dynamic_value( $wc_product, $func );
            };

            $product_val[$func] = $prod_val;
        }
         
        foreach ( $product_attrs as $attr => $label ) {
            foreach ( $cond_fun as $logic => $logic_fun ) {
                foreach ( $product_attrs as $attr2 => $label2 ) {
                    $input_val = is_array( $product_val[$attr2] ) ? implode( '|', $product_val[$attr2] ) : $product_val[$attr2];
                    
                    $settings['logic'] = maybe_unserialize([[
                        [
                            'type'      =>  'rule',
                            'if_cond'   =>  $attr2,
                            'condition' =>  $logic,
                            'value'     =>  $input_val,
                            'then'      =>  $attr,
                            'is'        =>  '120',
                        ],
                    ]]);
                    

                    $call = empty( $compare[$attr] ) ? '' : $compare[$attr];
                    
                    if ( function_exists( $call ) ) {
                        $compare_val = $call( $wc_product, $settings );    
                    } else {
                        $compare_val = woogool_get_product_compare_dynamic_value( $wc_product, $settings, $attr );    
                    }

                    $set_attr['if']        = $attr2;
                    $set_attr['condition'] = $logic;
                    $set_attr['value']     = $input_val;
                    $set_attr['then']      = $attr;
                    $set_attr['is']        = '120';
                    $set_attr['return']    = $compare_val;

                    $results[$attr][] = $set_attr;
                }
            }

            woopr($results); die();
        }   
    }

    function auto_test_filter() {
        $dropdowns       = woogool_product_attribute_with_optgroups();
        $cond_fun        = woogool_condition_maping_func();
        $product_val_fun = woogool_product_value_maping_func();
        $wc_product      = wc_get_product(143);
        $dropdowns       = wp_list_pluck( $dropdowns, 'attributes' );
        $product_attrs   = [];
        $logical         = [];
        $product_val     = [];
        $results         = [];

        foreach ( $dropdowns as $key => $dropdown ) {
            $product_attrs = array_merge( $product_attrs, $dropdowns[$key] );
        }
        
        foreach ( $product_attrs as $func => $product_attr ) {
            $call = empty( $product_val_fun[$func] ) ? '' : $product_val_fun[$func];

            if ( function_exists( $call ) ) {
                $prod_val = $call( $wc_product );
                
            } else {
                $prod_val = woogool_get_product_dynamic_value( $wc_product, $func );
            };

            $product_val[$func] = $prod_val;
        }

        foreach ( $product_attrs as $attr => $label ) {
            foreach ( $cond_fun as $logic => $logic_fun ) {
                foreach ( $product_attrs as $attr2 => $label2 ) {
                    $input_val = is_array( $product_val[$attr2] ) ? implode( '|', $product_val[$attr2] ) : $product_val[$attr2];

                    $compare_val = $logic_fun( $product_val[$attr], $input_val );

                    $set_attr['input_val']         = $input_val;
                    $set_attr['product_val']       = $product_val[$attr];
                    $set_attr['product_attr_name'] = $attr;
                    $set_attr['results']           = $compare_val === false ? 0 : $compare_val;
                    $set_attr['filter_type']       = $logic;

                    $results[$attr][] = $set_attr;
                }
            }
        }
    }

}