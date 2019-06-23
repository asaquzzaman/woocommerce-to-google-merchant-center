<?php
/**
 * Settings for Guenstiger feeds
 */

function woogool_guenstiger_attributes() {

          
    $guenstiger = array(
        "Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
				"Bestellnummer" => array(
                    'label'           => 'Bestell nummer',
                    "name"            => "bestellnummer",
                    "feed_name"       => "bestellnummer",
                    "format"          => "required",
                    "woogool_suggest" => "id",
				),
				"HerstellerArtNr" => array(
                    'label'     => 'HerstellerArtNr',
                    "name"      => "HerstellerArtNr",
                    "feed_name" => "HerstellerArtNr",
                    "format"    => "required",
				),
				"Hersteller" => array(
                    'label'     => 'Hersteller',
                    "name"      => "Hersteller",
                    "feed_name" => "Hersteller",
                    "format"    => "required",
				),
				"ProductLink" => array(
                    'label'           => 'Product Link',
                    "name"            => "ProductLink",
                    "feed_name"       => "ProductLink",
                    "format"          => "required",
                    "woogool_suggest" => "link",
				),
				"FotoLink" => array(
                    'label'           => 'Foto Link',
                    "name"            => "FotoLink",
                    "feed_name"       => "FotoLink",
                    "format"          => "required",
                    "woogool_suggest" => "image",
				),
				"ProducktBeschreibung" => array(
                    'label'           => 'ProducktBeschreibung',
                    "name"            => "ProduktBeschreibung",
                    "feed_name"       => "ProduktBeschreibung",
                    "format"          => "required",
                    "woogool_suggest" => "description",
				),
				"ProduktBezeichnung" => array(
                    'label'           => 'ProduktBezeichnung',
                    "name"            => "ProduktBezeichnung",
                    "feed_name"       => "ProduktBezeichnung",
                    "format"          => "required",
                    "woogool_suggest" => "title",
				),
				"Preis" => array(
                    'label'           => 'Preis',
                    "name"            => "Preis",
                    "feed_name"       => "Preis",
                    "format"          => "required",
                    "woogool_suggest" => "price",
				),
				"Lieferzeit" => array(
                    'label'     => 'Lieferzeit',
                    "name"      => "Lieferzeit",
                    "feed_name" => "Lieferzeit",
                    "format"    => "required",
				),
                "EANCode" => array(
                    'label'     => 'EAN',
                    "name"      => "EANCode",
                    "feed_name" => "EANCode",
                    "format"    => "required",
                ),
                "Kategorie" => array(
                    'label'  => 'Kategorie',
                        "name" => "Kategorie",
                        "feed_name" => "Kategorie",
                        "format" => "required",
	                   "woogool_suggest" => "category",
                ),
                "VersandVorkasse" => array(
                    'label'  => 'VersandVorkasse',
                        "name" => "VersandVorkasse",
                        "feed_name" => "VersandVorkasse",
                        "format" => "required",
                ),
                "VersandPayPal" => array(
                    'label'  => 'VersandPayPal',
                        "name" => "VersandPayPal",
                        "feed_name" => "VersandPaypal",
                        "format" => "required",
                ),
                "VersandKreditkarte" => array(
                    'label'  => 'VersandKreditkarte',
                        "name" => "VersandKreditkarte",
                        "feed_name" => "VersandKreditkarte",
                        "format" => "required",
                ),
                "VersandLastschrift" => array(
                    'label'  => 'VersandLastschrift',
                        "name" => "VersandLastschrift",
                        "feed_name" => "VersandLandschrift",
                        "format" => "required",
                ),
                "VersandRechnung" => array(
                    'label'  => 'VersandRechnung',
                        "name" => "VersandRechnung",
                        "feed_name" => "VersandRechnung",
                        "format" => "required",
                ),
                "VersandNachnahme" => array(
                    'label'  => 'VersandNachnahme',
                        "name" => "VersandNachnahme",
                        "feed_name" => "VersandNachnahme",
                        "format" => "required",
                ),
                "Grundpreis komplett" => array(
                    'label'  => 'Grundpreis komplett',
                        "name" => "Grundpreis komplett",
                        "feed_name" => "Grundpres komplett",
                        "format" => "optional",
                ),
                 "Energieeffizienzklasse" => array(
                    'label'  => 'Energieeffizienzklasse',
                        "name" => "Energieeffizienzklasse",
                        "feed_name" => "Energieeffizienzklasse",
                        "format" => "optional",
                ),
                 "Keyword" => array(
                    'label'  => 'Keyword',
                        "name" => "Keyword",
                        "feed_name" => "Keyword",
                        "format" => "optional",
                ),
                "Gewicht" => array(
                    'label'  => 'Gewicht',
                        "name" => "Gewicht",
                        "feed_name" => "Gewicht",
                        "format" => "optional",
                ),
                "Groesse" => array(
                    'label'  => 'Groesse',
                        "name" => "Groesse",
                        "feed_name" => "Groesse",
                        "format" => "optional",
                ),
                "Farbe" => array(
                    'label'  => 'Farbe',
                        "name" => "Farbe",
                        "feed_name" => "Farbe",
                        "format" => "optional",
                ),
                "Geschlecht" => array(
                    'label'  => 'Geschlecht',
                        "name" => "Geschlecht",
                        "feed_name" => "Geschlecht",
                        "format" => "optional",
                ),
                "Erwachsene/Kind" => array(
                    'label'  => 'Erwachsene / Kind',
                        "name" => "Erwachsene / Kind",
                        "feed_name" => "Erwachsene / Kind",
                        "format" => "optional",
                ),
                "PZN" => array(
                    'label'  => 'PZN',
                        "name" => "PZN",
                        "feed_name" => "PZN",
                        "format" => "optional",
                ),
                "Reifentyp" => array(
                    'label'  => 'Reifentyp',
                        "name" => "Reifentyp",
                        "feed_name" => "Reifentyp",
                        "format" => "optional",
                ),
                "Reifensaison" => array(
                    'label'  => 'Reifensaison',
                        "name" => "Reifensaison",
                        "feed_name" => "Reifensaison",
                        "format" => "optional",
                ),
                "Reifenmass" => array(
                    'label'  => 'Reifenmass',
                        "name" => "Reifenmass",
                        "feed_name" => "Reifenmass",
                        "format" => "optional",
                ),
            ),
		),
	);

	return $guenstiger;
}

?>
