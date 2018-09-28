<?php

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
            $container_html = rp_inventory_itemcontainer_html($hero_id, FALSE, FALSE, $is_user, $is_admin, $is_owner, $container, $contained_items, $hosts_container_id, $index);

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
		$archetypes_html = rp_character_hero_archetypes_html();
		
		$tpl_character = new Sonnenstrasse\Template($path_local . "../tpl/page/character.compact.html");
		$tpl_character->setObject($hero);
		$tpl_character->set("PluginBaseUri", $path_url);
		$tpl_character->set("Character", $selector_html);
		$tpl_character->set("CharacterAvailable", (!empty($hero->hero_id) && $allowSelection) ? "available" : "empty");
		$tpl_character->set("Portrait", $hero->portrait);
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

	
	$tpl_character = new Sonnenstrasse\Template($path_local . "../tpl/page/character.html");
	$tpl_character->set("PluginBaseUri", $path_url);
	$tpl_character->set("Character", $character_html);
	$tpl_character->set("Module", $solo_module);
	$tpl_character->set("Portrait", $hero->portrait);
	$tpl_character->set("PortraitClass", $portrait_class);
	$tpl_character->set("Content", "");
	$output = $tpl_character->output();
	
	return $output;
}

function rp_character_get_simple_proprerties($hero_id, $property_type)
{
	$result = array();
	$properties = rp_character_get_properties($hero_id, $property_type);
	
	foreach ($properties as $property)
	{
		$result[$property->name] = $property->value;
	}
	
	return $result;
}

function rp_character_format_proprerties_basic($header, $properties)
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

function rp_character_format_proprerties_vorteile($properties)
{
	$properties_html = array();
	foreach ($properties as $property)
	{
		$name = $property->name;
		$params = array();
		if (!empty($property->value)) { array_push($params, $property->value); }
		if (!empty($property->variant)) { array_push($params, $property->variant); }
		if (!empty($property->info)) { array_push($params, $property->info); }
		if (count($params) > 0) { $name .= " (" . join(", ", $params) . ")"; }
		array_push($properties_html, $name);
	}
	$output = join(", ", $properties_html) . "\n";
	return $output;
}

function rp_character_format_proprerties_eigenschaften($properties)
{
	$properties_html = "";
	foreach ($properties as $property)
	{
		$name = $property->name;
		$value = $property->value;
		$params = array();
		if (!empty($property->variant)) { array_push($params, $property->variant); }
		if (!empty($property->info)) { array_push($params, $property->info); }
		if (count($params) > 0) { $name .= " (" . join(", ", $params) . ")"; }
		$properties_html .= "<tr><td>$name</td><td>$value</td></tr>\n";
	}
	return $properties_html;
}

function rp_character_format_proprerties_talente($properties)
{
	$properties_html = "";
	foreach ($properties as $property)
	{
		$name = $property->name;
		$value = $property->value;
		$info = $property->info;
		$properties_html .= "<tr><td>$name</td><td>$info</td><td>$value</td></tr>\n";
	}
	return $properties_html;
}

