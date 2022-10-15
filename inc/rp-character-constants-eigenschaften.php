<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Eigenschaften
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$eigenschaft_gruppe = array();
$eigenschaft_gruppe['eigenschaft'] = 'Eigenschaften';
$eigenschaft_gruppe['energiewert'] = 'Energiewerte';
$eigenschaft_gruppe['basiswert'] = 'Basiswerte';
$eigenschaft_gruppe['sozialstatus'] = 'Sozialstatus';

$eigenschaft_data = array();
$eigenschaft_data['Mut']                     = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Klugheit']                = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Intuition']               = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Charisma']                = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Fingerfertigkeit']        = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Gewandtheit']             = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Konstitution']            = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Körperkraft']             = array( 'gruppe' => 'eigenschaft',  'category' => 'H', 'basis' => true );
$eigenschaft_data['Magieresistenz']          = array( 'gruppe' => 'energiewert',  'category' => 'H', 'basis' => true,  'factor' => 1/5, 'base' => 'Mut+Klugheit+Konstitution' );
$eigenschaft_data['Lebensenergie']           = array( 'gruppe' => 'energiewert',  'category' => 'H', 'basis' => true,  'factor' => 1/2, 'base' => 'Konstitution+Konstitution+Körperkraft' );
$eigenschaft_data['Ausdauer']                = array( 'gruppe' => 'energiewert',  'category' => 'E', 'basis' => true,  'factor' => 1/2, 'base' => 'Mut+Konstitution+Gewandtheit' );
$eigenschaft_data['Astralenergie']           = array( 'gruppe' => 'energiewert',  'category' => 'G', 'basis' => false, 'factor' => 1/2, 'base' => 'Mut+Intuition+Charisma' );
$eigenschaft_data['Karmaenergie']            = array( 'gruppe' => 'energiewert',  'category' => NULL, 'basis' => false );
$eigenschaft_data['Attacke Basiswert']       = array( 'gruppe' => 'basiswert',    'category' => NULL, 'basis' => true, 'factor' => 1/5, 'base' => 'Mut+Gewandtheit+Körperkraft' );
$eigenschaft_data['Parade Basiswert']        = array( 'gruppe' => 'basiswert',    'category' => NULL, 'basis' => true, 'factor' => 1/5, 'base' => 'Intuition+Gewandtheit+Körperkraft' );
$eigenschaft_data['Fernkampf Basiswert']     = array( 'gruppe' => 'basiswert',    'category' => NULL, 'basis' => true, 'factor' => 1/5, 'base' => 'Intuition+Fingerfertigkeit+Körperkraft' );
$eigenschaft_data['Initiative Basiswert']    = array( 'gruppe' => 'basiswert',    'category' => NULL, 'basis' => true, 'factor' => 1/5, 'base' => 'Mut+Mut+Intuition+Gewandtheit' );
$eigenschaft_data['Geschwindigkeit']         = array( 'gruppe' => 'basiswert',    'category' => NULL, 'basis' => true, 'factor' => 1,   'base' => '8' );
$eigenschaft_data['Sozialstatus']            = array( 'gruppe' => 'sozialstatus', 'category' => NULL, 'basis' => true );

?>