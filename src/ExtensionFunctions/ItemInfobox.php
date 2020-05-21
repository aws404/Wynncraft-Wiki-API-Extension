<?php

require "./CommonFunctions.php";

class ItemInfobox {
   /**
    * Render: {{#API-ItemInfobox:itemName|<overide=value>}}.
    */
    
   //public static function render($itemName = 'Oak Wood Stick', $overrides = "") {
   public static function render(Parser $parser, $itemName = 'Oak Wood Stick', $overrides = '') {

   //Get item (uses selector if multiple items match criteria)
   $itemData = WynnAPIWrapper::get_itemData($itemName);

   //Determine Template
   switch ($itemData['category']) {
      case "weapon":
         $template = "Infobox/Weapon";
      break;
      case "armour":
      case "armor":
         $template = "Infobox/Armor";
      break;
      case "accessory": 
         $template = "Infobox/Accessory";
      break;
      default:
         $template = "Infobox";
      break;
   }

   //Configure overrides
   if ($overrides != "") {
      $overridesTemp = explode(",", $overrides);
      foreach ($overridesTemp as $value) {
         $array = explode('=', $value);
         $itemData[$array[0]] = $array[1]; 
      }
   }

   return CommonFunctions::create_template($template, $itemData);
 }



}