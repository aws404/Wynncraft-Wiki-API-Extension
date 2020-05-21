<?php

class Requirements {
    private const Requirements = array(
        "quest",
        "classRequirement",
        "strength",
        "dexterity",
        "intelligence",
        "defense",
        "agility"
    );

    public static function isRequirement($input) {
        return in_array($input, self::Requirements);
    }
}

class Damages {
    private const Damages = array(
        "NEUTRALDAMAGE" => array("name" => "NEUTRALDAMAGE", "display" => "Neutral Damage", "legacyName" => "damage"),
        "AIRDAMAGE" => array("name" => "AIRDAMAGE", "display" => "Air Damage", "legacyName" => "airDamage"),
        "THUNDERDAMAGE" => array("name" => "THUNDERDAMAGE", "display" => "Thunder Damage", "legacyName" => "thunderDamage"),
        "WATERDAMAGE" => array("name" => "WATERDAMAGE", "display" => "Water Damage", "legacyName" => "waterDamage"),
        "EARTHDAMAGE" => array("name" => "EARTHDAMAGE", "display" => "Earth Damage", "legacyName" => "earthDamage"),
        "FIREDAMAGE" => array("name" => "FIREDAMAGE", "display" => "Fire Damage", "legacyName" => "fireDamage"),
    );

    public static function getFromLegacyName($name) {
        foreach (self::Damages as $id => $value) {
            if ($name == $value['legacyName']) {
                return self::Damages[$id];
            }
        }
        return array("name" => "NOTFOUND", "display" => "Not Found", "legacyName" => "notFound");
    }

    public static function getFromName($name) {
        if (array_key_exists($name, self::Damages)) {
            return self::Damages[$name];
        }
        return array("name" => "NOTFOUND", "display" => "Not Found", "legacyName" => "notFound");
    }
}

class Defenses {
    private const Defenses = array(
        "AIRDEFENSE" => array("name" => "AIRDEFENSE", "display" => "Air Defence", "legacyName" => "airDefense"),
        "THUNDERDEFENSE" => array("name" => "THUNDERDEFENSE", "display" => "Thunder Defence", "legacyName" => "thunderDefense"),
        "WATERDEFENSE" => array("name" => "WATERDEFENSE", "display" => "Water Defence", "legacyName" => "waterDefense"),
        "EARTHDEFENSE" => array("name" => "EARTHDEFENSE", "display" => "Earth Defence", "legacyName" => "earthDefense"),
        "FIREDEFENSE" => array("name" => "FIREDEFENSE", "display" => "Fire Defence", "legacyName" => "fireDefense"),
    );

    public static function getFromLegacyName($name) {
        foreach (self::Defenses as $id => $value) {
            if ($name == $value['legacyName']) {
                return self::Defenses[$id];
            }
        }
        return array("name" => "NOTFOUND", "display" => "Not Found", "legacyName" => "notFound");
    }

    public static function getFromName($name) {
        if (array_key_exists($name, self::Defenses)) {
            return self::Defenses[$name];
        }
        return array("name" => "NOTFOUND", "display" => "Not Found", "legacyName" => "notFound");
    }
}

