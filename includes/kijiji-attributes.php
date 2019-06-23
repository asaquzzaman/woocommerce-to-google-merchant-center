<?php
/**
 * Settings for Kijiji Italy feeds
 */

function woogool_kijiji_attributes() {

    $kijiji = array(
		"Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
    			"PartnerId" => array(
                    'label' =>  'Partner Id',
    				"name" => "PartnerId",
    				"feed_name" => "PartnerId",
    				"format" => "required",
    				"woogool_suggest" => "id",
    			),
    			"Action" => array(
                    'label' =>  'Action',
    				"name" => "Action",
    				"feed_name" => "Action",
    				"format" => "required",
    			),
    			"Title" => array(
                    'label' =>  'Title',
    				"name" => "Title",
    				"feed_name" => "Title",
    				"format" => "required",
    				"woogool_suggest" => "title",
    			),
    			"Description" => array(
                    'label' =>  'Description',
    				"name" => "Description",
    				"feed_name" => "Description",
    				"format" => "required",
    				"woogool_suggest" => "description",
    			),
    			"E-mail" => array(
                    'label' =>  'E-mail',
    				"name" => "E-mail",
    				"feed_name" => "Email",
    				"format" => "required",
    			),
    			"URL" => array(
                    'label' =>  'URL',
    				"name" => "URL",
    				"feed_name" => "URL",
    				"format" => "required",
    				"woogool_suggest" => "link",
    			),
                "Price" => array(
                    'label' =>  'Price',
                        "name" => "Price",
                        "feed_name" => "Price",
                        "format" => "required",
                        "woogool_suggest" => "price",
                ),
                "Tipo_Prezzo" => array(
                    'label' =>  'Tipo Prezzo',
                        "name" => "Tipo Prezzo",
                        "feed_name" => "Tipo Prezzo",
                        "format" => "optional",
                ),
                "Municipality_code" => array(
                    'label' =>  'Municipality_code',
                        "name" => "Municipality code",
                        "feed_name" => "Municipality code",
                        "format" => "optional",
                ),
                "Category" => array(
                    'label' =>  'Category',
                        "name" => "Category",
                        "feed_name" => "Category",
                        "format" => "required",
                        "woogool_suggest" => "categories",
                ),
                "Seller_type" => array(
                    'label' =>  'Seller type',
                        "name" => "Seller_type",
                        "feed_name" => "Seller type",
                        "format" => "optional",
                ),
    			"Publication_date" => array(
                    'label' =>  'Publication date',
    				"name" => "Publication_date",
    				"feed_name" => "Publication date",
    				"format" => "required",
    				"woogool_suggest" => "publication_date",
    			),
                "Pic_1" => array(
                    'label' =>  'Pic 1',
                        "name" => "Pic_1",
                        "feed_name" => "Pic 1",
                        "format" => "optional",
                ),
                "Pic_2" => array(
                    'label' =>  'Pic 2',
                        "name" => "Pic_2",
                        "feed_name" => "Pic 2",
                        "format" => "optional",
               ),
               "Pic_3" => array(
                'label' =>  'Pic 3',
                        "name" => "Pic_3",
                        "feed_name" => "Pic 3",
                        "format" => "optional",
                ),
                "Pic_4" => array(
                    'label' =>  'Pic 4',
                        "name" => "Pic_4",
                        "feed_name" => "Pic 4",
                        "format" => "optional",
                ),
                "Pic_5" => array(
                    'label' =>  'Pic 5',
                        "name" => "Pic_5",
                        "feed_name" => "Pic 5",
                        "format" => "optional",
                ),
                "Pic_6" => array(
                    'label' =>  'Pic 6',
                        "name" => "Pic_6",
                        "feed_name" => "Pic 6",
                        "format" => "optional",
                ),
                "Pic_7" => array(
                    'label' =>  'Pic 7',
                        "name" => "Pic_7",
                        "feed_name" => "Pic 7",
                        "format" => "optional",
                ),
                "Pic_8" => array(
                    'label' =>  'Pic 8',
                        "name" => "Pic_8",
                        "feed_name" => "Pic 8",
                        "format" => "optional",
                ),
                "Pic_9" => array(
                    'label' =>  'Pic 9',
                        "name" => "Pic_9",
                        "feed_name" => "Pic 9",
                        "format" => "optional",
                ),
            ),
		),
	);
	return $kijiji;
}

?>
