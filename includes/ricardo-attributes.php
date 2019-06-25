<?php
/**
 * Settings for Ricardo feeds
 */

function woogoo_ricardo_attributes() {

    $ricardo = array(
        "Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "StartPrice" => array(
                    'label' => 'Start Price',
                    "name" => "StartPrice",
                    "feed_name" => "StartPrice",
                    "format" => "required",
                ),
                "BuyNowPrice" => array(
                    'label' => 'Buy Now Price',
                    "name" => "BuyNowPrice",
                    "feed_name" => "BuyNowPrice",
                    "format" => "required",
                    "woogool_suggest" => "price"
                ),
                "AvailibilityId" => array(
                    'label' => 'Availibility Id',
                    "name" => "AvailabilityId",
                    "feed_name" => "AvailabilityId",
                    "format" => "required",
                ),
                "Duration" => array(
                    'label' => 'Duration',
                    "name" => "Duration",
                    "feed_name" => "Duration",
                    "format" => "required",
                ),
                "FeaturedHomePage" => array(
                    'label' => 'Featured Home Page',
                    "name" => "FeaturedHomepage",
                    "feed_name" => "FeaturedHomepage",
                    "format" => "required",
                ),
                "Shipping" => array(
                    'label' => 'Shipping',
                    "name" => "Shipping",
                    "feed_name" => "Shipping",
                    "format" => "required",
                ),
                "Warranty" => array(
                    'label' => 'Warranty',
                    "name" => "Warranty",
                    "feed_name" => "Warranty",
                    "format" => "required",
                ),
                "Quantity" => array(
                    'label' => 'Quantity',
                    "name" => "Quantity",
                    "feed_name" => "Quantity",
                    "format" => "required",
                ),
                "Increment" => array(
                    'label' => 'Increment',
                    "name" => "Increment",
                    "feed_name" => "Increment",
                    "format" => "required",
                ),
                "CategoryNr" => array(
                    'label' => 'Category Nr',
                    "name" => "CategoryNr",
                    "feed_name" => "CategoryNr",
                    "format" => "required",
                ),
                "Condition" => array(
                    'label' => 'Condition',
                    "name" => "Condition",
                    "feed_name" => "Condition",
                    "format" => "required",
                ),
                "ShippingCost" => array(
                    'label' => 'Shipping Cost',
                    "name" => "ShippingCost",
                    "feed_name" => "ShippingCost",
                    "format" => "required",
                ),
                "ResellCount" => array(
                    'label' => 'Resell Count',
                    "name" => "ResellCount",
                    "feed_name" => "ResellCount",
                    "format" => "required",
                ),
                "BuyNow" => array(
                    'label' => 'Buy Now',
                    "name" => "BuyNow",
                    "feed_name" => "BuyNow",
                    "format" => "required",
                ),
                "BuyNowCost" => array(
                    'label' => 'Buy Now Cost',
                    "name" => "BuyNowCost",
                    "feed_name" => "BuyNowCost",
                    "format" => "required",
                ),
                "TemplateName" => array(
                    'label' => 'Template Name',
                    "name" => "TemplateName",
                    "feed_name" => "TemplateName",
                    "format" => "required",
                ),
                "StartDate" => array(
                    'label' => 'Start Date',
                    "name" => "StartDate",
                    "feed_name" => "StartDate",
                    "format" => "required",
                ),
                "StartImmediatly" => array(
                    'label' => 'Start Immediatly',
                    "name" => "StartImmediatly",
                    "feed_name" => "StartImmediatly",
                    "format" => "required",
                ),
                "EndDate" => array(
                    'label' => 'End Date',
                    "name" => "EndDate",
                    "feed_name" => "EndDate",
                    "format" => "required",
                ),
                "HasFixedEndDate" => array(
                    'label' => 'Has Fixed End Date',
                    "name" => "HasFixedEndDate",
                    "feed_name" => "HasFixedEndDate",
                    "format" => "required",
                ),
                "InternalReference" => array(
                        'label' => 'Internal Reference',
                    "name" => "InternalReference",
                    "feed_name" => "InternalReference",
                    "format" => "required",
                ),
                "TemplateId" => array(
                    'label' => 'Template Id',
                        "name" => "TemplateId",
                        "feed_name" => "TemplateId",
                        "format" => "required",
                ),
                "PackageSizeId" => array(
                    'label' => 'Package Size Id',
                        "name" => "PackageSizeId",
                        "feed_name" => "PackageSizeId",
                        "format" => "required",
                ),
                "PromotionId" => array(
                    'label' => 'Promotion Id',
                        "name" => "PromotionId",
                        "feed_name" => "PromotionId",
                        "format" => "required",
                ),
                "IsCarsBikesAccessoriesArticle" => array(
                    'label' => 'Is Cars Bikes Accessories Article',
                        "name" => "IsCarsBikesAccessoriesArticle",
                        "feed_name" => "IsCarsBikesAccessoriesArticle",
                        "format" => "required",
                ),
                "Descriptions[0].LanguageNr" => array(
                    'label' => 'Language Nr',
                        "name" => "Descriptions[0].LanguageNr",
                        "feed_name" => "Descriptions[0].LanguageNr",
                        "format" => "required",
                ),
                "Descriptions[0].ProductTitle" => array(
                    'label' => 'Product Title 0',
                        "name" => "Descriptions[0].ProductTitle",
                        "feed_name" => "Descriptions[0].ProductTitle",
                        "format" => "required",
                ),
                "Descriptions[0].ProductDescription" => array(
                    'label' => 'Product Description 0',
                        "name" => "Descriptions[0].ProductDescription",
                        "feed_name" => "Descriptions[0].ProductDescription",
                        "format" => "required",
                ),
                "Descriptions[0].ProductSubtitle" => array(
                    'label' => 'Product Subtitle 0',
                        "name" => "Descriptions[0].ProductSubtitle",
                        "feed_name" => "Descriptions[0].ProductSubtitle",
                        "format" => "required",
                ),
                "Descriptions[0].PaymentDescription" => array(
                    'label' => 'Payment Description 0',
                        "name" => "Descriptions[0].PaymentDescription",
                        "feed_name" => "Descriptions[0].PaymentDescription",
                        "format" => "required",
                ),
                "Descriptions[0].ShippingDescription" => array(
                    'label' => 'Shipping Description 0',
                        "name" => "Descriptions[0].ShippingDescription",
                        "feed_name" => "Descriptions[0].ShippingDescription",
                        "format" => "required",
                ),
                "Descriptions[0].WarrantyDescription" => array(
                    'label' => 'Warranty Description 0',
                        "name" => "Descriptions[0].WarrantyDescription",
                        "feed_name" => "Descriptions[0].WarrantyDescription",
                        "format" => "required",
                ),
                "Descriptions[1].ProductTitle" => array(
                    'label' => 'Product Title 1',
                        "name" => "Descriptions[1].ProductTitle",
                        "feed_name" => "Descriptions[1].ProductTitle",
                        "format" => "required",
                ),
                "Descriptions[1].ProductDescription" => array(
                    'label' => 'Product Description 1',
                        "name" => "Descriptions[1].ProductDescription",
                        "feed_name" => "Descriptions[1].ProductDescription",
                        "format" => "required",
                ),
                "Descriptions[1].ProductSubtitle" => array(
                    'label' => 'Product Subtitle 1',
                        "name" => "Descriptions[1].ProductSubtitle",
                        "feed_name" => "Descriptions[1].ProductSubtitle",
                        "format" => "required",
                ),
                "Descriptions[1].PaymentDescription" => array(
                    'label' => 'Payment Description 1',
                        "name" => "Descriptions[1].PaymentDescription",
                        "feed_name" => "Descriptions[1].PaymentDescription",
                        "format" => "required",
                ),
                "Descriptions[1].ShippingDescription" => array(
                    'label' => 'Shipping Description 1',
                        "name" => "Descriptions[1].ShippingDescription",
                        "feed_name" => "Descriptions[1].ShippingDescription",
                        "format" => "required",
                ),
                "Descriptions[1].WarrantyDescription" => array(
                    'label' => 'Warranty Description 1',
                        "name" => "Descriptions[1].WarrantyDescription",
                        "feed_name" => "Descriptions[1].WarrantyDescription",
                        "format" => "required",
                ),
                "DraftImages[0]" => array(
                    'label' => 'Draft Images 0',
                        "name" => "DraftImages[0]",
                        "feed_name" => "DraftImages[0]",
                        "format" => "required",
                ),
                "DraftImages[1]" => array(
                    'label' => 'Draft Images 1',
                        "name" => "DraftImages[1]",
                        "feed_name" => "DraftImages[1]",
                        "format" => "required",
                ),
                "DraftImages[2]" => array(
                    'label' => 'Draft Images 2',
                        "name" => "DraftImages[2]",
                        "feed_name" => "DraftImages[2]",
                        "format" => "required",
                ),
                "DraftImages[3]" => array(
                    'label' => 'Draft Images 3',
                        "name" => "DraftImages[3]",
                        "feed_name" => "DraftImages[3]",
                        "format" => "required",
                ),
                "DraftImages[4]" => array(
                    'label' => 'Draft Images 4',
                        "name" => "DraftImages[4]",
                        "feed_name" => "DraftImages[4]",
                        "format" => "required",
                ),
                "DraftImages[5]" => array(
                    'label' => 'Draft Images 5',
                        "name" => "DraftImages[5]",
                        "feed_name" => "DraftImages[5]",
                        "format" => "required",
                ),
                "DraftImages[6]" => array(
                    'label' => 'Draft Images 6',
                        "name" => "DraftImages[6]",
                        "feed_name" => "DraftImages[6]",
                        "format" => "required",
                ),
                "DraftImages[7]" => array(
                    'label' => 'Draft Images 7',
                        "name" => "DraftImages[7]",
                        "feed_name" => "DraftImages[7]",
                        "format" => "required",
                ),
                "DraftImages[8]" => array(
                    'label' => 'Draft Images 8',
                        "name" => "DraftImages[8]",
                        "feed_name" => "DraftImages[8]",
                        "format" => "required",
                ),
                "DraftImages[9]" => array(
                    'label' => 'Draft Images 9',
                        "name" => "DraftImages[9]",
                        "feed_name" => "DraftImages[9]",
                        "format" => "required",
                ),
                "IsFixedPrice" => array(
                    'label' => 'Is Fixed Price',
                        "name" => "IsFixedPrice",
                        "feed_name" => "IsFixedPrice",
                        "format" => "required",
                ),
                "PaymentCode" => array(
                    'label' => 'Payment Code',
                        "name" => "PaymentCode",
                        "feed_name" => "PaymentCode",
                        "format" => "required",
                ),
                "IsCumulativeShipping" => array(
                    'label' => 'Is Cumulative Shipping',
                        "name" => "IsCumulativeShipping",
                        "feed_name" => "IsCumulativeShipping",
                        "format" => "required",
                ),
            ),
        ),
    );
    return $ricardo;
}

?>
