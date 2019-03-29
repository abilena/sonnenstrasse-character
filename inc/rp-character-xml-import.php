<?php

function rp_character_xml_replace($search, $replace, $subject)
{
	if (strpos($subject, $search) !== false) {
		return str_replace($search, $replace, $subject);
	}
	return $subject;
}

function rp_character_xml_read_steigerungen($xml, $text, $name, $property)
{
	$steigerungen = $xml->xpath('//helden/held/ereignisse/ereignis[@text="'.$text.'" and starts-with(@obj, "'.$name.'")]');

	foreach ($steigerungen as $steigerung) {
		$kommentar = $steigerung['kommentar'];
		if (strpos($kommentar, " GP")) { $property->gp += (int)strstr($steigerung['kommentar'], " ", true); }
		if (strpos($kommentar, " AP")) { $property->ap += (int)strstr($steigerung['kommentar'], " ", true); }
		$property->value = max((int)$property->value, (int)$steigerung['Neu']);
	}
	
	$steigerungen = $xml->xpath('//helden/held/ereignisse/ereignis[@obj="'.$name.'"]');
	
	foreach ($steigerungen as $steigerung) {
		$property->ap -= (int)$steigerung['Abenteuerpunkte'];
		$property->value = max((int)$property->value, (int)$steigerung['Neu']);
	}
	
	if (($property->type == "feat") && empty($property->value)) { $property->value = null; }
	if (($property->type == "skill") && empty($property->value)) { $property->value = 0; }
	if (($property->type == "spell") && empty($property->value)) { $property->value = 0; }
	
	return $property;
}

function rp_character_xml_read_name($element, $nameattribute, $childattribute, $type)
{
	$name = $element[$nameattribute];
	$details = array();
	array_push($details, (string)@$element["value"]);
	$xml_details = $element->xpath('*/@'.$childattribute);
	foreach ($xml_details as $xml_detail)
	{
		$xml_detail_splits = explode("/", (string)$xml_detail);
		$details = array_merge($details, $xml_detail_splits);
	}
	
	$matches = null;
	if (preg_match_all("/\(([^\)]*)\)/", $name, $matches)) {
		foreach ($matches as $match) {
			array_push($details, (string)trim($match[1], "() "));
		}
		$name = preg_replace("/\(([^\)]*)\)/", "", $name);
		$matches = null;
	}

	if (($type != "skill") && ($type != "spell")) {
		$matches = null;
		if (preg_match_all("/\/([^\/]*)/", $name, $matches)) {
			foreach ($matches as $match) {
				array_push($details, (string)trim($match[1], "/ "));
			}
			$name = preg_replace("/\/([^\/]*)|/", "", $name);
			$matches = null;
		}

		$matches = null;
		if (preg_match_all("/\:([^\:]*)/", $name, $matches)) {
			foreach ($matches as $match) {
				array_push($details, (string)trim($match[1], ": "));
			}
			$name = preg_replace("/\:([^\:]*)|/", "", $name);
			$matches = null;
		}
	}
	
	$value = null;
	$varianten = array();
	foreach ($details as $detail)
	{
		if (empty($detail)) {
			continue;
		}
		else if (is_numeric((string)$detail)) {
			$value = $detail;
		}
		else {
			if (!in_array((string)$detail, $varianten)) {
				if ((string)$detail != $name) {
					array_push($varianten, (string)$detail);
					$name = trim(str_replace((string)$detail, "", $name), "/ ");
				}
			}
		}
	}
	
	$name = preg_replace('/ nach$/', '', $name);
	$name = preg_replace('/ gegen$/', '', $name);
	$name = preg_replace('/ bzgl.$/', '', $name);
	
	$property = new stdClass();
	$property->name = trim($name, "/, ");
	$property->type = $type;
	$property->info = trim(@$element['probe'], " ()");
	$property->variante = join(", ", $varianten);
	$property->value = $value;
	return $property;
}





