<?php

require_once('rp-character-constants.php');
require_once('rp-character-database.php');

function rp_character_hero_html($name) {

    $path_local = plugin_dir_path(__FILE__);
    $path_url = plugins_url() . "/sonnenstrasse-character";

    $output = "";

    $hero_id = rp_character_get_hero_id_by_name($name);
    if (empty($hero_id) or ($hero_id < 0)) {
        $hero_id = 0;
    }

    if ($hero_id == 0) {
        $output .= "<i>unknown hero '$name' </i>";
    }
    else {
		$output .= rp_character_hero_html_by_id($hero_id, "", "", "", false);
		
		/*
        rp_character_get_item_containers($hero_id, $name, $container_ids, $container_content, $container_orders);

        $header_content = "";
        $is_user = is_user_logged_in();
        $is_admin = user_can(wp_get_current_user(), 'administrator');
        $is_owner = ($hero->creator == wp_get_current_user()->user_login);

        if ($is_admin) {
            $icon_files = RPInventory\get_all_files($path_local . "../img/icons/");
            $icon_files_html = implode(":", $icon_files);

            $tpl_inventory_header = new RPInventory\Template($path_local . "../tpl/inventory_header.html");
            $tpl_inventory_header->set("Owner", $hero_id);
            $tpl_inventory_header->set("IconsList", $icon_files_html);
            $header_content .= $tpl_inventory_header->output();
        }

        $output = "";
        $containers_html = "";
        $index = 0;
        foreach ($container_orders as $hosts_container_order => $hosts_container_id) {

            $container = $container_ids[$hosts_container_id];
            $contained_items = $container_content[$hosts_container_id];
            $container_html = rp_inventory_itemcontainer_html($hero_id, FALSE, FALSE, $is_user, $is_admin, $is_owner, $container, $contained_items, $hosts_container_id, $index, 0);

            $containers_html .= $container_html;
            $index++;
        }

        $tpl_inventory = new RPInventory\Template($path_local . "../tpl/inventory.html");
        $tpl_inventory->set("PluginBaseUri", $path_url);
        $tpl_inventory->set("HeaderContent", $header_content);
        $tpl_inventory->set("Containers", $containers_html);
        $output .= $tpl_inventory->output();
		*/
    }

	return $output;
}

function rp_character_hero_html_by_id($hero_id, $solo_user, $style, $solo_module, $allowSelection)
{
    $path_local = plugin_dir_path(__FILE__);
	$path_url = plugins_url() . "/sonnenstrasse-character";
	
	$output = "";
	$hero = rp_character_get_hero($hero_id);
	$full_html = rp_character_hero_full_html($hero, $solo_user);
	$selector_html = $allowSelection ? rp_character_hero_selector_html($solo_user, $hero, $solo_module) : $hero->name;
	
	if ($style == "compact")
	{
		$archetypes_html = rp_character_hero_archetypes_html($solo_module);
		
		$tpl_character = new Sonnenstrasse\Template($path_local . "../tpl/page/character.compact.html");
		$tpl_character->setObject($hero);
		$tpl_character->set("PluginBaseUri", $path_url);
		$tpl_character->set("Character", $selector_html);
		$tpl_character->set("CharacterAvailable", (!empty($hero->hero_id) && $allowSelection) ? "available" : "empty");
		$tpl_character->set("Portrait", (empty($hero->portrait) ? ($path_url . "/../sonnenstrasse-base/img/glow2.gif") : ($path_url . "/../../uploads/portraits/" . $hero->portrait)));
		$tpl_character->set("PortraitClass", (empty($hero->portrait) ? "empty" : "image"));
		$tpl_character->set("Module", $solo_module);
		$tpl_character->set("Content", $full_html);
		$tpl_character->set("Archetypes", $archetypes_html);
		$output = $tpl_character->output();
	}
	else
	{
		$tpl_window = new Sonnenstrasse\Template($path_local . "../tpl/page/character.window.html");
		$tpl_window->set("WindowContent", $full_html);
		$tpl_window->set("WindowTitle", $hero->name); 
		$output = $tpl_window->output();
	}
	
	return $output;
}

function rp_character_hero_html_by_id_old($hero_id, $solo_user, $style, $solo_module, $allowSelection)
{
    $path_local = plugin_dir_path(__FILE__);
	$path_url = plugins_url() . "/sonnenstrasse-character";

	$portrait_class = "";
	if (isset($hero_id) && $hero_id > 0) {
		$hero = rp_character_get_hero($hero_id);
		$portrait_class = "image";
	}
	else {
		$hero = new stdClass();
		$hero->name = "";
		$hero->display_name = "";
		$hero->portrait = "";
		$portrait_class = "empty";
	}
		
	$character_html = "";
	if ($allowSelection)
	{
		$character_html = rp_character_hero_selector_html($solo_user, $hero, $solo_module);
	}
	else
	{
		$character_html = $hero->name;
	}

	$inventory_html = "";
	if (function_exists("rp_inventory_hero_html_by_id"))
	{
		$inventory_html = rp_inventory_hero_html_by_id($hero_id, $hero->name);
	}
	
	$tpl_character = new Sonnenstrasse\Template($path_local . "../tpl/page/character.html");
	$tpl_character->set("Hero", $hero_id);
	$tpl_character->set("PluginBaseUri", $path_url);
	$tpl_character->set("Character", $character_html);
	$tpl_character->set("Module", $solo_module);
	$tpl_character->set("Portrait", $path_url . "/../../uploads/portraits/" . $hero->portrait);
	$tpl_character->set("PortraitClass", $portrait_class);
	$tpl_character->set("Content", "");
	$tpl_character->set("Inventory", $inventory_html);
	$output = $tpl_character->output();
	
	return $output;
}

function rp_character_get_simple_proprerties($hero_id, $property_type)
{
	$result = array();
	$properties = rp_character_get_properties($hero_id, $property_type);
	
	foreach ($properties as $property)
	{
		$result[$property->name] = $property;
	}
	
	return $result;
}

function rp_character_clone_property($property)
{
	if (empty($property)) {
		return new stdClass();
	}
	return (object) clone $property;
}

