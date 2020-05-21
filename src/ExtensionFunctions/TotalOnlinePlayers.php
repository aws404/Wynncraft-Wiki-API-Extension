<?php

require "./CommonFunctions.php";

class TotalOnlinePlayers {
    /**
     * Render: {{#API-TotalOnlinePlayers}}
     */

    //public static function render() {
    public static function render(Parser $parser) {
        return WynnAPIWrapper::get_onlinePlayersSum();;
    }

}