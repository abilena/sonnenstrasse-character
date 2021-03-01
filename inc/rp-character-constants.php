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
$character_const_dictionary['EIGENSCHAFTEN'] = $eigenschaft_data;
$character_const_dictionary['VORTEILE'] = $vorteil_data;
$character_const_dictionary['TALENT'] = $talent_data;
$character_const_dictionary['ZAUBER'] = $zauber_data;
$character_const_dictionary['SF'] = $sf_data;

?>