function rp_character_progression_decode_native($string)
{
    $steps = array();
    $string_steps = explode("|", $string);
    foreach ($string_steps as $string_step)
    {
        $details = explode(";", $string_step);
        $step = new stdClass();
        $step->source = ((count($details) > 0) ? $details[0] : "");
        $step->category = ((count($details) > 1) ? $details[1] : "");
        $step->factor = ((count($details) > 2) ? floatval($details[2]) : 1.0);
        $step->text = ((count($details) > 3) ? $details[3] : "");
        array_push($steps, $step);
    }
    return $steps;
}

function rp_character_progression_encode_html($steps)
{
    $progression_html = "";
    foreach ($steps as $step)
    {
        $source = strtolower($step->source);
        $text = $step->text;
        if (empty($text)) {
            $progression_html .= "<span class=\"step $source\"></span>";
        } else {
            $progression_html .= "<span class=\"step $source\" data-tooltip=\"SE: $text\"></span>";
        }
    }
    return $progression_html;
}

function rp_character_calculate_basic_properties($basissteigerungen, $eigenschaften, $vorteile, $sonderfertigkeiten)
{
	$mu = intval(@$eigenschaften['Mut']->value);
	$kl = intval(@$eigenschaften['Klugheit']->value);
	$in = intval(@$eigenschaften['Intuition']->value);
	$ch = intval(@$eigenschaften['Charisma']->value);
	$ff = intval(@$eigenschaften['Fingerfertigkeit']->value);
	$ge = intval(@$eigenschaften['Gewandtheit']->value);
	$ko = intval(@$eigenschaften['Konstitution']->value);
	$kk = intval(@$eigenschaften['Körperkraft']->value);

	$basiswerte = array();
	$basiswerte['Geschwindigkeit']      = rp_character_clone_property(@$basissteigerungen['Geschwindigkeit']);
	$basiswerte['Magieresistenz']       = rp_character_clone_property(@$basissteigerungen['Magieresistenz']);
	$basiswerte['Initiative Basiswert'] = rp_character_clone_property(@$basissteigerungen['Initiative Basiswert']);
	$basiswerte['Attacke Basiswert']    = rp_character_clone_property(@$basissteigerungen['Attacke Basiswert']);
	$basiswerte['Parade Basiswert']     = rp_character_clone_property(@$basissteigerungen['Parade Basiswert']);
	$basiswerte['Fernkampf Basiswert']  = rp_character_clone_property(@$basissteigerungen['Fernkampf Basiswert']);
	$basiswerte['Ausweichen']           = rp_character_clone_property(@$basissteigerungen['Parade Basiswert']);

	$basiswerte['Geschwindigkeit']->value      = round(8) + @$basissteigerungen['Geschwindigkeit']->mod;
	$basiswerte['Magieresistenz']->value       = round(($mu + $kl + $ko) / 5) + @$basissteigerungen['Magieresistenz']->value + @$basissteigerungen['Magieresistenz']->mod;
	$basiswerte['Initiative Basiswert']->value = round(($mu + $mu + $in + $ge) / 5);
	$basiswerte['Attacke Basiswert']->value    = round(($mu + $ge + $kk) / 5);
	$basiswerte['Parade Basiswert']->value     = round(($in + $ge + $kk) / 5);
	$basiswerte['Fernkampf Basiswert']->value  = round(($in + $ff + $kk) / 5);

	$basiswerte['Geschwindigkeit']->name = "Geschwindigkeit";
	$basiswerte['Magieresistenz']->name = "Magieresistenz";
	$basiswerte['Initiative Basiswert']->name = "Initiative Basiswert";
	$basiswerte['Attacke Basiswert']->name = "Attacke Basiswert";
	$basiswerte['Parade Basiswert']->name = "Parade Basiswert";
	$basiswerte['Fernkampf Basiswert']->name = "Fernkampf Basiswert";

	@$basissteigerungen['Geschwindigkeit']->value = "0";
	@$basissteigerungen['Initiative Basiswert']->value = "0";
	@$basissteigerungen['Attacke Basiswert']->value = "0";
	@$basissteigerungen['Parade Basiswert']->value = "0";
	@$basissteigerungen['Fernkampf Basiswert']->value = "0";

	return $basiswerte;
}

function rp_character_calculate_energy_properties($basissteigerungen, $eigenschaften, $vorteile, $sonderfertigkeiten)
{
	$mu = intval(@$eigenschaften['Mut']->value);
	$kl = intval(@$eigenschaften['Klugheit']->value);
	$in = intval(@$eigenschaften['Intuition']->value);
	$ch = intval(@$eigenschaften['Charisma']->value);
	$ff = intval(@$eigenschaften['Fingerfertigkeit']->value);
	$ge = intval(@$eigenschaften['Gewandtheit']->value);
	$ko = intval(@$eigenschaften['Konstitution']->value);
	$kk = intval(@$eigenschaften['Körperkraft']->value);
	$is_zauberer  = (array_key_exists("Vollzauberer", $vorteile) || 
					 array_key_exists("Halbzauberer", $vorteile) || 
					 array_key_exists("Viertelzauberer", $vorteile));
	$is_geweihter = (array_key_exists("Geweiht [nicht-alveranische Gottheit]", $vorteile) || 
					 array_key_exists("Geweiht [zwölfgöttliche Kirche]", $vorteile) || 
					 array_key_exists("Spätweihe Alveranische Gottheit", $sonderfertigkeiten) || 
					 array_key_exists("Spätweihe Nichtalveranische Gottheit", $sonderfertigkeiten));

	$energiewerte = array();
	$energiewerte['Lebensenergie'] = rp_character_clone_property(@$basissteigerungen['Lebensenergie']);
	$energiewerte['Ausdauer']      = rp_character_clone_property(@$basissteigerungen['Ausdauer']);
	$energiewerte['Astralenergie'] = rp_character_clone_property(@$basissteigerungen['Astralenergie']);
	$energiewerte['Karmaenergie']  = rp_character_clone_property(@$basissteigerungen['Karmaenergie']);

	$energiewerte['Lebensenergie']->value = round(($ko + $ko + $kk) / 2) + intval(@$basissteigerungen['Lebensenergie']->value) + intval(@$basissteigerungen['Lebensenergie']->mod);
	$energiewerte['Ausdauer']->value      = round(($mu + $ko + $ge) / 2) + intval(@$basissteigerungen['Ausdauer']->value)      + intval(@$basissteigerungen['Ausdauer']->mod);
	$energiewerte['Astralenergie']->value = round(($mu + $in + $ch) / 2) + intval(@$basissteigerungen['Astralenergie']->value) + intval(@$basissteigerungen['Astralenergie']->mod);
	$energiewerte['Karmaenergie']->value  =                                intval(@$basissteigerungen['Karmaenergie']->value)  + intval(@$basissteigerungen['Astralenergie']->mod);

	if (!$is_zauberer) { $energiewerte['Astralenergie']->value = "-"; @$basissteigerungen['Astralenergie']->value = "-"; }
	if (!$is_geweihter) { $energiewerte['Karmaenergie']->value = "-"; @$basissteigerungen['Karmaenergie']->value = "-"; }

	return $energiewerte;
}