class Identifications {
    private const Ids = array(
        "AIRDEFENSE" => array("name" => "AIRDEFENSE", "display" => "Air Defense", "legacyName" => "bonusAirDefense", "single" => false, "templateName" => "air_defense"),
        "EARTHDEFENSE" => array("name" => "EARTHDEFENSE", "display" => "Earth Defense", "legacyName" => "bonusEarthDefense", "single" => false, "templateName" => "earth_defense"),
        "FIREDEFENSE" => array("name" => "FIREDEFENSE", "display" => "Fire Defense", "legacyName" => "bonusFireDefense", "single" => false, "templateName" => "earth_defense"),
        "THUNDERDEFENSE" => array("name" => "THUNDERDEFENSE", "display" => "Thunder Defense", "legacyName" => "bonusThunderDefense", "single" => false, "templateName" => "thunder_defense"),
        "WATERDEFENSE" => array("name" => "WATERDEFENSE", "display" => "Water Defense", "legacyName" => "bonusWaterDefense", "single" => false, "templateName" => "water_defense"),

        "DAMAGEBONUS" => array("name" => "DAMAGEBONUS", "display" => "Water Defence", "legacyName" => "damageBonus", "single" => false, "templateName" => "melee_damage"),
        "DAMAGEBONUSRAW" => array("name" => "DAMAGEBONUSRAW", "display" => "Water Defence", "legacyName" => "damageBonusRaw", "single" => false, "templateName" => "raw_melee_damage"),

        "AIRDAMAGEBONUS" => array("name" => "AIRDAMAGEBONUS", "display" => "Air Damage", "legacyName" => "bonusAirDamage", "single" => false, "templateName" => "air_damage"),
        "EARTHDAMAGEBONUS" => array("name" => "EARTHDAMAGEBONUS", "display" => "Earth Damage", "legacyName" => "bonusEarthDamage", "single" => false, "templateName" => "earth_damage"),
        "FIREDAMAGEBONUS" => array("name" => "FIREDAMAGEBONUS", "display" => "Fire Damage", "legacyName" => "bonusFireDamage", "single" => false, "templateName" => "fire_damage"),
        "THUNDERDAMAGEBONUS" => array("name" => "THUNDERDAMAGEBONUS", "display" => "Thunder Damage", "legacyName" => "bonusThunderDamage", "single" => false, "templateName" => "thunder_damage"),
        "WATERDAMAGEBONUS" => array("name" => "WATERDAMAGEBONUS", "display" => "Water Damage", "legacyName" => "bonusWaterDamage", "single" => false, "templateName" => "water_damage"),

        "AGILITYPOINTS" => array("name" => "AGILITYPOINTS", "display" => "Agility", "legacyName" => "agilityPoints", "single" => true, "templateName" => "agility"),
        "DEFENSEPOINTS" => array("name" => "DEFENSEPOINTS", "display" => "Defence", "legacyName" => "defensePoints", "single" => true, "templateName" => "defense"),
        "DEXTERITYPOINTS" => array("name" => "DEXTERITYPOINTS", "display" => "Dexterity", "legacyName" => "dexterityPoints", "single" => true, "templateName" => "dexterity"),
        "INTELLIGENCEPOINTS" => array("name" => "INTELLIGENCEPOINTS", "display" => "Intelligence", "legacyName" => "intelligencePoints", "single" => true, "templateName" => "intelligence"),
        "STRENGTHPOINTS" => array("name" => "STRENGTHPOINTS", "display" => "Strength", "legacyName" => "strengthPoints", "single" => true, "templateName" => "strength"),
        
        "MANASTEAL" => array("name" => "MANASTEAL", "display" => "Mana Steal", "legacyName" => "manaSteal", "single" => false, "templateName" => "mana_steal"),
        "MANAREGEN" => array("name" => "MANAREGEN", "display" => "Mana Regen", "legacyName" => "manaRegen", "single" => false, "templateName" => "mana_regen"),
    
        "SPELLDAMAGE" => array("name" => "SPELLDAMAGE", "display" => "Spell Damage", "legacyName" => "spellDamage", "single" => false, "templateName" => "spell_damage"),
        "SPELLDAMAGERAW" => array("name" => "SPELLDAMAGERAW", "display" => "Spell Damage Raw", "legacyName" => "spellDamageRaw", "single" => false, "templateName" => "raw_spell_damage"),
        "RAINBOWSPELLDAMAGERAW" => array("name" => "RAINBOWSPELLDAMAGERAW", "display" => "Rainbow Spell Damage Raw", "legacyName" => "rainbowSpellDamageRaw", "single" => false, "templateName" => "raw_rainbow_spell_damage"),
    
        "HEALTHBONUS" => array("name" => "HEALTHBONUS", "display" => "Health Bonus", "legacyName" => "healthBonus", "single" => false, "templateName" => "health_bonus"),
        "HEALTHREGEN" => array("name" => "HEALTHREGEN", "display" => "Health Regen", "legacyName" => "healthRegen", "single" => false, "templateName" => "health_regen"),
        "HEALTHREGENRAW" => array("name" => "HEALTHREGENRAW", "display" => "Health Regen Raw", "legacyName" => "healthRegenRaw", "single" => false, "templateName" => "raw_health_regen"),
    
        "POISON" => array("name" => "POISON", "display" => "Poison", "legacyName" => "poison", "single" => false, "templateName" => "poison"),
        "ATTACKSPEED" => array("name" => "ATTACKSPEED", "display" => "Attack Speed", "legacyName" => "attackSpeedBonus", "single" => false, "templateName" => "attack_speed"),
        "LIFESTEAL" => array("name" => "LIFESTEAL", "display" => "Life Steal", "legacyName" => "lifeSteal", "single" => false, "templateName" => "life_steal"),
        "REFLECTION" => array("name" => "REFLECTION", "display" => "Reflection", "legacyName" => "reflection", "single" => false, "templateName" => "reflection"),
        "THORNS" => array("name" => "THORNS", "display" => "Thorns", "legacyName" => "thorns", "single" => false, "templateName" => "thorns"),
        "EXPLODING" => array("name" => "EXPLODING", "display" => "Exploding", "legacyName" => "exploding", "single" => false, "templateName" => "exploding"),
        "EMERALDSTEALING" => array("name" => "EMERALDSTEALING", "display" => "Stealing", "legacyName" => "emeraldStealing", "single" => false, "templateName" => "stealing"),
        "SOULPOINTS" => array("name" => "SOULPOINTS", "display" => "Soul Point Bonus", "legacyName" => "soulPoints", "single" => false, "templateName" => "soul_point_regen"),

        "LOOTBONUS" => array("name" => "LOOTBONUS", "display" => "Loot Bonus", "legacyName" => "lootBonus", "single" => false, "templateName" => "loot_bonus"),
        "LOOTQUALITY" => array("name" => "LOOTQUALITY", "display" => "Loot Quality", "legacyName" => "lootQuality", "single" => false, "templateName" => "loot_quality"),
        "XPBONUS" => array("name" => "XPBONUS", "display" => "XP Bonus", "legacyName" => "xpBonus", "single" => false, "templateName" => "xp_bonus"),
        
        "GATHERXPBONUS" => array("name" => "GATHERXPBONUS", "display" => "Gathering XP Bonus", "legacyName" => "gatherXpBonus", "single" => false, "templateName" => "gather_xp_bonus"),
        "GATHERSPEED" => array("name" => "GATHERSPEED", "display" => "Gathering Speed", "legacyName" => "gatherSpeed", "single" => false, "templateName" => "gather_speed"),
        
        "SPELLCOSTPCT1" => array("name" => "SPELLCOSTPCT1", "display" => "1st Spell Cost", "legacyName" => "spellCostPct1", "single" => false, "templateName" => "first_spell_cost"),
        "SPELLCOSTRAW1" => array("name" => "SPELLCOSTRAW1", "display" => "1st Spell Cost Raw", "legacyName" => "spellCostRaw1", "single" => false, "templateName" => "raw_first_spell_cost"),
        "SPELLCOSTPCT2" => array("name" => "SPELLCOSTPCT2", "display" => "2nd Spell Cost", "legacyName" => "spellCostPct2", "single" => false, "templateName" => "second_spell_cost"),
        "SPELLCOSTRAW2" => array("name" => "SPELLCOSTRAW2", "display" => "2nd Spell Cost Raw", "legacyName" => "spellCostRaw2", "single" => false, "templateName" => "raw_second_spell_cost"),
        "SPELLCOSTPCT3" => array("name" => "SPELLCOSTPCT3", "display" => "3rd Spell Cost", "legacyName" => "spellCostPct3", "single" => false, "templateName" => "third_spell_cost"),
        "SPELLCOSTRAW3" => array("name" => "SPELLCOSTRAW3", "display" => "3rd Spell Cost Raw", "legacyName" => "spellCostRaw3", "single" => false, "templateName" => "raw_third_spell_cost"),
        "SPELLCOSTPCT4" => array("name" => "SPELLCOSTPCT4", "display" => "4th Spell Cost", "legacyName" => "spellCostPct4", "single" => false, "templateName" => "fourth_spell_cost"),
        "SPELLCOSTRAW4" => array("name" => "SPELLCOSTRAW4", "display" => "4th Spell Cost Raw", "legacyName" => "spellCostRaw4", "single" => false, "templateName" => "raw_fourth_spell_cost"),
    
        "SPEED" => array("name" => "SPEED", "display" => "Walk Speed", "legacyName" => "speed", "single" => false, "templateName" => "walk_speed"),
        "SPRINT" => array("name" => "SPRINT", "display" => "Sprint", "legacyName" => "sprint", "single" => false, "templateName" => "sprint_bonus"),
        "SPRINTREGEN" => array("name" => "SPRINTREGEN", "display" => "Sprint Regen", "legacyName" => "sprintRegen", "single" => false, "templateName" => "sprint_regen"),
        "JUMPHEIGHT" => array("name" => "JUMPHEIGHT", "display" => "Jump Height", "legacyName" => "jumpHeight", "single" => false, "templateName" => "jump_height"),
    
    );

    public static function getFromLegacyName($name) {
        foreach (self::Ids as $id => $value) {
            if ($name == $value['legacyName']) {
                return self::Ids[$id];
            }
        }
        return array("name" => "NOTFOUND", "display" => "Not Found", "legacyName" => "notFound");
    }

    public static function getFromName($name) {
        if (array_key_exists($name, self::Ids)) {
            return self::Ids[$name];
        }
        return array("name" => "NOTFOUND", "display" => "Not Found", "legacyName" => "notFound");
    }
}















?>