<?php

require_once('rp-character-constants-eigenschaften.php');
require_once('rp-character-constants-vorteile.php');
require_once('rp-character-constants-talente.php');
require_once('rp-character-constants-zauber.php');
require_once('rp-character-constants-sonderfertigkeiten.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dictionary
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$character_const_dictionary = array();
$character_const_dictionary['ability'] = $eigenschaft_data;
$character_const_dictionary['advantage'] = $vorteil_data;
$character_const_dictionary['skill'] = $talent_data;
$character_const_dictionary['spell'] = $zauber_data;
$character_const_dictionary['feat'] = $sf_data;

?>