function rp_character_import_hero($xml_content, $user, $portrait, $module)
{
   	global $wpdb;
    $db_table_name = $wpdb->prefix . 'sonnenstrasse_heroes';

	$xml = simplexml_load_string($xml_content);
	
	if ($xml === false)
	{
		return "Die hochgeladene XML Datei konnte nicht gelesen werden.";
	}

	$name = $xml->xpath('//helden/held/@name')[0];
	$setting = $xml->xpath('//helden/held/basis/settings/@name')[0];
	$gender = $xml->xpath('//helden/held/basis/geschlecht/@name')[0];
	$weight = $xml->xpath('//helden/held/basis/rasse/groesse/@gewicht')[0];
	$height = $xml->xpath('//helden/held/basis/rasse/groesse/@value')[0];
	$birth_year = $xml->xpath('//helden/held/basis/rasse/aussehen/@gbjahr')[0];
	$birth_month = $xml->xpath('//helden/held/basis/rasse/aussehen/@gbmonat')[0];
	$birth_day = $xml->xpath('//helden/held/basis/rasse/aussehen/@gbtag')[0];
	
	if ($setting != "DSA4.1")
	{
		return "Die hochgeladene XML Datei ist für das Regelsystem " . $setting . " erstellt. Für die Solo-Abenteuer können nur DSA4.1 Helden verwendet werden.";
	}
	
	$results = $wpdb->get_results("SELECT hero_id FROM $db_table_name WHERE creator='" . $user->name . "' AND name='" . $name . "'");
	if (count($results) > 0)
	{
		return "Ein Held mit diesem Namen existiert bereits. Bitte lösche erst den bestehenden Helden damit du einen neuen hochladen kannst.";
	}

    $wpdb->query('START TRANSACTION');

    $values = array(
        'party' => -1, 
        'creator' => $user->name, 
		'hero_type' => 'hero',
        'name' => $name,
		'display_name' => $name,
		'portrait' => $portrait,
		'gender' => $gender,
		'weight' => $weight,
		'height' => $height,
		'birth_year' => $birth_year,
		'birth_month' => $birth_month,
		'birth_day' => $birth_day
    );
	
    $success = $wpdb->insert($db_table_name, $values);
	
	if ($success == false)
	{
        $wpdb->query('ROLLBACK'); // // something went wrong, Rollback
		return "failed\n\nCould not insert hero.";
	}
	
	$hero = $wpdb->get_results("SELECT * FROM $db_table_name WHERE creator='" . $user->name . "' AND name='" . $name . "'");
	
	if (empty($hero) || (count($hero) != 1))
	{
        $wpdb->query('ROLLBACK'); // // something went wrong, Rollback
		return "failed\n\nCould not select hero. " . $user->name . " - " . $name;
	}

	$hero_id = $hero[0]->hero_id;

	try
	{
		rp_character_set_property_xml_basis($xml, $hero_id, "race", "rasse", "Rasse");
		rp_character_set_property_xml_basis($xml, $hero_id, "culture", "kultur", "Kultur");
		rp_character_set_property_xml_basis($xml, $hero_id, "profession", "ausbildungen/ausbildung", "Profession");
		rp_character_set_property_xml_vorteile($xml, $hero_id);
		rp_character_set_property_xml_eigenschaften($xml, $hero_id);
		rp_character_set_property_xml_talente($xml, $hero_id);
		rp_character_set_property_xml_zauber($xml, $hero_id);
		rp_character_set_property_xml_sonderfertigkeiten($xml, $hero_id);
	}
	catch (Exception $ex)
	{
        $wpdb->query('ROLLBACK'); // // something went wrong, Rollback
		return "failed\n\n$ex";
	}

	$wpdb->query('COMMIT');
	
	if (!empty($module))
	{
		// check if current module already has a hero assigned, if not assign the new one
		$hero_id = aventurien_solo_db_get_hero($module, $user->name);
		if (empty($hero_id))
		{
			$hero_id = rp_character_get_hero_id_by_name_creator($name, $user->name);
			aventurien_solo_db_set_hero($module, $user->name, $hero_id);
		}
	}
	
	return "succeeded";
}

function rp_character_set_property_xml_basis($xml, $hero_id, $type, $elementType, $elementText)
{
	$elemente = $xml->xpath('//helden/held/basis/'.$elementType);
	
	foreach ($elemente as $element)
	{
		$property = rp_character_xml_read_name($element, 'string', 'name', $type);
		$property = rp_character_xml_read_steigerungen($xml, "RKP", $elementText, $property);
		rp_character_set_property($hero_id, $property->type, $property->name, $property->variante, $property->info, $property->value, null, $property->gp, "", $property->ap, null, null, null, null, null, null);
	}
}

