<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vor- und Nachteile
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$vorteil_gruppe = array();
$vorteil_gruppe['vorteil'] = 'Vorteile';
$vorteil_gruppe['nachteil'] = 'Nachteile';

$vorteil_data['Adlige Abstammung']                             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Adliges Erbe']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Affinität zu']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Akademische Ausbildung (Gelehrter)']            = array( 'gruppe' => 'vorteil' );
$vorteil_data['Akademische Ausbildung (Krieger)']              = array( 'gruppe' => 'vorteil', 'mod_factor' => 0.75, 'mod_query' => 'sfgruppe=Kampf' );
$vorteil_data['Akademische Ausbildung (Magier)']               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Altersresistenz']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Amtsadel']                                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Astrale Regeneration']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Astralmacht']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Ausdauernd']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Ausdauernder Zauberer']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Ausrüstungsvorteil']                            = array( 'gruppe' => 'vorteil' );
$vorteil_data['Balance']                                       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Begabung für [Merkmal]']                        = array( 'gruppe' => 'vorteil', 'mod_category' => -1, 'mod_query' => 'merkmal=[@Variant]' );
$vorteil_data['Begabung für [Ritual]']                         = array( 'gruppe' => 'vorteil', 'mod_category' => -1, 'mod_query' => 'name=[@Variant]' );
$vorteil_data['Begabung für [Talent]']                         = array( 'gruppe' => 'vorteil', 'mod_category' => -1, 'mod_query' => 'name=[@Variant]' );
$vorteil_data['Begabung für [Talentgruppe]']                   = array( 'gruppe' => 'vorteil', 'mod_category' => -1, 'mod_query' => 'talentgruppe=[@Variant]' );
$vorteil_data['Begabung für [Zauber]']                         = array( 'gruppe' => 'vorteil', 'mod_category' => -1, 'mod_query' => 'name=[@Variant]' );
$vorteil_data['Beidhändig']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Beseelte Knochenkeule']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Besonderer Besitz']                             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Breitgefächerte Bildung']                       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Dämmerungssicht']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Dschinngeboren']                                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Dschinngeboren (ohne VZ)']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Eidetisches Gedächtnis']                        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Eigeboren']                                     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Eisenaffine Aura']                              = array( 'gruppe' => 'vorteil' );
$vorteil_data['Eisern']                                        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Empathie']                                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Entfernungssinn']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Ererbte Knochenkeule']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Feenfreund']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Feste Matrix']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Flink']                                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Früher Vertrauter']                             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Gebildet']                                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Gefahreninstinkt']                              = array( 'gruppe' => 'vorteil' );
$vorteil_data['Geräuschhexerei']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Geweiht [Angrosch]']                            = array( 'gruppe' => 'vorteil' );
$vorteil_data['Geweiht [Gravesh]']                             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Geweiht [H\'Ranga]']                            = array( 'gruppe' => 'vorteil' );
$vorteil_data['Geweiht [nicht-alveranische Gottheit]']         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Geweiht [zwölfgöttliche Kirche]']               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Glück']                                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Glück im Spiel']                                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Delfin']                        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Eidechse']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Firunsbär']                     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Fuchs']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Gans']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Greif']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Hammer/Amboss']                 = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Rabe']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Schlange']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Schwert']                       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Sternenleere']                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Storch']                        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Göttergeschenk: Stute']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Gutaussehend']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Guter Ruf']                                     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Gutes Gedächtnis']                              = array( 'gruppe' => 'vorteil' );
$vorteil_data['Halbzauberer']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Balance']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Charisma']           = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Fingerfertigkeit']   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Gewandtheit']        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Intuition']          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Klugheit']           = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Konstitution']       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Körperkraft']        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragende Eigenschaft: Mut']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragender Sechster Sinn']                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragender Sinn']                           = array( 'gruppe' => 'vorteil' );
$vorteil_data['Herausragendes Aussehen']                       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Hitzeresistenz']                                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Hohe Lebenskraft']                              = array( 'gruppe' => 'vorteil' );
$vorteil_data['Hohe Magieresistenz']                           = array( 'gruppe' => 'vorteil' );
$vorteil_data['Immunität gegen Gift']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Immunität gegen Krankheiten']                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Innerer Kompass']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Kälteresistenz']                                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Kampfrausch']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Koboldfreund']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Kräfteschub']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Linkshänder']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Lizensierter Zauberer']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Machtvoller Vertrauter']                        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Magiedilletant']                                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Magiegespür']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Meisterhandwerk']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Nachtsicht']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Natürlicher Rüstungsschutz']                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Natürliche Waffen']                             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Alterslosigkeit']                 = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Dämonische Hilfe']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Dämonischer Fokus']               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Dämonische Waffe']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Giftdrüsen']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Lamijah']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Neue Körperteile']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Neun Leben']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Pech wünschen']                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schlafresistenz']                 = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schmusekätzchen']                 = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schutz vor göttlichem Wirken I']  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schutz vor göttlichem Wirken II'] = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schutz vor göttlichem Wirken III']= array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schutz vor göttlichem Wirken IV'] = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schutz vor göttlichem Wirken V']  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schutz vor göttlichem Wirken VI'] = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Schutz vor göttlichem Wirken VII']= array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Seelenschwert']                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Unverletzlichkeit']               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Wasseratmung']                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Paktgeschenk: Zholvars Warnung']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Prophezeien']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Resistenz gegen Gift']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Resistenz gegen Krankheiten']                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Richtungssinn']                                 = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schlangenmensch']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schnelle Heilung']                              = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schutzgeist']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Alpträume erzeugen']             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Amrychoths Tanz']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Austrocknen']                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Befehl der Lamijah']             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Begehren überkomme euch!']       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Belkelels Ekstase']              = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Beutesinn']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Brünstigkeit erzeugen']          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Chimärenerschaffung']            = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Ertränken']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Fischgift']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Geschwindigkeit']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Gier erzeugen']                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Goldene Hand']                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Hauch der Pestilenz']            = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Herrschaft über Dschinne']       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Herrschaft über Geister']        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Katzenruf']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Kornfäule']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Krakenhaut']                     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Krakenruf']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Lähmende Furcht']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Leichengespür']                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Lodernder Blick']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Macht des Wahnsinns']            = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Magnum Opus des Erzdämons']      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Meister der Form']               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Meister der Maritimen']          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Nagrachs Hauch']                 = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Orkanbö']                        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Raub der Lebenskraft']           = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Schleichen in den Schatten']     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Spur des Missetäters']           = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Todeshauch']                     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Trugwelten erschaffen']          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Unsichtbarer Jäger']             = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Verborgenes Wissen erspüren']    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Wahrheitssinn']                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Wundschmerz']                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwarze Gabe: Zwist und Hader']                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Schwer zu verzaubern']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Soziale Anpassungsfähigkeit']                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Sprachgefühl']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Talentschub']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Tierempathie (alle)']                           = array( 'gruppe' => 'vorteil' );
$vorteil_data['Tierempathie (speziell)']                       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Tierfreund']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Titularadel']                                   = array( 'gruppe' => 'vorteil' );
$vorteil_data['Übernatürliche Begabung']                       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Unbeschwertes Zaubern']                         = array( 'gruppe' => 'vorteil' );
$vorteil_data['Verbindungen']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Verhüllte Aura']                                = array( 'gruppe' => 'vorteil' );
$vorteil_data['Veteran']                                       = array( 'gruppe' => 'vorteil' );
$vorteil_data['Viertelzauberer']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Vollzauberer']                                  = array( 'gruppe' => 'vorteil' );
$vorteil_data['Vom Schicksal begünstigt']                      = array( 'gruppe' => 'vorteil' );
$vorteil_data['Wesen der Nacht']                               = array( 'gruppe' => 'vorteil' );
$vorteil_data['Wohlklang']                                     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Wolfskind']                                     = array( 'gruppe' => 'vorteil' );
$vorteil_data['Zäher Hund']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Zauberhaar']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Zeitgefühl']                                    = array( 'gruppe' => 'vorteil' );
$vorteil_data['Zusätzliche Gliedmaßen']                        = array( 'gruppe' => 'vorteil' );
$vorteil_data['Zweistimmiger Gesang']                          = array( 'gruppe' => 'vorteil' );
$vorteil_data['Zwergennase']                                   = array( 'gruppe' => 'vorteil' );