function rp_character_hero_full_html($hero, $solo_user)
{
    $path_local = plugin_dir_path(__FILE__);
	$path_url = plugins_url() . "/sonnenstrasse-character";
	
	$properties_basic_html = "";
	$properties_vorteile_html = "";
	$properties_eigenschaften_html = "";
	$properties_basiswerte_html = "";
	$properties_talente_html = "";
	$properties_zauber_html = "";
	$properties_sonderfertigkeiten_html = "";
	if (!empty($hero) && !empty($hero->name))
	{
		$age = 1014 - (int)($hero->birth_year);
		$eigenschaften = rp_character_get_simple_proprerties($hero->hero_id, "ability");
		$basiswerte = rp_character_get_simple_proprerties($hero->hero_id, "basic");
		
		$properties_basic_html .= "<tr><td>Name</td><td>".$hero->display_name."</td></tr>\n";
		$properties_basic_html .= rp_character_format_proprerties_basic("Rasse", rp_character_get_properties($hero->hero_id, "race"), "", "");
		$properties_basic_html .= rp_character_format_proprerties_basic("Kultur", rp_character_get_properties($hero->hero_id, "culture"), "", "");
		$properties_basic_html .= rp_character_format_proprerties_basic("Profession", rp_character_get_properties($hero->hero_id, "profession"), "", "");
		$properties_basic_html .= "<tr><td>Sozialstatus</td><td>".@$basiswerte['Sozialstatus']." ".$hero->status."</td></tr>\n";
		$properties_basic_html .= "<tr><td>Titel</td><td>".$hero->title."</td></tr>\n";
		$properties_basic_html .= "<tr><td>Geschlecht</td><td>".$hero->gender."</td></tr>\n";
		$properties_basic_html .= "<tr><td>Alter</td><td>".$age." Götterläufe</td></tr>\n";
		$properties_basic_html .= "<tr><td>Grösse</td><td>".$hero->height." Halbfinger</td></tr>\n";
		$properties_basic_html .= "<tr><td>Gewicht</td><td>".$hero->weight." Stein</td></tr>\n";
		$properties_basic_html .= "<tr><td>Haarfarbe</td><td></td></tr>\n";
		$properties_basic_html .= "<tr><td>Augenfarbe</td><td></td></tr>\n";
		$properties_basic_html .= "<tr><td>Aussehen</td><td></td></tr>\n";
		
		$properties_vorteile_html .= rp_character_format_proprerties_vorteile(rp_character_get_properties($hero->hero_id, "advantage"));
		$properties_eigenschaften_html .= rp_character_format_proprerties_eigenschaften(rp_character_get_properties($hero->hero_id, "ability"));
		$properties_basiswerte_html .= rp_character_format_proprerties_eigenschaften(rp_character_get_properties($hero->hero_id, "basic"));
		$properties_talente_html .= rp_character_format_proprerties_talente(rp_character_get_properties($hero->hero_id, "skill"));
		$properties_zauber_html .= rp_character_format_proprerties_talente(rp_character_get_properties($hero->hero_id, "spell"));
		$properties_sonderfertigkeiten_html .= rp_character_format_proprerties_vorteile(rp_character_get_properties($hero->hero_id, "feat"));
	}

	$tpl_character = new Sonnenstrasse\Template($path_local . "../tpl/page/character.html");
	$tpl_character->set("PluginBaseUri", $path_url);
	$tpl_character->set("Character", $hero->name);
	$tpl_character->set("Portrait", $hero->portrait);
	$tpl_character->set("PortraitClass", (empty($hero->portrait) ? "empty" : "image"));
	$tpl_character->set("PropertiesBasic", $properties_basic_html);
	$tpl_character->set("PropertiesVorteile", $properties_vorteile_html);
	$tpl_character->set("PropertiesEigenschaften", $properties_eigenschaften_html);
	$tpl_character->set("PropertiesBasiswerte", $properties_basiswerte_html);
	$tpl_character->set("PropertiesTalente", $properties_talente_html);
	$tpl_character->set("PropertiesZauber", $properties_zauber_html);
	$tpl_character->set("PropertiesSonderfertigkeiten", $properties_sonderfertigkeiten_html);
	$tpl_character->set("Content", "");
	$output = $tpl_character->output();
	
	return $output;
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
		$template_menu_create_hero->set("OnClick", "showCharacterWindowContent('create')");
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

		$template_menu_import_hero = new Sonnenstrasse\Template($path_templates . "/menu-item.html");
		$template_menu_import_hero->set("Id", "import-hero");
		$template_menu_import_hero->set("Header", "Charakter Importieren");
		$template_menu_import_hero->set("OnClick", "showCharacterWindowContent('import')");
		$import = $template_menu_import_hero->output();
		
		$template_menu_delete_hero = new Sonnenstrasse\Template($path_templates . "/menu-item.html");
		$template_menu_delete_hero->set("Id", "delete-hero");
		$template_menu_delete_hero->set("Header", "Ausgewählten Charakter Löschen");
		$template_menu_delete_hero->set("OnClick", "showCharacterWindowContent('delete')");
		// "deleteCharacter('" . plugins_url() . "/sonnenstrasse-solo', '" . $solo_module . "', " . @$selected_hero->hero_id . ")");
		$delete = $template_menu_delete_hero->output();
		
		$template_menu = new Sonnenstrasse\Template($path_templates . "/menu.html");
		$template_menu->set("MenuId", "aventurien-solo-menu-character-selection");
		$template_menu->set("MenuTitle", "Charakter");
		$template_menu->set("MenuItems", $create . $import . $delete);
		$output .= $template_menu->output();
	}
	
	return $output;
}

function rp_character_hero_archetypes_html()
{
	$path_local = plugin_dir_path(__FILE__);
	
	$output = "";
	$party_id_archetypes = -2;
	
	$heroes = rp_character_get_heroes($party_id_archetypes);
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

?>