<?php
class ExtensionHooks {
   // Register any render callbacks with the parser
   public static function onParserFirstCallInit( Parser $parser ) {
      $parser->setFunctionHook( 'API-itemInfobox', [ self::class, 'renderItem' ] );
      $parser->setFunctionHook( 'API-totalOnlinePlayers', [ self::class, 'getOnlinePlayers' ] );
      $parser->setFunctionHook( 'API-ingredientInfobox', [ self::class, 'renderIngredientInfobox' ] );
      $parser->setFunctionHook( 'API-ingredientIdentifications', [ self::class, 'renderIngredientIdentifications' ] );
   }

   // Render the output of {{#API-itemInfobox:itemName|<selector>|<overide=value>}}.
   // Selector is used if more than one item match that name (number can be cycled through until the correct item is displaying)
   // Overide 'questLink' to change the link  of the quest page 
   //public static function renderItem($itemName = 'Oak Wood Stick', $selector = 0, $overrides = "") {
   public static function renderItem(Parser $parser, $itemName = 'Oak Wood Stick', $selector = 0, $overrides = '') {
      //Encode item name with percent characters
      $searchName = rawurlencode($itemName);
      
      //Build Request
      $ch = curl_init("https://api.wynncraft.com/public_api.php?action=itemDB&search=$searchName");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);

      //Execute request
      $data = curl_exec($ch);
      curl_close($ch);

      //Decode
      $itemsList=json_decode($data, true)['items'];
      if (sizeof($itemsList) <= 0) {
         return "Item $itemName Not Found";
      }

      //Get item (uses selector if multiple items match criteria)
      $itemData = $itemsList[$selector];

      //Configure overrides
      if ($overrides != "") {
         $overridesTemp = explode(",", $overrides);
         foreach ($overridesTemp as $value) {
            $array = explode('=', $value);
            $itemData[$array[0]] = $array[1]; 
         }
      }

      //Determine Template
      if ($itemData['category'] == "weapon") {
         $string = "{{Template:AutoWeapon <br>";
      } else if ($itemData['category'] == "armour" || $itemData['category'] == "armor") {
         $string = "{{Template:AutoArmour <br>";
      } else if ($itemData['category'] == "accessory") {
         $string = "{{Template:AutoAccessory <br>";
      } else {
         $string = "{{Template:UnkownItemType <br>";
      }

      //Build Template
      foreach ($itemData as $trait => $value) {
        if ((is_numeric($value) && $value == 0) || $value == null || $value == "" || $value == "0-0") continue;
        if ($trait == "majorIds") continue;
        
        $string .= "| $trait = $value <br>";
      }

      $string .= "}}";

      return $string;
   }



   //Get the total amount of players currently online on Wynncraft
   // Render the output of {{#API-totalOnlinePlayers}}.
   //public static function getOnlinePlayers() {
   public static function getOnlinePlayers(Parser $parser) {
      $ch = curl_init("https://api.wynncraft.com/public_api.php?action=onlinePlayersSum");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);

      //Execute request
      $data = curl_exec($ch);
      curl_close($ch);

      $number=json_decode($data, true)['players_online'];

      return $number;

   }


   // Render the output of {{#API-ingredientInfobox:name|<selector>|<overide=value>}}.
   // Selector is used if more than one item match that name (number can be cycled through until the correct item is displaying)
   //public static function renderIngredientInfobox($itemName = 'Rotten Flesh', $selector = 0, $overrides = "") {
   public static function renderIngredientInfobox(Parser $parser, $itemName = 'Oak Wood Stick', $selector = 0, $overrides = "") {
      //Encode name (using _ for spaces)
      $searchName = str_replace(" ", "_", $itemName);

      //Build get request
      $ch = curl_init("https://api.wynncraft.com/v2/ingredient/get/$searchName");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);
   
      //Execute request
      $data = curl_exec($ch);
      curl_close($ch);

      //Decode request
      $itemsList=json_decode($data, true)['data'];

      //Check list
      if (sizeof($itemsList) <= 0) {
         return "Item $itemName Not Found";
      }
      $itemData = $itemsList[$selector];

      //Configure overrides
      if ($overrides != "") {
         $overridesTemp = explode(",", $overrides);
         foreach ($overridesTemp as $value) {
            $array = explode('=', $value);
            $itemData[$array[0]] = $array[1]; 
         }
      }

      //Build infobox
      $string  = "{{Infobox/Ingredient <br>";
      $string .= "| name = ". $itemData['name'] . "<br>";
      $string .= "| image = {{WynnIcon|". $itemData['sprite']['id'].":".$itemData['sprite']['damage'] . "}}<br>";
      $string .= "| tier = ". $itemData['tier'] . "<br>";
      $string .= "| level = ". $itemData['level'] . "<br>";
      $string .= "| professions = ". implode(',', $itemData['skills']) . "<br>";
      $string .= "}}";

      return $string;
   }

   // Render the output of {{#API-ingredientIdentifications:name|<selector>|<overide=min/max>}}.
   // Selector is used if more than one item match that name (number can be cycled through until the correct item is displaying)
   //public static function renderIngredientIdentifications($itemName = 'Rotten Flesh', $selector = 0, $overrides = "") {
   public static function renderIngredientIdentifications(Parser $parser, $itemName = 'Oak Wood Stick', $selector = 0, $overrides = "") {
      //Encode name (using _ for spaces)
      $searchName = str_replace(" ", "_", $itemName);
   
      //Build get request
      $ch = curl_init("https://api.wynncraft.com/v2/ingredient/get/$searchName");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      
      //Execute request
      $data = curl_exec($ch);
      curl_close($ch);
   
      //Decode request
      $itemsList=json_decode($data, true)['data'];

      //Check list
      if (sizeof($itemsList) <= 0) {
         return "Item $itemName Not Found";
      }
      $itemData = $itemsList[$selector]['identifications'];

      //Configure overrides
      if ($overrides != "") {
         $overridesTemp = explode(",", $overrides);
         foreach ($overridesTemp as $value) {
            $array = explode('=', $value);
            $values = explode("/",$array[1]);
            $output['minimum'] = $values[0];
            $output['maximum'] = $values[1];
            $itemIds[$array[0]] = $output;
         }
      }

      $string = "{{AutoIdentification <br>";
   
      foreach ($itemIds as $id => $values) {
         $min = $values['minimum'];
         $max = $values['maximum'];
         $string .= "| min_$id = $min <br>";
         $string .= "| max_$id = $max <br>";
      };
   
      $string .= "}}";
  
      return [ $string, 'noparse' => false ];;
   }
}