function rp_character_calculate_meta_talent_properties($talente)
{
    $talent_array = array();
    foreach ($talente as $talent) {
        $talent_array[$talent->name] = $talent->value;
    }

	$bogen = intval(@$talent_array['Bogen']);
	$schleichen = intval(@$talent_array['Schleichen']);
    $selbstbeherrschung = intval(@$talent_array['Selbstbeherrschung']);
	$sich_verstecken = intval(@$talent_array['Sich verstecken']);
	$sinnenschaerfe = intval(@$talent_array['Sinnenschärfe']);
	$faehrtensuchen = intval(@$talent_array['Fährtensuchen']);
	$wildnisleben = intval(@$talent_array['Wildnisleben']);
	$pflanzenkunde = intval(@$talent_array['Pflanzenkunde']);
	$tierkunde = intval(@$talent_array['Tierkunde']);

    $metatalente = array();
    array_push($metatalente, (object) array( 'name' => 'Jagd: Ansitzjagd', 'value' => round(($wildnisleben + $tierkunde + $faehrtensuchen + $sich_verstecken + $bogen) / 5) ));
    array_push($metatalente, (object) array( 'name' => 'Jagd: Pirschjagd', 'value' => round(($wildnisleben + $tierkunde + $faehrtensuchen + $schleichen + $bogen) / 5) ));
    array_push($metatalente, (object) array( 'name' => 'Kräuter Suchen',   'value' => round(($wildnisleben + $sinnenschaerfe + $pflanzenkunde) / 3) ));
    array_push($metatalente, (object) array( 'name' => 'Nahrung Sammeln',  'value' => round(($wildnisleben + $sinnenschaerfe + $pflanzenkunde) / 3) ));
    array_push($metatalente, (object) array( 'name' => 'Wache Halten',     'value' => round(($selbstbeherrschung + $sinnenschaerfe + $sinnenschaerfe) / 3) ));

    return $metatalente;
}

function rp_character_format_properties_basic($header, $properties)
{
	$properties_html = "";
	foreach ($properties as $property)
	{
		$name = $property->name;
		$variant = $property->variant;
		if (!empty($variant)) { $name .= " (" . $variant . ")"; }
		$properties_html .= (!empty($properties_html) ? "<br>" : "") . $name;
	}
	$output = "<tr><td>$header</td><td>$properties_html</td></tr>\n";
	return $output;
}

function rp_character_format_properties_vorteile($properties, $levelup, $all_properties)
{
	global $vorteil_data;
	global $vorteil_gruppe;
	$gruppen_filter = array(
		'vorteil' => array(),
		'nachteil' => array());

    return rp_character_format_properties_generic($properties, $vorteil_data, $vorteil_gruppe, $gruppen_filter, 'vorteil', $levelup, 'advantage', 'vorteile', $all_properties, 'advantage');
}

function rp_character_format_properties_template_id($name)
{
    $id = utf8_decode($name);
    $id = strtolower($id);
    $id = str_replace(' ', '-', $id);
    $id = str_replace(':', '-', $id);
    $id = str_replace('(', '-', $id);
    $id = str_replace(')', '-', $id);
    $id = str_replace('\'', '-', $id);
    $id = str_replace(utf8_decode("ß"), 'ss', $id);
    $id = str_replace(utf8_decode("ä"), 'ae', $id);
    $id = str_replace(utf8_decode("ö"), 'oe', $id);
    $id = str_replace(utf8_decode("ü"), 'ue', $id);
    return $id;
}

function rp_character_format_properties_display_name($property)
{
    $name = @$property->name;
	$params = array();
	if (isset($property->value) && !empty($property->value)) { array_push($params, $property->value); }
	if (isset($property->variant) && !empty($property->variant)) { array_push($params, $property->variant); }
	if (isset($property->info) && !empty($property->info)) { array_push($params, $property->info); }
	if (count($params) > 0) { $name .= " (" . join(", ", $params) . ")"; }
    return $name;
}

function rp_character_format_properties_eval_bonus($data, $property)
{
    $name = @$property->name;
    $mod = (isset($property->mod) && !empty($property->mod)) ? intval($property->mod) : 0;
    $base = (array_key_exists('base', $data[$name])) ? $data[$name]['base'] : '';
    $factor = (array_key_exists('factor', $data[$name])) ? $data[$name]['factor'] : 1.0;
    $resultString = "$mod";
    
    if (!empty($base))
    {
        $resultString .= "+Math.round(";
        $resultString .= $factor;
        $resultString .= "*";
        $resultString .= "(";

        $summands = explode("+", $base);
        foreach ($summands as $summand)
        {
			if (is_numeric($summand))
				$resultString .= $summand . "+";
			else
	            $resultString .= "levelupGetVal('" . rp_character_format_properties_template_id($summand) . "')+";
        }

        $resultString = rtrim($resultString, "+");
        $resultString .= "))";
    }

    return $resultString;
}

function rp_character_format_properties_eval_display_has($properties, $name)
{
    foreach ($properties as $property) {
		if ($property->name == $name) { return TRUE; }
	}
	return FALSE;
}

function rp_character_format_properties_eval_display($data, $property, $properties)
{
    $name = @$property->name;
    $display = (array_key_exists('display', $data[$name])) ? $data[$name]['display'] : 'true';
	$display = str_replace('has("', 'rp_character_format_properties_eval_display_has($properties, "', $display);
	$result = (eval("return ($display);") ? "true" : "false");
	/*
	if ($name == "Test") {
		echo($name." : ".$display." = ".$result."<br>");
	}
	*/
	return $result;
}

