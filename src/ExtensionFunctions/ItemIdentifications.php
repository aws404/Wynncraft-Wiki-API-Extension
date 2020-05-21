<?php

require "./CommonFunctions.php";

class ItemIdentifications {
    /**
     * Renders: {{#API-ItemIdentifications:name|<overide=value>}}.
     */

    //public static function render($itemName = 'Oak Wood Stick', $overrides = "") {
    public static function render(Parser $parser, $itemName = 'Oak Wood Stick', $overrides = "") {
        $identifications = WynnAPIWrapper::get_itemData($itemName)['identifications'];

        foreach ($identifications as $key => $values) {
            $templateName = Identifications::getFromName($key)['templateName'];
            $min = $values['minimum'];
            $max = $values['maximum'];

            $templateData["min_$templateName"] = $min;
            $templateData["max_$templateName"] = $max;
        }

        //Configure overrides
        if ($overrides != "") {
            $overridesTemp = explode(",", $overrides);
            foreach ($overridesTemp as $value) {
                $array = explode('=', $value);
                $templateData[$array[0]] = $array[1]; 
            }
        }

        return CommonFunctions::create_template("Identification", $templateData);
    }
}