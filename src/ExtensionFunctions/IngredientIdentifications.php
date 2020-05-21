<?php

require "./CommonFunctions.php";

class IngredientIdentifications {
    /**
     * Renders: {{#API-IngredientIdentifications:name|<overide=value>}}.
     */

    //public static function render($itemName = 'Rotten Flesh', $overrides = "") {
    public static function render(Parser $parser, $itemName = 'Rotten Flesh', $overrides = "") {
        $identifications = WynnAPIWrapper::get_ingredientData($itemName)['identifications'];

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
        
        
        $return = CommonFunctions::create_template("Identification", $templateData);
		
		return [$return, 'noparse' => false];
	}
}