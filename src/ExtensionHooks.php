<?php

require "ExtensionFunctions/ItemInfobox.php";
require "ExtensionFunctions/ItemIdentifications.php";
require "ExtensionFunctions/TotalOnlinePlayers.php";
require "ExtensionFunctions/IngredientInfobox.php";
require "ExtensionFunctions/IngredientIdentifications.php";

class ExtensionHooks {
   // Register any render callbacks with the parser
   public static function onParserFirstCallInit(Parser $parser) {
      $parser->setFunctionHook( 'API-ItemInfobox', [ItemInfobox::class, 'render']);
      $parser->setFunctionHook( 'API-ItemIdentifications', [ItemIdentifications::class, 'render']);
      $parser->setFunctionHook( 'API-TotalOnlinePlayers', [TotalOnlinePlayers::class, 'render']);
      $parser->setFunctionHook( 'API-IngredientInfobox', [IngredientInfobox::class, 'render']);
      $parser->setFunctionHook( 'API-ingredientIdentifications', [IngredientIdentifications::class, 'render']);
   }
}