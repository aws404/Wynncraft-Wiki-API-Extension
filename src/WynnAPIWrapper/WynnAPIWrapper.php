<?php 

require "Enums.php";

class WynnAPIWrapper {
    /**
     * 
     * Submits a request to the legacy api
     * 
     * @param   string $action The action to be preformed
     * @param   array $arguments The arguments to be supplied
     * 
     * @return array The data returned from the API
     */
    public static function request_legacyApi(string $action, array $arguments = []) {
        //Build Request
        $url = "https://api-legacy.wynncraft.com/public_api.php?action=$action";

        foreach ($arguments as $argument => $value) {
            $url = $url . "&$argument=$value";
        }

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //Execute request
        $data = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($data, true);

        if (!array_key_exists('request', $data)) {
            throw new Exception("Request Error: " . $data);
            return false;
        }

        unset($data['request']); 

        return $data;
    }

    /**
     * 
     * Submits a request to the v2 API
     * 
     * @param   string $action The action to be preformed
     * 
     * @return array The data returned from the API
     */
    public static function request_ApiV2(string $action) {
        //Build Request
        $url = "https://api.wynncraft.com/v2/$action";

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //Execute request
        $data = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($data, true);

        if (!array_key_exists('kind', $data)) {
            throw new Exception("Request Error: " . $data['status']);
            return false;
        }

        return $data['data'];
    }

    /**
     * 
     * Does an item search of the items DB
     * 
     * @param   string $name The item name to search
     * 
     * @return  array An array of matching item names
     */
    public static function get_itemSearch(string $name) {
        $data = self::request_legacyApi("itemDB", ["search" => $name]);

        $data = $data['items'];

        if (count($data) <= 0) {
            return "NO_RESULTS";
        }

        $returns = [];
        foreach ($data as $item) {
            array_push($returns, $item['name']);
        }

        return $returns;

    }

    /**
     * 
     * Gets the item data of the item with the supplied name
     * 
     * @param   string $name The full name of the intended item
     * 
     * @return array The item data
     */
    public static function get_itemData(string $name) {
        $data = self::request_legacyApi("itemDB", ["search" => rawurlencode($name)]);

        $data = $data['items'];

        if (count($data) <= 0) {
            return "NO_RESULTS";
        }

        $found = false;
        foreach ($data as $item) {
            if ($item['name'] == $name) {
                $data = $item;
                $found = true;
                break;
            }
        }

        if (!$found) {
            return "NOT_FOUND";
        }

        if ($data['material'] != null) {
            if (strpos($data['material'], ":") !== false) {
                $matData = explode(":", $data['material']);
                $return['sprite'] = array("id" => $matData[0], "damage" => $matData[1]);
            } else {
                $return['sprite'] = array("id" => $data['material'], "damage" => 0);
            }
        } elseif ($data['armorType'] != null) {
            $return['sprite'] = strtolower($data['armorType'] . "_" . $data['type']);
            unset($data['armorType']);
        }
        unset($data['material']);

        if (array_key_exists('identified', $data)) {
            if ($data['identified'] == 1) {
                $data['identified'] = true;
            } else {
                $data['identified'] = false;
            }
        } else {
            $data['identified'] = false;
        }

        if (!array_key_exists('displayName', $data)) {
            $data['displayName'] = $data['name'];
        }

        foreach ($data as $key => $value) {
            if (Requirements::isRequirement($key)) {
                unset($data[$key]);
                if (!$value) continue;

                $return['requirements'][$key] = $value;
                continue;
            }

            if ($data['category'] == "weapon") {
                $damage = Damages::getFromLegacyName($key);
                if (!($damage['name'] == "NOTFOUND")) {
                    unset($data[$key]);

                    if ($value == "0-0") continue;

                    $exploded = explode("-", $value);

                    $min = $exploded[0];
                    $max = $exploded[1];

                    $return['damages'][$damage['name']] = ["min" => $min, "max" => $max];
                    continue;
                }
            } else {
                $defense = Defenses::getFromLegacyName($key);
                if (!($defense['name'] == "NOTFOUND")) {
                    unset($data[$key]);

                    if ($value == 0) continue;

                    $return['defenses'][$defense['name']] = $value;
                    continue;
                }
            }

            $ID = Identifications::getFromLegacyName($key);
            if (!($ID['name'] == "NOTFOUND")) {
                unset($data[$key]);

                if ($value == 0) continue;

                if ($ID['single'] || $data['identified']) {
                    $min = $value;
                    $max = $value;
                } else {
                    if ($value < 0) {
                        $min = min(round($value * 0.7, 0, PHP_ROUND_HALF_UP), -1);
                        $max= min(round($value * 1.3, 0, PHP_ROUND_HALF_UP), -1);
                    } else {
                        $min =  max(round($value * 0.3, 0, PHP_ROUND_HALF_UP), 1);
                        $max = max(round($value * 1.3, 0, PHP_ROUND_HALF_UP), 1);
                    }
                }

                $return['identifications'][$ID['name']] = ["minimum" => $min, "maximum" => $max];
                continue;
            }
            
        }

        return array_merge($data, $return);
    }