function rp_character_set_property_xml_vorteile($xml, $hero_id)
{
	$elemente = $xml->xpath('//helden/held/vt/vorteil');

	foreach ($elemente as $element)
	{
		$property = rp_character_xml_read_name($element, 'name', 'value', 'advantage');
		$property = rp_character_xml_read_steigerungen($xml, "VORTEILE", $element['name'], $property);
		rp_character_set_property($hero_id, $property->type, $property->name, $property->variante, $property->info, $property->value, null, $property->gp, "", $property->ap, null, null, null, null, null, null);
	}
}

function rp_character_set_property_xml_eigenschaften($xml, $hero_id)
{
	$elemente = $xml->xpath('//helden/held/eigenschaften/eigenschaft');
	
	$renaming = array(
		"ini" => "Initiative Basiswert",
		"at" => "Attacke Basiswert",
		"pa" => "Parade Basiswert",
		"fk" => "Fernkampf Basiswert"
	);
	
	$typen = array(
		"Mut" => "ability", 
		"Klugheit" => "ability", 
		"Intuition" => "ability", 
		"Charisma" => "ability", 
		"Fingerfertigkeit" => "ability", 
		"Gewandtheit" => "ability", 
		"Konstitution" => "ability", 
		"Körperkraft" => "ability",
		"Sozialstatus" => "basic",
		"Lebensenergie" => "basic",
		"Ausdauer" => "basic",
		"Astralenergie" => "basic",
		"Karmaenergie" => "basic",
		"Magieresistenz" => "basic",
		"Initiative Basiswert" => "basic",
		"Attacke Basiswert" => "basic",
		"Parade Basiswert" => "basic",
		"Fernkampf Basiswert" => "basic"
	);
	
	foreach ($elemente as $element)
	{
		$name = (string)$element['name'];
		
		$property = new stdClass();
		$property->name = (array_key_exists($name, $renaming) ? $renaming[$name] : $name);
		$property->value = (int)$element['value'];
		$property->mod = (int)$element['mod'];
		$property->type = $typen[$property->name];

		$property = rp_character_xml_read_steigerungen($xml, "EIGENSCHAFTEN", $element['name'], $property);
		rp_character_set_property($hero_id, $property->type, $property->name, $property->variante, $property->info, $property->value, $property->mod, $property->gp, "", $property->ap, null, null, null, null, null, null);
	}
}

function rp_character_set_property_xml_talente($xml, $hero_id)
{
	$elemente = $xml->xpath('//helden/held/talentliste/talent');
	
	foreach ($elemente as $element)
	{
		$property = rp_character_xml_read_name($element, 'name', 'name', 'skill');
		$property = rp_character_xml_read_steigerungen($xml, "TALENT", $element['name'], $property);
		rp_character_set_property($hero_id, $property->type, $property->name, $property->variante, $property->info, $property->value, null, $property->gp, "", $property->ap, null, null, null, null, null, null);
	}
}

function rp_character_set_property_xml_zauber($xml, $hero_id)
{
	$elemente = $xml->xpath('//helden/held/zauberliste/zauber');
	
	foreach ($elemente as $element)
	{
		$property = rp_character_xml_read_name($element, 'name', 'name', 'spell');
		$property = rp_character_xml_read_steigerungen($xml, "ZAUBER", $element['name'], $property);
		rp_character_set_property($hero_id, $property->type, $property->name, $property->variante, $property->info, $property->value, null, $property->gp, "", $property->ap, null, null, null, null, null, null);
	}
}

function rp_character_set_property_xml_sonderfertigkeiten($xml, $hero_id)
{
	$elemente = $xml->xpath('//helden/held/sf/sonderfertigkeit');
	
	foreach ($elemente as $element)
	{
		$property = rp_character_xml_read_name($element, 'name', 'name', 'feat');
		$property = rp_character_xml_read_steigerungen($xml, "SF", $element['name'], $property);
		rp_character_set_property($hero_id, $property->type, $property->name, $property->variante, $property->info, $property->value, null, $property->gp, "", $property->ap, null, null, null, null, null, null);
	}
}

?>