function rp_character_format_properties_eval_req($data, $property)
{
    $name = @$property->name;
	$variant = empty(@$property->variant) ? "TaW" : explode(",", $property->variant, 2)[0];
    $req = (array_key_exists('req', $data[$name])) ? $data[$name]['req'] : '';
	$req = str_replace("[@Variant]", $variant, $req);
    $resultString = str_replace("'", "\'", $req);
    $resultString = str_replace('"', "'", $resultString);

	if (empty($req))
	{
		$flavorString = "Keine";
	}
	else
	{
	    $flavorString = $req;
		$flavorString = str_replace('has("', '', $flavorString);
		$flavorString = str_replace('DUP*', '', $flavorString);
		$flavorString = str_replace('")', '', $flavorString);
		$flavorString = preg_replace('/\", (\d+)\)/', ' ${1}', $flavorString);
		$flavorString = str_replace(' &&', ',', $flavorString);
		$flavorString = str_replace('||', 'oder', $flavorString);
		$flavorString = str_replace('Mut', 'MU', $flavorString);
		$flavorString = str_replace('Klugheit', 'KL', $flavorString);
		$flavorString = str_replace('Intuition', 'IN', $flavorString);
		$flavorString = str_replace('Charisma', 'CH', $flavorString);
		$flavorString = str_replace('Fingerfertigkeit', 'FF', $flavorString);
		$flavorString = str_replace('Gewandtheit', 'GE', $flavorString);
		$flavorString = str_replace('Konstitution', 'KO', $flavorString);
		$flavorString = str_replace('Körperkraft', 'KK', $flavorString);
	}

	$property->req_text = $flavorString;

    return $resultString;
}

function rp_character_format_properties_eigenschaften($properties, $levelup, $all_properties)
{
	global $eigenschaft_data;
	global $eigenschaft_gruppe;
	$gruppen_filter = array(
		'eigenschaft' => array(),
		'energiewert' => array(),
		'basiswert' => array(),
        'sozialstatus' => array());

    return rp_character_format_properties_generic($properties, $eigenschaft_data, $eigenschaft_gruppe, $gruppen_filter, 'basiswert', $levelup, 'property', 'eigenschaften', $all_properties, 'basic');
}

function rp_character_format_properties_sonderfertigkeiten($properties, $levelup, $all_properties)
{
	global $sf_data;
	global $sf_gruppe;
	$sf_filter = array(
		'allgemein' => array(),
		'gelände' => array(),
		'kampf' => array(),
		'fernkampf' => array(),
		'manöver' => array(),
		'klerikal' => array(),
		'liturgie' => array(),
		'magisch' => array(),
		'elfenlied' => array(),
		'ritual' => array(),
		'objekt' => array(),
		'schamanen' => array());

    return rp_character_format_properties_generic($properties, $sf_data, $sf_gruppe, $sf_filter, 'allgemein', $levelup, 'feat', 'sonderfertigkeiten', $all_properties, 'feat');
}

function rp_character_format_properties_talente($properties, $levelup, $all_properties)
{
	global $talent_data;
    global $talent_gruppe;
    $gruppen_filter = array(
		'kampf' => array(),
		'koerper' => array(),
		'gesellschaft' => array(),
		'natur' => array(),
		'meta' => array(),
		'wissen' => array(),
		'sprache' => array(),
		'schrift' => array(),
		'handwerk' => array(),
		'gabe' => array());

    return rp_character_format_properties_generic($properties, $talent_data, $talent_gruppe, $gruppen_filter, 'gabe', $levelup, 'property', 'talente', $all_properties, 'skill');
}

function rp_character_format_properties_zauber($properties, $levelup, $all_properties)
{
	global $zauber_data;
    global $zauber_gruppe;
    $gruppen_filter = array(
		'zauber' => array());

    return rp_character_format_properties_generic($properties, $zauber_data, $zauber_gruppe, $gruppen_filter, 'zauber', $levelup, 'property', 'zauber', $all_properties, 'spell');
}

function rp_character_sort_properties_generic($property1, $property2)
{
	return strcmp(@$property1->name, @$property2->name);
}

