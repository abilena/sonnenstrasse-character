<?php

function rp_character_create_tables() {
   	global $wpdb;

    $db_table_name = $wpdb->prefix . 'sonnenstrasse_partys';
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) 
	{
		$sql = "CREATE TABLE " . $db_table_name . " (
		`party_id` mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` tinytext NOT NULL,
        `current_year` smallint NOT NULL,
        `current_month` smallint NOT NULL,
        `current_day` smallint NOT NULL,
		UNIQUE KEY party_id (party_id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	
		$values = array(
			'party_id' => -1,
			'name' => 'Anyonymous Solo Characters', 
			'current_year' => 1014, 
			'current_month' => 6,
			'current_day' => 1
		);
		$wpdb->insert($db_table_name, $values);

		$values = array(
			'party_id' => -2,
			'name' => 'Archetypen Solo Characters', 
			'current_year' => 1014, 
			'current_month' => 6,
			'current_day' => 1
		);
		$wpdb->insert($db_table_name, $values);
	}

    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) 
	{
		$sql = "CREATE TABLE " . $db_table_name . " (
		`hero_id` mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`hero_type` tinytext NOT NULL,
		`party` mediumint(9) NOT NULL,
        `creator` tinytext NOT NULL,
        `name` tinytext NOT NULL,
        `display_name` tinytext NOT NULL,
        `gender` tinytext NOT NULL,
        `status` tinytext NOT NULL,
        `title` tinytext NOT NULL,
        `portrait` tinytext NOT NULL,
        `weight` float NOT NULL,
        `height` float NOT NULL,
        `birth_year` smallint NOT NULL,
        `birth_month` smallint NOT NULL,
        `birth_day` smallint NOT NULL,
        `birth_place` tinytext NOT NULL,
        `biography` text NOT NULL,
        `flavor` text NOT NULL,
        `gold` float NOT NULL,
        `ap` mediumint,
        `ap_spent` mediumint,
		UNIQUE KEY hero_id (hero_id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

    $db_table_name = $wpdb->prefix . 'sonnenstrasse_properties';
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) 
	{
		$sql = "CREATE TABLE " . $db_table_name . " (
		`property_id` mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`hero` mediumint(9) NOT NULL,
        `type` tinytext NOT NULL,
        `name` tinytext NOT NULL,
        `group` tinytext,
        `variant` tinytext,
        `info` tinytext,
        `value` smallint,
        `mod` smallint,
        `cost` smallint,
        `gp` smallint,
        `tgp` mediumint,
        `ap` mediumint,
        `at` tinyint,
        `pa` tinyint,
        `ebe` tinytext,
        `progression` text,
        `rarity` tinyint,
        `requirements` tinytext,
        `flavor` tinytext,
        `hyperlink` tinytext,
		UNIQUE KEY property_id (property_id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	$db_table_name = $wpdb->prefix . 'sonnenstrasse_experience';
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) 
	{
		$sql = "CREATE TABLE " . $db_table_name . " (
		`experience_id` mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`hero` mediumint(9) NOT NULL,
		`adventure` tinytext NOT NULL,
		`dm` tinytext,
		`region` tinytext,
		`se` tinytext,
		UNIQUE KEY experience_id (experience_id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
}

/*
        `template` tinyint, // e.g. 0 or 1
        `at` tinyint, // e.g. 5
        `pa` tinyint, // e.g. 9 (may be NULL, if at is NULL -> not a fighting talent, if at NOT NULL and pa IS NULL -> ranged fighting talent)
        `ebe` tinytext, // e.g. BEx2
        `progression` text, // e.g. [a;B][k;B][k][p][p][p][o;-][o;-][o;-][x][x][x][x][x;-;;Spezielle Erfahrung] (a: automatic, r: racial, k: kultur, p: profession, o: tgp, x: ap, x-: se) ; (a*,a-f: SKT column) ; (0.5: factor) ; (note)
        `rarity` tinyint, // e.g. 0-7
        `requirements` tinytext, // e.g. KK 12;TaW Anderthalbhänder 7;SF Binden
*/

function rp_character_drop_tables() {
    global $wpdb;

    // delete the database tables
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . 'sonnenstrasse_properties');
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . 'sonnenstrasse_heroes');
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . 'sonnenstrasse_partys');
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . 'sonnenstrasse_experience');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Partys
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rp_character_get_partys() {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_partys';
    
    $db_results = $wpdb->get_results("SELECT * FROM $db_table_name ORDER BY name");

    return $db_results;
}

function rp_character_get_party($id) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_partys';
    
    if ($id > 0)
    {
        $results = $wpdb->get_results("SELECT * FROM $db_table_name WHERE party_id=$id");
        if (count($results) == 1)
        {
             return wp_json_encode($results[0]);
        }
    }
}

function rp_character_create_party($arguments) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_partys';

    $wpdb->query('START TRANSACTION');

    $values = array(
        'name' => $arguments['name'], 
        'current_year' => $arguments['current_year'], 
        'current_month' => $arguments['current_month'],
        'current_day' => $arguments['current_day']
    );
    $wpdb->insert($db_table_name, $values);

    $wpdb->query('COMMIT');
}

function rp_character_edit_party($arguments) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_partys';

    $wpdb->query('START TRANSACTION');

    $values = array(
        'name' => $arguments['name'], 
        'current_year' => $arguments['current_year'], 
        'current_month' => $arguments['current_month'],
        'current_day' => $arguments['current_day']
    );
    $wpdb->update($db_table_name, $values, array('party_id' => $arguments['id']));

    $wpdb->query('COMMIT');
}

function rp_character_delete_party($id) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_partys';

    $output = "";
    $output .= "id: $id\n";
    $output .= "\n";

    $deleted = FALSE;
    $wpdb->query('START TRANSACTION');

    if ($id > 0)
    {
        $results = $wpdb->get_results("SELECT * FROM $db_table_name WHERE party_id=$id");
        if (count($results) == 0)
        {
            $output .= "party with id $id not found in table!\n";
            $output .= "\n";
        }
        else
        {
            $rows = $wpdb->query("DELETE FROM $db_table_name WHERE party_id=$id");
            
            if ($rows == 1)
            {
                $deleted = TRUE;
            }
        }
    }

    if ($deleted === TRUE)
    {
        $wpdb->query('COMMIT'); // if you come here then well done
        return "succeeded";
    }
    else {
        $wpdb->query('ROLLBACK'); // // something went wrong, Rollback
        return "failed\n\n" . $output;
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Heroes
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rp_character_get_heroes($party_id) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';
    
    $db_results = $wpdb->get_results("SELECT * FROM $db_table_name WHERE party=$party_id ORDER BY name");

    return $db_results;
}

function rp_character_get_hero($hero_id) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';
    
    $db_results = $wpdb->get_results("SELECT * FROM $db_table_name WHERE hero_id=$hero_id");

    if (count($db_results) > 0) {
        return $db_results[0];
    }

    $hero = new stdClass();
    $hero->hero_id = null;
    $hero->name = "";
    $hero->display_name = "";
    $hero->portrait = "";
    $hero->ap = 0;
    $hero->ap_spent = 0;
    return $hero;
}

function rp_character_get_hero_id_by_name($name) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';
    
    $id = $wpdb->get_var("SELECT hero_id FROM $db_table_name WHERE name='$name'");

    return $id;
}

function rp_character_get_hero_id_by_name_creator($name, $creator) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';
    
    $id = $wpdb->get_var("SELECT hero_id FROM $db_table_name WHERE name='$name' AND creator='$creator'");

    return $id;
}

function rp_character_create_hero($arguments) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';

    $wpdb->query('START TRANSACTION');

    $values = array(
        'party' => $arguments['party_id'], 
        'creator' => wp_get_current_user()->user_login, 
        'name' => "Neuer Held"
    );
    $wpdb->insert($db_table_name, $values);

    $wpdb->query('COMMIT');    
}

function rp_character_create_hero_from_archetype($archetype_id, $user, $party) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';

	$hero = rp_character_get_hero($archetype_id);
	$hero->hero_type = "hero";
	$hero->creator = $user;
	$hero->party = $party;
	unset($hero->hero_id);
	
    $wpdb->query('START TRANSACTION');

    $inserted = $wpdb->insert($db_table_name, (array) $hero);
    $hero_id = $wpdb->insert_id;
	if (($inserted !== 1) || empty($hero_id))
	{
        $wpdb->query('ROLLBACK'); // // something went wrong, Rollback
		return false;
	}
	
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_properties';
    $properties = $wpdb->get_results("SELECT * FROM $db_table_name WHERE hero=$archetype_id");
    foreach ($properties as $property)
    {
        unset($property->property_id);
        $property->hero = $hero_id;

        $succeeded = $wpdb->insert($db_table_name, (array) $property);
	
        if ($succeeded == false)
        {
            $type = $property->type;
            $name = $property->name;
            throw new Exception('Failed to set property $type on hero $hero_id with value $name.');
        }
    }
	
	if (function_exists("rp_inventory_hero_html_by_id"))
	{
		$db_table_name = $wpdb->prefix . 'sonnenstrasse_inventory';
		$items = $wpdb->get_results("SELECT * FROM $db_table_name WHERE owner=$archetype_id");
		foreach ($items as $item)
		{
			unset($item->item_id);
			$item->owner = $hero_id;

			$succeeded = $wpdb->insert($db_table_name, (array) $item);
		
			if ($succeeded == false)
			{
				$name = $item->name;
				throw new Exception('Failed to copy item $name to hero $hero_id.');
			}
		}
	}

    $wpdb->query('COMMIT');
	return $hero_id;
}

function rp_character_get_heroes_of_user($user) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';
    
    $heroes = $wpdb->get_results("SELECT * FROM $db_table_name WHERE (creator='$user') AND (hero_type='hero' OR hero_type='shared')");

    return $heroes;
}

function rp_character_upload_hero($xml_content, $user, $portrait, $module) {
	
	return rp_character_import_hero($xml_content, $user, $portrait, $module);

}


function rp_character_delete_hero($hero_id, $module = null, $user = null)
{
   	global $wpdb;

	$wpdb->query('START TRANSACTION');

	$deleted = $wpdb->delete($wpdb->prefix . 'sonnenstrasse_heroes', array('hero_id' => $hero_id));
	
	if ($deleted !== 1)
    {
        $wpdb->query('ROLLBACK'); // // something went wrong, Rollback
		return "failed\n\n";
    }

	$wpdb->delete($wpdb->prefix . 'sonnenstrasse_properties', array('hero' => $hero_id));
	$wpdb->delete($wpdb->prefix . 'sonnenstrasse_solo_states', array('hero_id' => $hero_id));

	if (!empty($module))
	{
		// check if current module already has a hero assigned, if not assign the new one
		$solo_hero_id = aventurien_solo_db_get_hero($module, $user);
		if (empty($solo_hero_id))
		{
			$results = $wpdb->get_results("SELECT hero_id FROM " . $wpdb->prefix . "sonnenstrasse_heroes WHERE creator='$user' ORDER BY hero_id LIMIT 1");
			$solo_hero_id = (count($results) > 0) ? $results[0]->hero_id : null;
			aventurien_solo_db_set_hero($module, $user, $solo_hero_id);
		}
	}
	
	$wpdb->query('COMMIT');

	return "succeeded";
}

function rp_character_regroup_hero($hero_id, $group_id) {
	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';

    $wpdb->query('START TRANSACTION');

    $updated = $wpdb->update($db_table_name, array('party' => $group_id), array('hero_id' => $hero_id));
	
    $wpdb->query('COMMIT');

	return "succeeded";
}

function rp_character_invest_ap_hero($hero_id, $ap) {
	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';

    $wpdb->query('START TRANSACTION');

    $updated = $wpdb->update($db_table_name, array('ap' => $ap), array('hero_id' => $hero_id));
	
    $wpdb->query('COMMIT');

	return "succeeded";
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Properties
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rp_character_get_properties($hero_id, $property_type) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_properties';
    
    $db_results = $wpdb->get_results("SELECT * FROM $db_table_name WHERE hero=$hero_id AND type LIKE '$property_type' ORDER BY name");

    return $db_results;
}

function rp_character_property_format_cost($cost) {
    if ($cost == NULL) {
        return "";
    } else if ($cost == 0) {
        return "-";
    } else {
        return $cost;
    }
}

function rp_character_property_parse_cost($value) {
    if ($value == "") {
        return NULL;
    } else if ($value == "-") {
        return 0;
    } else {
        return $value;
    }
}

function rp_character_set_property($hero_id, $type, $name, $variant, $info, $value, $mod, $cost, $gp, $tgp, $ap, $at, $pa, $ebe, $rarity, $requirements, $progression, $group, $flavor, $hyperlink) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_properties';

    $values = array(
		'hero' => $hero_id, 
        'type' => $type, 
        'name' => $name, 
        'variant' => $variant, 
        'info' => $info, 
        'value' => $value, 
        'mod' => $mod,
		'cost' => $cost,
        'gp' => rp_character_property_parse_cost($gp), 
        'tgp' => rp_character_property_parse_cost($tgp), 
        'ap' => rp_character_property_parse_cost($ap), 
        'at' => $at, 
        'pa' => $pa, 
        'ebe' => $ebe, 
        'rarity' => $rarity, 
        'requirements' => $requirements, 
        'progression' => $progression, 
        'group' => $group, 
        'flavor' => $flavor, 
        'hyperlink' => $hyperlink
    );

    $succeeded = $wpdb->insert($db_table_name, $values);
	
	if ($succeeded == false)
	{
		throw new Exception('Failed to set property $type on hero $hero_id with value $name.');
	}
}

function rp_character_edit_property($arguments) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_properties';

    if (empty($arguments['name'])) {
        return;
    }

    $wpdb->query('START TRANSACTION');

    $id = $arguments['property_id'];
    $values = array(
		'hero' => $arguments['hero'], 
        'type' => $arguments['type'], 
        'name' => $arguments['name'], 
        'mod' => $arguments['mod'], 
        'info' => $arguments['info'], 
        'value' => $arguments['value'], 
        'variant' => $arguments['variant'], 
		'cost' => rp_character_property_parse_cost($arguments['cost']), 
        'gp' => rp_character_property_parse_cost($arguments['gp']), 
        'tgp' => rp_character_property_parse_cost($arguments['tgp']), 
        'ap' => rp_character_property_parse_cost($arguments['ap']), 
        'at' => $arguments['at'], 
        'pa' => $arguments['pa'], 
        'ebe' => $arguments['ebe'], 
        'rarity' => $arguments['rarity'], 
        'requirements' => $arguments['requirements'], 
        'progression' => $arguments['progression'], 
        'group' => $arguments['group'], 
        'flavor' => $arguments['flavor'], 
        'hyperlink' => $arguments['hyperlink']
    );

    if ($id > 0) {
        $wpdb->update($db_table_name, $values, array('property_id' => $arguments['property_id']));
    } else {
        $wpdb->insert($db_table_name, $values);
    }

    $wpdb->query('COMMIT');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Details
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rp_character_get_detail($hero_id, $detail_type) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';

    $detail_value = $wpdb->get_var("SELECT $detail_type FROM $db_table_name WHERE hero_id=$hero_id");

    return $detail_value;
}

function rp_character_edit_detail($arguments) {
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';

    $wpdb->query('START TRANSACTION');

    $id = $arguments['hero'];
    $type = $arguments['type'];
    $value = htmlentities(stripslashes($arguments['value']));
    $updated = FALSE;

    $hero = rp_character_get_hero($id);
    if (empty($hero) || empty($hero->name))
    {
        $output .= "A hero with id $id was not found in table!\n";
        $output .= "\n";
    }
    else {
        $old_value = rp_character_get_detail($id, $type);
        if ($old_value === $value) {
            $updated = 1;
        }
        else {
            $updated = $wpdb->update($db_table_name, array($type => $value), array('hero_id' => $id));
        }
    }

    if ($updated === 1)
    {
        $wpdb->query('COMMIT'); // if you come here then well done
        return "succeeded";
    }
    else {
        $wpdb->query('ROLLBACK'); // // something went wrong, Rollback
        return "failed\n\n" . $output;
    }
}

?>