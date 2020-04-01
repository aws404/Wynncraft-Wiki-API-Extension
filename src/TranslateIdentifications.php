<?php
function translateIdentification($id) {
    switch($id) {
        case "AIRDEFENSE":
            return "air_defense";
        break;
        case "EARTHDEFENSE":
            return "earth_defense";
        break;
        case "FIREDEFENSE":
            return "fire_defense";
        break;
        case "THUNDERDEFENSE":
            return "thunder_defense";
        break;
        case "WATERDEFENSE":
            return "water_defense";
        break;
        case "DAMAGEBONUS":
            return "melee_damage";
        break;
        case "DAMAGEBONUSRAW":
            return "raw_melee_damage";
        break;
        case "EARTHDAMAGEBONUS": 
            return "earth_damage";
        break;
        case "THUNDERDAMAGEBONUS":
            return "thunder_damage";
        break;
        case "WATERDAMAGEBONUS":
            return "water_damage";
        break;
        case "FIREDAMAGEBONUS":
            return "fire_damage";
        break;
        case "AIRDAMAGEBONUS":
            return "air_damage";
        break;
        case "AGILITYPOINTS":
            return "agility";
        break;
        case "DEFENSEPOINTS":
            return "defense";
        break;
        case "DEXTERITYPOINTS":
            return "dexterity";
        break;
        case "INTELLIGENCEPOINTS":
            return "intelligence";
        break;
        case "STRENGTHPOINTS":
            return "strength";
        break;
        case "POISON":
            return "poison";
        break;
        case "MANASTEAL":  
            return "mana_steal";
        break;
        case "MANAREGEN":
            return "mana_regen";
        break;
        case "SPEED":
            return "walk_speed";
        break;
        case "HEALTHBONUS":
            return "health_bonus";
        break;
        case "SPELLDAMAGE":
            return "spell_damage";
        break;
        case "SPELLDAMAGERAW":
            return "raw_spell_damage";
        break;
        case "ATTACKSPEED":
            return "attack_speed";
        break;
        case "LIFESTEAL":
            return "attack_speed";
        break;
        case "HEALTHREGEN":
            return "health_regen";
        break;
        case "HEALTHREGENRAW":
            return "raw_health_regen";
        break;
        case "REFLECTION":
            return "reflection";
        break;
        case "THORNS":
            return "thorns";
        break;
        case "EXPLODING":
            return "exploding";
        break;
        case "LOOTBONUS":
            return "loot_bonus";
        break;
        case "XPBONUS":
            return "xp_bonus";
        break;
        case "EMERALDSTEALING":
            return "stealing";
        break;
        case "SOULPOINTS":
            return "soul_point_regen";
        break;
        default:
            return "Unknown";
        break;
    };
}