function rp_character_format_properties_generic($properties, $data, $gruppen_data, $gruppen_filter, $gruppen_default, $levelup, $property_display_type, $type, $all_properties, $property_type)
{
    $path_templates = plugin_dir_path(__FILE__) . "/../tpl";
    $tpl_display = ($levelup ? "levelup" : "display");

    foreach ($data as $property_template_name => $property_template)
    {
        $property = (object) $property_template;
        $property->name = $property_template_name;
        $property->property_id = NULL;
        $property->id = rp_character_format_properties_template_id($property->name);
        $property->ap = NULL;
        $property->value = 0;
        $property->probe = @$property->probe;
        $property->progression = (@$property->basis ? "a;A" : "");
        $property->info = "";
        $property->variant = "";
        $property->template = (@$property->basis ? "false" : "true");
		$gruppe = @$property->gruppe;
		$gruppen_properties = @$gruppen_filter[$gruppe];
		if (!isset($gruppen_properties)) { $gruppen_properties = array(); }
        $gruppen_properties += [ $property->name => $property ];
		$gruppen_filter[$gruppe] = $gruppen_properties;
    }

	foreach ($properties as $property)
	{
		if(!isset($property->name))
			continue;

        $property->template = "false";
        $property->id = rp_character_format_properties_template_id($property->name);
		if (isset($property->variant) && $property->variant != "") { $property->id .= "-" . rp_character_format_properties_template_id($property->variant); }
		$gruppe = @$data[$property->name]['gruppe'];
		if (!isset($gruppe)) { $gruppe = @$property->group; }
		if (!isset($gruppe)) { $gruppe = $gruppen_default; }
		$gruppen_properties = @$gruppen_filter[$gruppe];
		if (!isset($gruppen_properties)) { $gruppen_properties = array(); }
        if (array_key_exists($property->name, $gruppen_properties))
        {
            $property_template = $gruppen_properties[$property->name];
            $array_template = (array) $property_template;
            $array_property = (array) $property;
            $array_merged = $array_template;

            // override template values
            foreach ($array_property as $key => $value)
            {
                $array_merged[$key] = $value;
            }

			if ((@$property_template->variant === @$property->variant) || ((@$property_template->variant == NULL) && (@$property->variant == NULL)))
			{
				$gruppen_properties[$property->name] = (object) $array_merged;
			}
			else
			{
	            $gruppen_properties += [ ($property->name . @$property->variant) => (object) $array_merged ];
			}
        }
        else
        {
            $gruppen_properties += [ $property->name => $property ];
        }
		$gruppen_filter[$gruppe] = $gruppen_properties;
    }

	$html = "";
	foreach ($gruppen_filter as $gruppe => $gruppen_properties)
	{
		usort($gruppen_properties, "rp_character_sort_properties_generic");

        $empty = "true";
        $properties_html = "";
		$display_any = "false";
	    foreach ($gruppen_properties as $gruppen_property)
	    {
		    $name = @$gruppen_property->name;
		    $value = @$gruppen_property->value;

			if (!array_key_exists($name, $data))
			{
				echo("<script>console.log('Index \"$name\" does not exist in \"$type\".');</script>");
				$data[$gruppen_property->name] = (array) $gruppen_property;
				$data[$gruppen_property->name]['flavor'] = @$gruppen_property->info;
			}

			if (!isset($gruppen_property->type)) {
				$gruppen_property->type = $property_type;
			}

            $gruppen_property_data = @$data[$gruppen_property->name];
            $hyperlink = (!array_key_exists('hyperlink', $gruppen_property_data)) ? "" : $gruppen_property_data['hyperlink'];
            $category = (/* $value == "-" ||*/ empty($gruppen_property_data) || !array_key_exists('category', $gruppen_property_data)) ? "" : $gruppen_property_data['category'];
            $mod_match = "name=$name;" . @$gruppen_property_data['match'];
            $mod_query = str_replace("[@Variant]", @$gruppen_property->variant, @$gruppen_property_data['mod_query']);
            $mod_category = @$gruppen_property_data['mod_category'];
            $mod_factor = @$gruppen_property_data['mod_factor'];
			$variant_match = @$gruppen_property_data['variant-match'];
            $bonus = rp_character_format_properties_eval_bonus($data, $gruppen_property);
            $req = rp_character_format_properties_eval_req($data, $gruppen_property);
            $display = rp_character_format_properties_eval_display($data, $gruppen_property, $all_properties);
            $empty = (@$gruppen_property->template == "false") ? "false" : $empty;
			if ($display == "true") {
				$display_any = "true";
			}

            $progression_native = rp_character_progression_decode_native(@$gruppen_property->progression);
            $progression_html = rp_character_progression_encode_html($progression_native);
			
			if (substr($name, 0, strlen("Sprachen kennen")) == "Sprachen kennen") {
				$name = substr($name, strlen("Sprachen kennen") + 1);
			}
			if (substr($name, 0, strlen("Lesen/Schreiben")) == "Lesen/Schreiben") {
				$name = substr($name, strlen("Lesen/Schreiben") + 1);
			}

			$display_name = rp_character_format_properties_display_name($gruppen_property);
			if (!$levelup && !empty($hyperlink)) {
				$display_name = '<a href="'.$hyperlink.'" target="_blank">'.$display_name.'</a>';
			}
			$maximum = NULL;
			if ($gruppen_property->type == 'ability') {
				$maximum = round(1.5 * floatval($gruppen_property->gp));
			} else if ($gruppen_property->type == 'skill' || $gruppen_property->type == 'spell') {
				$ap = rp_character_hero_calculate_experience_progression($gruppen_property, "ap");
				$gruppen_property->ap = (!empty($ap) ? $ap : "");
			}

		    $template_row = new Sonnenstrasse\Template($path_templates . "/page/character.$tpl_display.$property_display_type.single.html");
            $template_row->setObject($gruppen_property);
            $template_row->set("Type", $gruppen_property->type);
            $template_row->set("DisplayName", $display_name);
            $template_row->set("ReqFunction", $req);
            $template_row->set("DisplayValue", $display);
            $template_row->set("Name", $name);
            $template_row->set("Category", $category);
            $template_row->set("Bonus", $bonus);
            $template_row->set("ProgressionSteps", $progression_html);
            $template_row->set("Gruppe", @$gruppen_data[$gruppe]);
            $template_row->set("ModMatch", $mod_match);
            $template_row->set("ModQuery", $mod_query);
            $template_row->set("ModCategory", $mod_category);
            $template_row->set("ModFactor", $mod_factor);
            $template_row->set("VariantMatch", $variant_match);
			$template_row->set("CostFormula", @$gruppen_property_data['cost_formula']);
            $template_row->set("Hyperlink", $hyperlink);
            $template_row->set("Maximum", $maximum);
		    $properties_html .= $template_row->output();
	    }

		$template_table = new Sonnenstrasse\Template($path_templates . "/page/character.$tpl_display.$property_display_type.all.html");
        $template_table->set("Gruppe", $gruppe);
        $template_table->set("DisplayValue", $display_any);
        $template_table->set("Empty", $empty);
        $template_table->set("Name", @$gruppen_data[$gruppe]);
        $template_table->set("Properties", $properties_html);
		$html .= $template_table->output();
    }
	return $html;
}