    /**
     * 
     * Gets a sum of all currently online players
     * 
     * @return int Number of currently online players
     */
    public static function get_onlinePlayersSum() {
        $data = self::request_legacyApi("onlinePlayersSum");

        $number=$data['players_online'];

        return $number;
    }

    /**
     * 
     * Gets a list of each world and the players online
     * 
     * @return array Each world and the players online
     */
    public static function get_onlinePlayers() {
        $data = self::request_legacyApi("onlinePlayers");;

        return $data;
    }

    /**
     * 
     * Gets a list of all guilds
     * 
     * @return array All guilds
     */
    public static function get_guildList() {
        $data = self::request_legacyApi("guildList");
        $guilds = $data['guilds'];

        return $guilds;
    }

    /**
     * 
     * Gets the statistics of the supplied guild
     * 
     * @param   string $guildName The full guild name
     * 
     * @return  array The statistics of the supplied guild
     */
    public static function get_guildStats(string $guildName) {
        $data = self::request_legacyApi('guildStats', ["command" => rawurlencode($guildName)]);
        return $data;
    }

    /**
     * 
     * Gets the guild leaderboard data
     * 
     * @param string $timeframe Sets the intended timeframe. Defaults to 'alltime'
     * 
     * @return array The leaderboard data 
     */
    public static function get_leaderboardGuild(string $timeframe = "alltime") {
        $data = self::request_legacyApi('statsLeaderboard', ["type" => "guild", "timeframe" => rawurlencode($timeframe)]);
        return $data['data'];
    }

    /**
     * 
     * Gets the player leaderboard data
     * 
     * @param string $timeframe Sets the intended timeframe. Defaults to 'alltime'
     * 
     * @return array The leaderboard data 
     */
    public static function get_leaderboardPlayer(string $timeframe = "alltime") {
        $data = self::request_legacyApi('statsLeaderboard', ["type" => "player", "timeframe" => rawurlencode($timeframe)]);
        return $data['data'];
    }

    /**
     * 
     * Gets the pvp leaderboard data
     * 
     * @param string $timeframe Sets the intended timeframe. Defaults to 'alltime'
     * 
     * @return array The leaderboard data 
     */    
    public static function get_leaderboardPvp(string $timeframe = "alltime") {
        $data = self::request_legacyApi('statsLeaderboard', ["type" => "pvp", "timeframe" => rawurlencode($timeframe)]);
        return $data['data'];
    }

    /**
     * 
     * Gets a list of guild and player names which contain the search query 
     * 
     * @param string $name The search query
     * 
     * @return array The guilds and player names that match the search query
     */
    public static function get_statsSearch(string $name) {
        $data = self::request_legacyApi('statsSearch', ["search" => rawurlencode($name)]);
        return $data;
    }

    /**
     * 
     * Gets a list of all territories and data about them
     * 
     * @return array All territory data
     */
    public static function get_territoryList() {
        $data = self::request_legacyApi('territoryList')['territories'];
        return $data;
    }

    /**
     * 
     * Gets a list of all territories held by the supplied guild
     * 
     * @param string $guildName The exact guild name
     * 
     * @return array Territory names
     */
    public static function get_guildTerritoryList(string $guildName) {
        $data = self::request_legacyApi('territoryList')['territories'];

        $return = [];

        foreach ($data as $territory) {
            if ($territory['guild'] == $guildName) {
                array_push($return, $territory['territory']);
            }
        }

        return $return;
    }

    /**
     *
     * Gets the statistics of a player
     *
     * @param    string $player The target player name or uuid
     * 
     * @return   array Array of the players statistics
     */
    public static function get_playerStats(string $player) {
        $request = "player/$player/stats";
        $data = self::request_ApiV2($request);

        return $data[0];
    }

    /**
     *
     * Gets the uuid associated with the name
     *
     * @param    string $playerName The target player name
     * 
     * @return   array The player name and uuid
     */
    public static function get_playerUuid(string $playerName) {
        $request = "player/$playerName/uuid";
        $data = self::request_ApiV2($request);

        return $data[0];
    }

    /**
     *
     * Gets a list of all crafting recipes
     *
     * @return   array All crafting recipes
     */
    public static function get_recipeList() {
        $request = "recipe/list";
        $data = self::request_ApiV2($request);

        return $data;
    }

