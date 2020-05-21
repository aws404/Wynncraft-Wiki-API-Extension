<?php

require "./CommonFunctions.php";

class IngredientInfobox {
    /**
     * Render:{#API-IngredientInfobox:name|<overide=value>}}.
     */ 
    
    //public static function render($itemName = 'Rotten Flesh', $overrides = "") {
    public static function render(Parser $parser, $itemName = 'Rotten Flesh', $overrides = "") {
        $itemData = WynnAPIWrapper::get_ingredientData($itemName);

        //Configure overrides
        if ($overrides != "") {
            $overridesTemp = explode(",", $overrides);
            foreach ($overridesTemp as $value) {
                $array = explode('=', $value);
                $itemData[$array[0]] = $array[1]; 
            }
        }

        $templateData['name'] = $itemData['name'];
        $templateData['image'] = "{{WynnIcon|" . $itemData['sprite']['id'] . ":" . $itemData['sprite']['damage'] . "}}";
        $templateData['tier'] = $itemData['tier'];
        $templateData['level'] = $itemData['level'];
        $templateData['professions'] = implode(',', $itemData['skills']);

        return CommonFunctions::create_template("Infobox/Ingredient", $templateData);
    }

}