function rp_character_hero_full_html($hero, $solo_user)
{
    $path_local = plugin_dir_path(__FILE__);
	$path_url = plugins_url() . "/sonnenstrasse-character";
	
	$inventory_html = "";
	$properties_basic_html = "";
	$properties_vorteile_html = "";
	$properties_eigenschaften_html = "";
	$properties_basiswerte_html = "";
	$properties_energiewerte_html = "";
	$properties_talente_html = "";
	$properties_zauber_html = "";
	$properties_sonderfertigkeiten_html = "";
	$abenteuerpunkte_html = "";
    $levelup_vorteile_html = "";
    $levelup_eigenschaften_html = "";
	$levelup_talente_html = "";
    $levelup_zauber_html = "";
    $levelup_sonderfertigkeiten_html = "";
	$ap_total = 0;
	$ap_spent = 0;
	if (!empty($hero) && !empty($hero->name))
	{
		if (function_exists("rp_inventory_hero_html_by_id"))
		{
			$inventory_html = rp_inventory_hero_html_by_id($hero->hero_id, $hero->name);
		}

		$status = $hero->status;
		$title = $hero->title;
		$gender = $hero->gender;
		$age = 1014 - (int)($hero->birth_year);
		$height = $hero->height;
		$weight = $hero->weight;

		$alles = rp_character_get_properties($hero->hero_id, "%");
		$rassen = rp_character_get_properties($hero->hero_id, "race");
		$kulturen = rp_character_get_properties($hero->hero_id, "culture");
		$professionen = rp_character_get_properties($hero->hero_id, "profession");
		$eigenschaften = rp_character_get_simple_proprerties($hero->hero_id, "ability");
		$basissteigerungen = rp_character_get_simple_proprerties($hero->hero_id, "basic");
		$sozialstatus = @$basissteigerungen['Sozialstatus']->value;
		$vorteile = rp_character_get_properties($hero->hero_id, "advantage");
		$nachteile = rp_character_get_properties($hero->hero_id, "disadvantage");
		$vorteile = array_merge($vorteile, $nachteile);
		$talente = rp_character_get_properties($hero->hero_id, "skill");
		$liturgien = rp_character_get_properties($hero->hero_id, "miracle");
		$zauber = rp_character_get_properties($hero->hero_id, "spell");
		$sonderfertigkeiten = rp_character_get_properties($hero->hero_id, "feat");
		$basiswerte = rp_character_calculate_basic_properties($basissteigerungen, $eigenschaften, $vorteile, $sonderfertigkeiten);
		$energiewerte = rp_character_calculate_energy_properties($basissteigerungen, $eigenschaften, $vorteile, $sonderfertigkeiten);
		$metatalente = rp_character_calculate_meta_talent_properties($talente);
		
		$properties_basic_html .= "<tr><td>Name</td><td>".$hero->display_name."</td></tr>\n";
		$properties_basic_html .= rp_character_format_properties_basic("Rasse", $rassen, "", "");
		$properties_basic_html .= rp_character_format_properties_basic("Kultur", $kulturen, "", "");
		$properties_basic_html .= rp_character_format_properties_basic("Profession", $professionen, "", "");
		$properties_basic_html .= "<tr><td>Sozialstatus</td><td>$sozialstatus $status</td></tr>\n";
		$properties_basic_html .= "<tr><td>Titel</td><td>$title</td></tr>\n";
		$properties_basic_html .= "<tr><td>Geschlecht</td><td>$gender</td></tr>\n";
		$properties_basic_html .= "<tr><td>Alter</td><td>$age Götterläufe</td></tr>\n";
		$properties_basic_html .= "<tr><td>Grösse</td><td>$height Halbfinger</td></tr>\n";
		$properties_basic_html .= "<tr><td>Gewicht</td><td>$weight Stein</td></tr>\n";
		$properties_basic_html .= "<tr><td>Haarfarbe</td><td></td></tr>\n";
		$properties_basic_html .= "<tr><td>Augenfarbe</td><td></td></tr>\n";
		$properties_basic_html .= "<tr><td>Aussehen</td><td></td></tr>\n";
		
		$properties_vorteile_html .= rp_character_format_properties_vorteile($vorteile, FALSE, $alles);
		$properties_eigenschaften_html .= rp_character_format_properties_eigenschaften(array_merge($eigenschaften, $energiewerte, $basiswerte), FALSE, $alles);
		$properties_talente_html .= rp_character_format_properties_talente(array_merge($talente, $metatalente), FALSE, $alles);
		$properties_zauber_html .= rp_character_format_properties_zauber($zauber, FALSE, $alles);
		$properties_sonderfertigkeiten_html .= rp_character_format_properties_sonderfertigkeiten($sonderfertigkeiten, FALSE, $alles);

        $levelup_vorteile_html .= rp_character_format_properties_vorteile($vorteile, TRUE, $alles);
        $levelup_eigenschaften_html .= rp_character_format_properties_eigenschaften(array_merge($eigenschaften, $basissteigerungen), TRUE, $alles);
        $levelup_talente_html .= rp_character_format_properties_talente($talente, TRUE, $alles);
        $levelup_zauber_html .= rp_character_format_properties_zauber($zauber, TRUE, $alles);
        $levelup_sonderfertigkeiten_html .= rp_character_format_properties_sonderfertigkeiten($sonderfertigkeiten, TRUE, $alles);

		$ap_total = rp_character_get_experience_sum($hero->hero_id, $hero->party);
		$ap_spent = rp_character_hero_calculate_experience_spent($alles);

		$ap_table = rp_character_get_experience($hero->hero_id, $hero->party);
		foreach ($ap_table as $ap_entry)
		{
			$ap = $ap_entry->ap;
			$adventure = $ap_entry->adventure;

			$abenteuerpunkte_html .= "<tr><td>".$adventure."</td><td>".$ap."</td></tr>";
		}
	}

	$tpl_character = new Sonnenstrasse\Template($path_local . "../tpl/page/character.html");
	$tpl_character->set("PluginBaseUri", $path_url);
	$tpl_character->set("Hero", $hero->hero_id);
	$tpl_character->set("Character", $hero->name);
	$tpl_character->set("Portrait", (empty($hero->portrait) ? ($path_url . "/../sonnenstrasse-base/img/glow2.gif") : ($path_url . "/../../uploads/portraits/" . $hero->portrait)));
	$tpl_character->set("PortraitClass", (empty($hero->portrait) ? "empty" : "image"));
	$tpl_character->set("MU", @$eigenschaften["Mut"]->value ?? 0);
	$tpl_character->set("KL", @$eigenschaften["Klugheit"]->value ?? 0);
	$tpl_character->set("IN", @$eigenschaften["Intuition"]->value ?? 0);
	$tpl_character->set("CH", @$eigenschaften["Charisma"]->value ?? 0);
	$tpl_character->set("FF", @$eigenschaften["Fingerfertigkeit"]->value ?? 0);
	$tpl_character->set("GE", @$eigenschaften["Gewandtheit"]->value ?? 0);
	$tpl_character->set("KO", @$eigenschaften["Konstitution"]->value ?? 0);
	$tpl_character->set("KK", @$eigenschaften["Körperkraft"]->value ?? 0);
	$tpl_character->set("ApTotal", $ap_total);
	$tpl_character->set("ApFree", $ap_total - $ap_spent);
	$tpl_character->set("PropertiesBasic", $properties_basic_html);
	$tpl_character->set("PropertiesVorteile", $properties_vorteile_html);
	$tpl_character->set("PropertiesEigenschaften", $properties_eigenschaften_html);
	$tpl_character->set("PropertiesTalente", $properties_talente_html);
	$tpl_character->set("PropertiesZauber", $properties_zauber_html);
	$tpl_character->set("PropertiesSonderfertigkeiten", $properties_sonderfertigkeiten_html);
	$tpl_character->set("Abenteuerpunkte", $abenteuerpunkte_html);

	$tpl_character->set("LevelupVorteile", $levelup_vorteile_html);
	$tpl_character->set("LevelupEigenschaften", $levelup_eigenschaften_html);
	$tpl_character->set("LevelupTalente", $levelup_talente_html);
	$tpl_character->set("LevelupZauber", $levelup_zauber_html);
	$tpl_character->set("LevelupSonderfertigkeiten", $levelup_sonderfertigkeiten_html);

	$tpl_character->set("Content", "");
	$tpl_character->set("Inventory", $inventory_html);
	$output = $tpl_character->output();
	
	return $output;
}