    /**
     * 
     * Gets the data of the supplied recipe
     * 
     * @param   string $name The name of the recipe
     * 
     * @return  array The recipe data
     */
    public static function get_recipeData(string $name) {
        $request = "recipe/get/$name";
        $data = self::request_ApiV2($request);

        return $data[0];
    }

    /**
     * 
     * Simple searching for a recipe
     * 
     * @param   string $type The query type. Values: skill (profession) or type (output type)
     * @param   string $value The query value. Either a skill (profession) or type (output type)
     * 
     * @return  array The recipes that match the criteria
     */
    public static function get_simpleRecipeSearch(string $query, string $type) {
        $request = "recipe/search/$query/$type";

        $data = self::request_ApiV2($request);

        return $data;
    }

    /**
     * 
     * Complex searching for a recipe
     * 
     * @param   string $query The value to query. Values: 'level', 'durability', 'healthOrDamage', 'duration', 'basicDuration' 
     * @param   array $args Any arguments, each argument inside the array is itself an array, with the key of the argument and a value of the value. 
     * @param   string $matchingType The matching type. Values: 'OR' or 'AND'
     * 
     * @return  array The recipes that match the criteria
     */
    public static function get_complexRecipeSearch(string $query, array $args, string $matchingType = "OR") {
        switch (strtoupper($matchingType)) {
            case "OR":
                $matchingType = "^";
            break;
            case "AND":
                $matchingType = "&";
            break;
            default:
                throw new Exception("Matching type: '$matchingType' is not valid");
            break;
        }

        $request = "recipe/search/$query/$matchingType";

        foreach ($args as $arg) {
            foreach ($arg as $key => $value) {
                $request .= "$key<$value>,";
            }
        }

        $request = substr($request, 0, -1);      

        $data = self::request_ApiV2(urlencode($request));

        return $data;
    }

    /**
     *
     * Gets a list of all crafting ingredients
     *
     * @return   array All crafting ingredients
     */
    public static function get_ingredientList() {
        $request = "ingredient/list";
        $data = self::request_ApiV2($request);

        return $data;
    }

    /**
     * 
     * Gets the data of the supplied ingredient
     * 
     * @param   string $name The name of the ingredient
     * 
     * @return  array The ingredients data
     */
    public static function get_ingredientData(string $name) {
        $name = str_replace(" ", "_", $name);
        $request = "ingredient/get/$name";
        $data = self::request_ApiV2($request);

        return $data[0];
    }

    /**
     * 
     * Simple searching for a ingredient
     * 
     * @param   string $type The query type. Values: 'name', 'tier', 'level'
     * @param   string $value The query value.
     * 
     * @return  array The recipes that match the criteria
     */
    public static function get_simpleIngredientSearch(string $query, string $type) {
        $request = "ingredient/search/$query/$type";

        $data = self::request_ApiV2($request);

        return $data;
    }


    /**
     * 
     * Moderate searching for an ingredient
     * 
     * @param   string $query The value to query. Values: 'skills' 
     * @param   array $args Any arguments, each value is a value of the array
     * @param   string $matchingType The matching type. Values: 'OR' or 'AND'
     * 
     * @return  array The ingredients that match the criteria
     */
    public static function get_moderateIngredientSearch(string $query, array $args, string $matchingType = "OR") {
        switch (strtoupper($matchingType)) {
            case "OR":
                $matchingType = "^";
            break;
            case "AND":
                $matchingType = "&";
            break;
            default:
                throw new Exception("Matching type: '$matchingType' is not valid");
            break;
        }

        $request = "ingredient/search/$query/$matchingType";

        foreach ($args as $arg) {
            $request .= "$arg,";
        }

        $request = substr($request, 0, -1);      

        $data = self::request_ApiV2(urlencode($request));

        return $data;
    }

    /**
     * 
     * Complex searching for an ingredient
     * 
     * @param   string $query The value to query. Values: 'sprite', 'identifications', 'itemOnlyIDs', 'consumableOnlyIDs' 
     * @param   array $args Any arguments, each argument inside the array is itself an array, with the key of the argument and a value of the value. 
     * @param   string $matchingType The matching type. Values: 'OR' or 'AND'
     * 
     * @return  array The recipes that match the criteria
     */
    public static function get_complexIngredientSearch(string $query, array $args, string $matchingType = "OR") {
        switch (strtoupper($matchingType)) {
            case "OR":
                $matchingType = "^";
            break;
            case "AND":
                $matchingType = "&";
            break;
            default:
                throw new Exception("Matching type: '$matchingType' is not valid");
            break;
        }

        $request = "ingredient/search/$query/$matchingType";

        foreach ($args as $arg) {
            foreach ($arg as $key => $value) {
                $request .= "$key<$value>,";
            }
        }

        $request = substr($request, 0, -1); 
        
        echo $request;

        $data = self::request_ApiV2(urlencode($request));

        return $data;
    }

}

?>