$vorteil_data['Aberglaube']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Agrimothwahn']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Albino']                                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor (häufiger Auslöser)']                 = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor (seltener Auslöser)']                 = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Feuer']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Insekten']                            = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Menschenmassen']                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Nagetieren']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Pelztieren']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Reptilien']                           = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Spinnen']                             = array( 'gruppe' => 'nachteil' );
$vorteil_data['Angst vor Wasser']                              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Animalische Magie']                             = array( 'gruppe' => 'nachteil' );
$vorteil_data['Arkanophobie']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Arroganz']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Artefaktgebunden']                              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Astraler Block']                                = array( 'gruppe' => 'nachteil' );
$vorteil_data['Autoritätsgläubig']                             = array( 'gruppe' => 'nachteil' );
$vorteil_data['Behäbig']                                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Blutdurst']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Blutrausch']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Brünstigkeit']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Charyptophilie']                                = array( 'gruppe' => 'nachteil' );
$vorteil_data['Dunkelangst']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Einarmig']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Einäugig']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Einbeinig']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Einbildungen']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Eingeschränkte Elementarnähe']                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Eingeschränkter Sinn']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Einhändig']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Eitelkeit']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Elfische Weltsicht']                            = array( 'gruppe' => 'nachteil' );
$vorteil_data['Farbenblind']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Feind']                                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Feste Gewohnheit']                              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Festgefügtes Denken']                           = array( 'gruppe' => 'nachteil' );
$vorteil_data['Fettleibig']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Fluch der Finsternis']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Geiz']                                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Gerechtigkeitswahn']                            = array( 'gruppe' => 'nachteil' );
$vorteil_data['Gesucht']                                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Glasknochen']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Goldgier']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Grausamkeit']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Größenwahn']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Heimwehkrank']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Herrschsucht']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Hitzeempfindlichkeit']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Höhenangst']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Impulsiv']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Jagdfieber']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Jähzorn']                                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Kälteempfindlichkeit']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Kältestarre']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Kein Vertrauter']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Kleinwüchsig']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Konstruktionswahn']                             = array( 'gruppe' => 'nachteil' );
$vorteil_data['Körpergebundene Kraft']                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Krankhafte Nekromantie']                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Krankhafte Reinlichkeit']                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Krankheitsanfällig']                            = array( 'gruppe' => 'nachteil' );
$vorteil_data['Kristallgebunden']                              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Kurzatmig']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Lahm']                                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Lästige Mindergeister']                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Lichtempfindlich']                              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Lichtscheu']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Madas Fluch']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Madas Fluch (stark)']                           = array( 'gruppe' => 'nachteil' );
$vorteil_data['Medium']                                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Meeresangst']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Charisma']               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Fingerfertigkeit']       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Gewandtheit']            = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Intuition']              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Klugheit']               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Konstitution']           = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Körperkraft']            = array( 'gruppe' => 'nachteil' );
$vorteil_data['Miserable Eigenschaft: Mut']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Mondsüchtig']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Angrosch-Kult]']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Badalikaner]']                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Boron-Kirche]']                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Bund des wahren Glaubens]']         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [DDZ]']                              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Dreischwesternorden]']              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Efferd-Kirche]']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Firun-Kirche]']                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [H\'Szint-Kult]']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Heshinja]']                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Hesinde-Kirche]']                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Ifirn-Kirche]']                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Ingerimm-Kirche]']                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Kor-Kirche]']                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Nandus-Kirche]']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Peraine-Kirche]']                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Phex-Kirche]']                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Praios-Kirche]']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Rahja-Kirche]']                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Rondra-Kirche]']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Swafnir-Kult]']                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Travia-Kirche]']                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Tsa-Kirche]']                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Moralkodex [Zsahh-Kult]']                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Morbidität']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Nachtblind']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Nagrachwahn']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Nahrungsrestriktion']                           = array( 'gruppe' => 'nachteil' );
$vorteil_data['Neid']                                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Neugier']                                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Niedrige Astralkraft']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Niedrige Lebenskraft']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Niedrige Magieresistenz']                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Paktierer']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Pechmagnet']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Platzangst']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Prinzipientreue']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Rachsucht']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Randgruppe']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Raubtiergeruch']                                = array( 'gruppe' => 'nachteil' );
$vorteil_data['Raumangst']                                     = array( 'gruppe' => 'nachteil' );
$vorteil_data['Rückschlag']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Ruhelosigkeit']                                 = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schlaflosigkeit']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schlafstörungen']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schlafwandler']                                 = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schlechte Eigenschaft']                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schlechte Regeneration']                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schlechter Ruf']                                = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schneller alternd']                             = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schöpferwahn']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schulden']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schwache Ausstrahlung']                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Schwacher Astralkörper']                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Seffer Manich']                                 = array( 'gruppe' => 'nachteil' );
$vorteil_data['Selbstgespräche']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Sensibler Geruchssinn']                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Sippenlosigkeit']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Sonnensucht']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Speisegebote']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Spielsucht']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Sprachfehler']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Spruchhemmung']                                 = array( 'gruppe' => 'nachteil' );
$vorteil_data['Stigma']                                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Streitsucht']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Stubenhocker']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Sucht']                                         = array( 'gruppe' => 'nachteil' );
$vorteil_data['Thesisgebunden']                                = array( 'gruppe' => 'nachteil' );
$vorteil_data['Tollpatsch']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Totenangst']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Trägheit']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Treulosigkeit']                                 = array( 'gruppe' => 'nachteil' );
$vorteil_data['Übler Geruch']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Unangenehme Stimme']                            = array( 'gruppe' => 'nachteil' );
$vorteil_data['Unansehnlich']                                  = array( 'gruppe' => 'nachteil' );
$vorteil_data['Unbewusster Viertelzauberer']                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Unfähigkeit für [Merkmal]']                     = array( 'gruppe' => 'nachteil', 'mod_category' => +1, 'mod_query' => 'merkmal=[@Variant]' );
$vorteil_data['Unfähigkeit für [Ritual]']                      = array( 'gruppe' => 'nachteil', 'mod_category' => +1, 'mod_query' => 'name=[@Variant]' );
$vorteil_data['Unfähigkeit für [Talent]']                      = array( 'gruppe' => 'nachteil', 'mod_category' => +1, 'mod_query' => 'name=[@Variant]' );
$vorteil_data['Unfähigkeit für [Talentgruppe]']                = array( 'gruppe' => 'nachteil', 'mod_category' => +1, 'mod_query' => 'talentgruppe=[@Variant]' );
$vorteil_data['Unfähigkeit für [Zauber]']                      = array( 'gruppe' => 'nachteil', 'mod_category' => +1, 'mod_query' => 'name=[@Variant]' );
$vorteil_data['Unfrei']                                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Ungebildet']                                    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Unstet']                                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Unverträglichkeit mit verarbeitetem Metall']    = array( 'gruppe' => 'nachteil' );
$vorteil_data['Vergesslichkeit']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Verpflichtungen']                               = array( 'gruppe' => 'nachteil' );
$vorteil_data['Verschwendungssucht']                           = array( 'gruppe' => 'nachteil' );
$vorteil_data['Verwöhnt']                                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Vorurteile gegen']                              = array( 'gruppe' => 'nachteil' );
$vorteil_data['Vorurteile gegen (stark)']                      = array( 'gruppe' => 'nachteil' );
$vorteil_data['Wahnvorstellungen']                             = array( 'gruppe' => 'nachteil' );
$vorteil_data['Wahrer Name']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Weltfremd bzgl.']		                       = array( 'gruppe' => 'nachteil' );
$vorteil_data['Widerwärtiges Aussehen']                        = array( 'gruppe' => 'nachteil' );
$vorteil_data['Wilde Magie']                                   = array( 'gruppe' => 'nachteil' );
$vorteil_data['Zielschwierigkeiten']                           = array( 'gruppe' => 'nachteil' );
$vorteil_data['Zögerlicher Zauberer']                          = array( 'gruppe' => 'nachteil' );
$vorteil_data['Zwergenwuchs']                                  = array( 'gruppe' => 'nachteil' );

?>