function rp_character_hero_calculate_experience_spent($properties)
{
	$ap_spent = 0;
	foreach ($properties as $property)
	{
		if(!isset($property->name))
			continue;

		$ap_spent += rp_character_hero_calculate_experience_progression($property, "ap");
	}

	return $ap_spent;
}

$AKT = [1, 1, 2, 3, 4, 5, 8, 10, 20];

$SKT = [
  [1, 1, 1, 2, 4, 5, 6, 8, 9, 11, 12, 14, 15, 17, 19, 20, 22, 24, 25, 27, 29, 31, 32, 34, 36, 38, 40, 42, 43, 45, 48],
  [1, 2, 3, 4, 6, 7, 8, 10, 11, 13, 14, 16, 17, 19, 21, 22, 24, 26, 27, 29, 31, 33, 34, 36, 38, 40, 42, 44, 45, 47, 50],
  [2, 4, 6, 8, 11, 14, 17, 19, 22, 25, 28, 32, 35, 38, 41, 45, 48, 51, 55, 58, 62, 65, 69, 73, 76, 80, 84, 87, 91, 95, 100],
  [2, 6, 9, 13, 17, 21, 25, 29, 34, 38, 43, 47, 51, 55, 60, 65, 70, 75, 80, 85, 95, 100, 105, 110, 115, 120, 125, 130, 135, 140, 150],
  [3, 7, 12, 17, 22, 27, 33, 39, 45, 50, 55, 65, 70, 75, 85, 90, 95, 105, 110, 115, 125, 130, 140, 145, 150, 160, 165, 170, 180, 190, 200],
  [4, 9, 15, 21, 28, 34, 41, 48, 55, 65, 70, 80, 85, 95, 105, 110, 120, 130, 135, 145, 155, 165, 170, 180, 190, 200, 210, 220, 230, 240, 250],
  [6, 14, 22, 32, 41, 50, 60, 75, 85, 95, 105, 120, 130, 140, 155, 165, 180, 195, 210, 220, 230, 250, 260, 270, 290, 300, 310, 330, 340, 350, 375],
  [8, 18, 30, 42, 55, 70, 85, 95, 110, 125, 140, 160, 175, 190, 210, 220, 240, 260, 270, 290, 310, 330, 340, 360, 380, 400, 420, 440, 460, 480, 500],
  [16, 35, 60, 85, 110, 140, 165, 195, 220, 250, 280, 320, 350, 380, 410, 450, 480, 510, 550, 580, 620, 650, 690, 720, 760, 800, 830, 870, 910, 950, 1000]
];

function rp_character_hero_calculate_experience_progression($property, $calulcation_type)
{
	global $AKT, $SKT, $character_const_dictionary;

	$ap = 0;
	$plan = $property->progression;
	$type = $property->type;
	$property_template = @$character_const_dictionary[$type][$property->name];

	if ($type == "skill" || $type == "spell" || $type == "ability" || $type == "basic")
	{
		if ($plan == "")
			return $ap;

		$steps = explode("|", $plan);
		$stepsCount = count($steps);
		for ($stepIndex = 0; $stepIndex < $stepsCount; $stepIndex++)
		{
			$step = $steps[$stepIndex];

			$splits = explode(";", $step);
			if (($calulcation_type == "ap" && $splits[0] == "x") || ($calulcation_type == "ap" && $splits[0] == "s") || ($calulcation_type == "tgp" && $splits[0] == "o"))
			{
				$category_type = "";
				if (count($splits) > 1) {
					$category_type = $splits[1];
				} else if (!empty($property_template)) {
					$category_type = $property_template['category'];
				} else {
					$category_type = @$property->category . "H";
				}

				$factor = 1.0;
				if (count($splits) > 2) {
					$factor = floatval($splits[2]);
				}
				if (empty($factor)) {
					$factor = 1.0;
				}

				$category = hexdec(bin2hex(mb_substr(strtoupper($category_type), 0, 1, 'UTF-8'))) - 64;
				$category = max(0, min(8, $category));

				$akt_cost = $AKT[$category] * (($calulcation_type == "ap") ? 5 : 1);
				if ($property->mod < 0)
					$akt_cost *= (1 + abs($property->mod));

				$costs = $SKT[$category];
				$ap += $factor * ($stepIndex == 0 ? $akt_cost : $costs[min(30, max(0, $stepIndex - 1))]);
			}
		}
	}
	else if ($type == "feat")
	{
		if ($plan == "")
			$plan = "x";

		$splits = explode(";", explode("|", $plan)[0]);
		if (($calulcation_type == "ap" && $splits[0] == "x") || ($calulcation_type == "ap" && $splits[0] == "s") || ($calulcation_type == "tgp" && $splits[0] == "o"))
		{
			$factor = 1.0;
			if (count($splits) > 2) {
				$factor = floatval($splits[2]);
			}
			if (empty($factor)) {
				$factor = 1.0;
			}

			$cost = floatval(!empty($property->cost) ? $property->cost : @$property_template['cost']);
			$ap += $factor * $cost;
		}
	}
	else if ($type == "advantage" || $type == "disadvantage")
	{
		if ($calulcation_type == "ap" && !empty($property->ap)) {
			$ap += $property->ap;
		} else if ($calulcation_type == "tgp" && !empty($property->tgp)) {
			$ap += $property->tgp;
		}
	}

	return $ap;
}

