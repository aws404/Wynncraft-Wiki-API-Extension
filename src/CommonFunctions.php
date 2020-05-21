<?php

require "WynnAPIWrapper/WynnAPIWrapper.php";

class CommonFunctions {
    static function create_template(string $templateName, array $arguments) {
        $string = "{{" . $templateName. "<br>";

        foreach ($arguments as $key => $value) {
            if (is_array($value)) continue;
            $string .= "| $key = $value<br>";
        }

        $string .= "}}";

        return $string;
    }
}