function rp_character_hero_selector_html($solo_user, $selected_hero, $solo_module)
{
    $path_templates = plugin_dir_path(__FILE__) . "/../../sonnenstrasse-solo/tpl";
	
	$import = "";
	$create = "";
	$output = "";
	$heroes = rp_character_get_heroes_of_user($solo_user);
	
	if (!empty($solo_user))
	{
		$template_menu_create_hero = new Sonnenstrasse\Template($path_templates . "/menu-item.html");
		$template_menu_create_hero->set("Id", "create-hero");
		$template_menu_create_hero->set("Header", "Neuen Charakter Erstellen");
		$template_menu_create_hero->set("OnClick", "setClass('aventurien-character-window','aventurien-character-window-create')");
		$create .= $template_menu_create_hero->output();
	}
	
	if (count($heroes) == 0) {
		$output .= $create;
	}
	else {
		
		$hero_selector_items_html = "";
		foreach ($heroes as $hero) {
			$template_character_selector_item = new Sonnenstrasse\Template($path_templates . "/character-selector-item.html");
			$template_character_selector_item->set("HeroId", @$hero->hero_id);
			$template_character_selector_item->set("HeroName", @$hero->display_name);
			$template_character_selector_item->set("Style", ($hero->hero_id == @$selected_hero->hero_id) ? "display:inline-block" : "display:none");
			$hero_selector_items_html .= $template_character_selector_item->output();
		}

		$template_character_selector = new Sonnenstrasse\Template($path_templates . "/character-selector.html");
		$template_character_selector->set("HeroItems", $hero_selector_items_html);
		$template_character_selector->set("BaseUri", plugins_url() . "/sonnenstrasse-solo");
		$template_character_selector->set("Module", $solo_module);
		$output = $hero_selector_items_html = $template_character_selector->output();
		
		$output .= '<div id="aventurien-solo-character-name">' . @$selected_hero->display_name . '</div>';
	}

	$template_menu_import_hero = new Sonnenstrasse\Template($path_templates . "/menu-item.html");
	$template_menu_import_hero->set("Id", "import-hero");
	$template_menu_import_hero->set("Header", "Charakter Importieren");
	$template_menu_import_hero->set("OnClick", "setClass('aventurien-character-window','aventurien-character-window-import')");
	$import = $template_menu_import_hero->output();
	
	$template_menu_delete_hero = new Sonnenstrasse\Template($path_templates . "/menu-item.html");
	$template_menu_delete_hero->set("Id", "delete-hero");
	$template_menu_delete_hero->set("Header", "Ausgewählten Charakter Löschen");
	$template_menu_delete_hero->set("OnClick", "setClass('aventurien-character-window','aventurien-character-window-delete')");
	// "deleteCharacter('" . plugins_url() . "/sonnenstrasse-solo', '" . $solo_module . "', " . @$selected_hero->hero_id . ")");
	if (count($heroes) == 0) {
		$delete = "";
	} else {
		$delete = $template_menu_delete_hero->output();
	}
	
	$template_menu = new Sonnenstrasse\Template($path_templates . "/menu.html");
	$template_menu->set("MenuId", "aventurien-solo-menu-character-selection");
	$template_menu->set("MenuTitle", "Charakter");
	$template_menu->set("MenuItems", $create . $import . $delete);
	$output .= $template_menu->output();
	
	return $output;
}

function rp_character_hero_archetypes_html($solo_module)
{
	$path_local = plugin_dir_path(__FILE__);
	
	$output = "";
	$party_id_archetypes = -2;
	
	$heroes = rp_character_get_heroes_of_user("SoloModule-" . $solo_module);
	if (empty($heroes))
	{
		$heroes = rp_character_get_heroes($party_id_archetypes, $solo_module);
	}
	foreach ($heroes as $hero)
	{
		$template_archetype = new Sonnenstrasse\Template($path_local . "../tpl/page/character.archetype.html");
		$template_archetype->setObject($hero);
		$template_archetype->set("Flavor", nl2br($hero->flavor));
		$template_archetype->set("PortraitClass", (empty($hero->portrait) ? "empty" : "image"));
		$template_archetype->set("PluginBaseUri", plugins_url() . "/sonnenstrasse-character");
		$output .= $template_archetype->output();
	}
	
	return $output;
}

function rp_character_levelup_hero($hero_id, $properties)
{
	$existing_properties = rp_character_get_properties($hero_id, "%");

	foreach ($properties as $property)
	{
		$id = $property->id;
		$name = $property->name;
		$type = $property->type;
		$variant = $property->variant;
		$plan = $property->plan;
		$invest = $property->invest;

		$existing_property = array_column($existing_properties, null, 'property_id')[$id] ?? null;

		if ($type == "skill" || $type == "spell" || $type == "ability" || $type == "basic")
		{
			if (is_null($existing_property))
			{
				$info = null;
				$value = count(explode("|", $plan)) - 1;
				$mod = null;
				$cost = null;
				$gp = null;
				$tgp = null;
				$ap = null;
				$at = null;
				$pa = null;
				$ebe = null;
				$rarity = null;
				$requirements = null;
				$progression = $plan;
				$group = null;
				$flavor = null;
				$hyperlink = null;

				rp_character_set_property($hero_id, $type, $name, $variant, $info, $value, $mod, $cost, $gp, $tgp, $ap, $at, $pa, $ebe, $rarity, $requirements, $progression, $group, $flavor, $hyperlink);
			}
			else
			{
				$existing_property->progression .= "|" . $plan;
				$existing_property->value = count(explode("|", $existing_property->progression)) - 1;
				rp_character_edit_property((array) $existing_property);
			}
		}
		else
		{
			$info = null;
			$value = null;
			$mod = null;
			$cost = null;
			$gp = null;
			$tgp = null;
			$ap = $invest;
			$at = null;
			$pa = null;
			$ebe = null;
			$rarity = null;
			$requirements = null;
			$progression = null;
			$group = null;
			$flavor = null;
			$hyperlink = null;

			rp_character_set_property($hero_id, $type, $name, $variant, $info, $value, $mod, $cost, $gp, $tgp, $ap, $at, $pa, $ebe, $rarity, $requirements, $progression, $group, $flavor, $hyperlink);
		}
	}

	echo("succeeded");
}

?>