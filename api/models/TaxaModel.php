<?php

class TaxaModel {

    /**
     * test data before db set up
     */
    protected $families;
    protected $sp;
 
    public function __construct() {

        $fam = array('Acanthaceae', 'Sapindaceae', 'Asteraceae', 'Orchidaceae', 'Rutaceae', 'Lauraceae', 'Passifloraceae', 'Adiantaceae', 'Pentaphylacaceae', 'Connaraceae', 'Conneraceae', 'Meliaceae', 'Araceae', 'Euphorbiaceae', 'Simaroubaceae', 'Cornaceae', 'Apocynaceae', 'Amaryllidaceae', 'Commelinaceae', 'Zingiberaceae', 'Vitaceae', 'Anacardiaceae', 'Menispermaceae', 'Ancistrocladaceae', 'Marattiaceae', 'Anisophylleaceae', 'Dipterocarpaceae', 'Annonaceae', 'Phyllanthaceae', 'Pteridaceae', 'Thymelaeaceae', 'Fabaceae', 'Primulaceae', 'Arecaceae', 'Aristolochiaceae', 'Moraceae', 'Aspleniaceae', 'Chrysobalanaceae', 'Poaceae', 'Lecythidaceae', 'Lecythidiaceae', 'Begoniaceae', 'Melastomataceae', 'Centroplacaceae', 'Blechnaceae', 'Rubiaceae', 'Burseraceae', 'Malvaceae', 'Lamiaceae', 'Calophyllaceae', 'Capparaceae', 'Caprifoliaceae', 'Rhizophoraceae', 'Salicaceae', 'Fagaceae', 'Cannabaceae', 'Opiliaceae', 'Costaceae', 'Oleaceae', 'Thelypteridaceae', 'Cleomaceae', 'Clusiaceae', 'Gesneriaceae', 'Combretaceae', 'Convolvulaceae', 'Hypericaceae', 'Polypodiaceae', 'Cucurbitaceae', 'Lythraceae', 'Cyperaceae', 'Davalliaceae', 'Urticaceae', 'Xanthorrhoeaceae', 'Dichapetalaceae', 'Gleicheniaceae', 'Dilleniaceae', 'Dioscoreaceae', 'Ebenaceae', 'Athyriacaea', 'Marantaceae', 'Asparagaceae', 'Elaeocarpaceae', 'Celastraceae', 'Flagellariaceae', 'Pandanaceae', 'Pandaceae', 'Gnetaceae', 'Stemonuraceae', 'Ochnaceae', 'Cardiopteridaceae', 'Theaceae', 'Myristicaceae', 'Hanguanaceae', 'Proteaceae', 'Ophioglossaceae', 'Smilacaceae', 'Linaceae', 'Lycopodiaceae', 'Achariaceae', 'Icacinaceae', 'Aquifoliaceae', 'Irvingiaceae', 'Ixonanthaceae', 'Schisandraceae', 'Monimiaceae', 'Lytraceae', 'Verbenaceae', 'Linderniaceae', 'Liliaceae', 'Butomaceae', 'Dennstaedtiaceae', 'Loganiaceae', 'Loranthaceae', 'Onagraceae', 'Lygodiaceae', 'Sapotaceae', 'Magnoliaceae', 'Hypoxidaceae', 'Musaceae', 'Myrtaceae', 'Podocarpaceae', 'Nepenthaceae', 'Nephrolepidaceae', 'Olacaceae', 'Oxalidaceae', 'Solanaceae', 'Piperaceae', 'Polygalaceae', 'Escalloniaceae', 'Araliaceae', 'Rosaceae', 'Rhamnaceae', 'Violaceae', 'Actinidiaceae', 'Schizaeaceae', 'Cyatheaceae', 'Scrophulariaceae', 'Selaginellaceae', 'Stemonaceae', 'Styracaceae', 'Symplocaceae', 'Tectariaceae', 'Dryopteridaceae', 'Tetramelaceae', 'Trigoniaceae', 'Staphyleaceae', 'Vittariaceae');
        
        // all plantlist families
        // $fam = array('Acanthaceae', 'Achariaceae', 'Achatocarpaceae', 'Acoraceae', 'Acrobolbaceae', 'Actinidiaceae', 'Adelanthaceae', 'Adiantaceae', 'Adoxaceae', 'Aextoxicaceae', 'Aizoaceae', 'Akaniaceae', 'Alismataceae', 'Allisoniaceae', 'Alseuosmiaceae', 'Alstroemeriaceae', 'Altingiaceae', 'Alzateaceae', 'Amaranthaceae', 'Amaryllidaceae', 'Amblystegiaceae', 'Amborellaceae', 'Anacardiaceae', 'Anarthriaceae', 'Anastrophyllaceae', 'Ancistrocladaceae', 'Andreaeaceae', 'Aneuraceae', 'Anisophylleaceae', 'Annonaceae', 'Antheliaceae', 'Anthocerotaceae', 'Aphanopetalaceae', 'Aphloiaceae', 'Apiaceae', 'Apocynaceae', 'Apodanthaceae', 'Aponogetonaceae', 'Aquifoliaceae', 'Araceae', 'Araliaceae', 'Araucariaceae', 'Archidiaceae', 'Arecaceae', 'Argophyllaceae', 'Aristolochiaceae', 'Arnelliaceae', 'Asparagaceae', 'Aspleniaceae', 'Asteliaceae', 'Asteropeiaceae', 'Atherospermataceae', 'Aulacomniaceae', 'Austrobaileyaceae', 'Aytoniaceae', 'Balanopaceae', 'Balanophoraceae', 'Balantiopsaceae', 'Balsaminaceae', 'Barbeuiaceae', 'Barbeyaceae', 'Bartramiaceae', 'Basellaceae', 'Bataceae', 'Begoniaceae', 'Berberidaceae', 'Berberidopsidaceae', 'Betulaceae', 'Biebersteiniaceae', 'Bignoniaceae', 'Bixaceae', 'Blandfordiaceae', 'Blechnaceae', 'Bonnetiaceae', 'Boraginaceae', 'Boryaceae', 'Boweniaceae', 'Brachytheciaceae', 'Brassicaceae', 'Brevianthaceae', 'Bromeliaceae', 'Bruchiaceae', 'Brunelliaceae', 'Bruniaceae', 'Bryaceae', 'Bryobartramiaceae', 'Bryoxiphiaceae', 'Burmanniaceae', 'Burseraceae', 'Butomaceae', 'Buxaceae', 'Buxbaumiaceae', 'Byblidaceae', 'Cabombaceae', 'Cactaceae', 'Calceolariaceae', 'Calomniaceae', 'Calophyllaceae', 'Calycanthaceae', 'Calyceraceae', 'Calymperaceae', 'Calypogeiaceae', 'Campanulaceae', 'Campyneumataceae', 'Canellaceae', 'Cannabaceae', 'Cannaceae', 'Capparaceae', 'Caprifoliaceae', 'Cardiopteridaceae', 'Caricaceae', 'Carlemanniaceae', 'Caryocaraceae', 'Caryophyllaceae', 'Casuarinaceae', 'Catagoniaceae', 'Catoscopiaceae', 'Celastraceae', 'Centrolepidaceae', 'Centroplacaceae', 'Cephalotaceae', 'Cephalotaxaceae', 'Cephaloziaceae', 'Cephaloziellaceae', 'Ceratophyllaceae', 'Cercidiphyllaceae', 'Chaetophyllopsaceae', 'Chloranthaceae', 'Chonecoleaceae', 'Chrysobalanaceae', 'Cinclidotaceae', 'Circaeasteraceae', 'Cistaceae', 'Cleomaceae', 'Clethraceae', 'Cleveaceae', 'Climaciaceae', 'Clusiaceae', 'Colchicaceae', 'Columelliaceae', 'Combretaceae', 'Commelinaceae', 'Compositae', 'Connaraceae', 'Conocephalaceae', 'Convolvulaceae', 'Coriariaceae', 'Cornaceae', 'Corsiaceae', 'Corsiniaceae', 'Corynocarpaceae', 'Costaceae', 'Crassulaceae', 'Crossosomataceae', 'Cryphaeaceae', 'Crypteroniaceae', 'Ctenolophonaceae', 'Cucurbitaceae', 'Cunoniaceae', 'Cupressaceae', 'Curtisiaceae', 'Cyatheaceae', 'Cycadaceae', 'Cyclanthaceae', 'Cymodoceaceae', 'Cynomoriaceae', 'Cyperaceae', 'Cyrillaceae', 'Cyrtopodaceae', 'Cytinaceae', 'Daltoniaceae', 'Daphniphyllaceae', 'Dasypogonaceae', 'Datiscaceae', 'Davalliaceae', 'Degeneriaceae', 'Dendrocerotaceae', 'Dennstaedtiaceae', 'Diapensiaceae', 'Dichapetalaceae', 'Dicksoniaceae', 'Dicnemonaceae', 'Dicranaceae', 'Didiereaceae', 'Dilleniaceae', 'Dioncophyllaceae', 'Dioscoreaceae', 'Dipentodontaceae', 'Dipteridaceae', 'Dipterocarpaceae', 'Dirachmaceae', 'Disceliaceae', 'Ditrichaceae', 'Doryanthaceae', 'Droseraceae', 'Drosophyllaceae', 'Dryopteridaceae', 'Ebenaceae', 'Ecdeiocoleaceae', 'Echinodiaceae', 'Elaeagnaceae', 'Elaeocarpaceae', 'Elatinaceae', 'Emblingiaceae', 'Encalyptaceae', 'Entodontaceae', 'Ephedraceae', 'Ephemeraceae', 'Equisetaceae', 'Ericaceae', 'Eriocaulaceae', 'Erpodiaceae', 'Erythroxylaceae', 'Escalloniaceae', 'Eucommiaceae', 'Euphorbiaceae', 'Euphroniaceae', 'Eupomatiaceae', 'Eupteleaceae', 'Eustichiaceae', 'Exormothecaceae', 'Fabroniaceae', 'Fagaceae', 'Fissidentaceae', 'Flagellariaceae', 'Fontinalaceae', 'Fontinaliaceae', 'Fossombroniaceae', 'Fouquieriaceae', 'Frankeniaceae', 'Funariaceae', 'Garryaceae', 'Geissolomataceae', 'Gelsemiaceae', 'Gentianaceae', 'Geocalycaceae', 'Geraniaceae', 'Gesneriaceae', 'Gigaspermaceae', 'Ginkgoaceae', 'Gisekiaceae', 'Gleicheniaceae', 'Gnetaceae', 'Goebeliellaceae', 'Gomortegaceae', 'Goodeniaceae', 'Goupiaceae', 'Grammitidaceae', 'Grimmiaceae', 'Griseliniaceae', 'Grossulariaceae', 'Grubbiaceae', 'Gunneraceae', 'Gymnomitriaceae', 'Gyrostemonaceae', 'Haemodoraceae', 'Halophytaceae', 'Haloragaceae', 'Hamamelidaceae', 'Hanguanaceae', 'Haplomitriaceae', 'Haptanthaceae', 'Hedwigiaceae', 'Heliconiaceae', 'Helicophyllaceae', 'Helwingiaceae', 'Herbertaceae', 'Hernandiaceae', 'Himantandraceae', 'Hookeriaceae', 'Huaceae', 'Humiriaceae', 'Hydatellaceae', 'Hydnoraceae', 'Hydrangeaceae', 'Hydrocharitaceae', 'Hydroleaceae', 'Hydrostachyaceae', 'Hylocomiaceae', 'Hymenophyllaceae', 'Hymenophyllopsidaceae', 'Hymenophytaceae', 'Hypericaceae', 'Hypnaceae', 'Hypnodendraceae', 'Hypopterygiaceae', 'Hypoxidaceae', 'Icacinaceae', 'Iridaceae', 'Irvingiaceae', 'Isoetaceae', 'Iteaceae', 'Ixioliriaceae', 'Ixonanthaceae', 'Jackiellaceae', 'Joinvilleaceae', 'Jubulaceae', 'Jubulopsaceae', 'Juglandaceae', 'Juncaceae', 'Juncaginaceae', 'Jungermanniaceae', 'Kirkiaceae', 'Koeberliniaceae', 'Krameriaceae', 'Lacistemataceae', 'Lactoridaceae', 'Lamiaceae', 'Lanariaceae', 'Lardizabalaceae', 'Lauraceae', 'Lecythidaceae', 'Leguminosae', 'Lejeuneaceae', 'Lembophyllaceae', 'Lentibulariaceae', 'Lepicoleaceae', 'Lepidobotryaceae', 'Lepidolaenaceae', 'Lepidoziaceae', 'Leptodontaceae', 'Lepyrodontaceae', 'Leskeaceae', 'Leucodontaceae', 'Leucomiaceae', 'Liliaceae', 'Limeaceae', 'Limnanthaceae', 'Linaceae', 'Linderniaceae', 'Loasaceae', 'Loganiaceae', 'Lomariopsidaceae', 'Lophiocarpaceae', 'Lophocoleaceae', 'Lophoziaceae', 'Loranthaceae', 'Lowiaceae', 'Loxsomataceae', 'Lunulariaceae', 'Lycopodiaceae', 'Lythraceae', 'Magnoliaceae', 'Makinoaceae', 'Malpighiaceae', 'Malvaceae', 'Marantaceae', 'Marattiaceae', 'Marcgraviaceae', 'Marchantiaceae', 'Marsileaceae', 'Martyniaceae', 'Mastigophoraceae', 'Matoniaceae', 'Mayacaceae', 'Meesiaceae', 'Melanthiaceae', 'Melastomataceae', 'Meliaceae', 'Melianthaceae', 'Menispermaceae', 'Menyanthaceae', 'Mesoptychiaceae', 'Metaxyaceae', 'Meteoriaceae', 'Metteniusaceae', 'Metzgeriaceae', 'Misodendraceae', 'Mitrastemonaceae', 'Mitteniaceae', 'Mniaceae', 'Molluginaceae', 'Monimiaceae', 'Monocarpaceae', 'Montiaceae', 'Montiniaceae', 'Moraceae', 'Moringaceae', 'Muntingiaceae', 'Musaceae', 'Myliaceae', 'Myodocarpaceae', 'Myricaceae', 'Myriniaceae', 'Myristicaceae', 'Myrothamnaceae', 'Myrtaceae', 'Myuriaceae', 'Nartheciaceae', 'Neckeraceae', 'Nelumbonaceae', 'Neotrichocoleaceae', 'Nepenthaceae', 'Neuradaceae', 'Nitrariaceae', 'Nothofagaceae', 'Notothyladaceae', 'Nyctaginaceae', 'Nymphaeaceae', 'Ochnaceae', 'Octoblepharaceae', 'Oedipodiaceae', 'Olacaceae', 'Oleaceae', 'Oleandraceae', 'Onagraceae', 'Oncothecaceae', 'Ophioglossaceae', 'Opiliaceae', 'Orchidaceae', 'Orobanchaceae', 'Orthorrhynchiaceae', 'Orthotrichaceae', 'Osmundaceae', 'Oxalidaceae', 'Oxymitraceae', 'Paeoniaceae', 'Pallaviciniaceae', 'Pandaceae', 'Pandanaceae', 'Papaveraceae', 'Paracryphiaceae', 'Passifloraceae', 'Paulowniaceae', 'Pedaliaceae', 'Pelliaceae', 'Penaeaceae', 'Pentadiplandraceae', 'Pentaphragmataceae', 'Pentaphylacaceae', 'Penthoraceae', 'Peraceae', 'Peridiscaceae', 'Petermanniaceae', 'Petrosaviaceae', 'Philesiaceae', 'Philydraceae', 'Phrymaceae', 'Phyllanthaceae', 'Phyllodrepaniaceae', 'Phyllogoniaceae', 'Phyllonomaceae', 'Physenaceae', 'Phytolaccaceae', 'Picramniaceae', 'Picrodendraceae', 'Pilotrichaceae', 'Pinaceae', 'Piperaceae', 'Pittosporaceae', 'Plagiochilaceae', 'Plagiogyriaceae', 'Plagiotheciaceae', 'Plantaginaceae', 'Platanaceae', 'Pleuroziaceae', 'Pleuroziopsaceae', 'Plocospermataceae', 'Plumbaginaceae', 'Poaceae', 'Podocarpaceae', 'Podostemaceae', 'Polemoniaceae', 'Polygalaceae', 'Polygonaceae', 'Polypodiaceae', 'Polytrichaceae', 'Pontederiaceae', 'Porellaceae', 'Portulacaceae', 'Posidoniaceae', 'Potamogetonaceae', 'Pottiaceae', 'Primulaceae', 'Prionodontaceae', 'Proteaceae', 'Pseudolepicoleaceae', 'Psilotaceae', 'Pteridaceae', 'Pterigynandraceae', 'Pterobryaceae', 'Ptilidiaceae', 'Ptychomitriaceae', 'Ptychomniaceae', 'Putranjivaceae', 'Quillajaceae', 'Racopilaceae', 'Radulaceae', 'Rafflesiaceae', 'Ranunculaceae', 'Rapateaceae', 'Regmatodontaceae', 'Resedaceae', 'Restionaceae', 'Rhabdodendraceae', 'Rhabdoweisiaceae', 'Rhachitheciaceae', 'Rhacocarpaceae', 'Rhamnaceae', 'Rhipogonaceae', 'Rhizogoniaceae', 'Rhizophoraceae', 'Ricciaceae', 'Riellaceae', 'Rigodiaceae', 'Roridulaceae', 'Rosaceae', 'Rousseaceae', 'Rubiaceae', 'Ruppiaceae', 'Rutaceae', 'Rutenbergiaceae', 'Sabiaceae', 'Salicaceae', 'Salvadoraceae', 'Salviniaceae', 'Santalaceae', 'Sapindaceae', 'Sapotaceae', 'Sarcobataceae', 'Sarcolaenaceae', 'Sarraceniaceae', 'Saururaceae', 'Saxifragaceae', 'Scapaniaceae', 'Scheuchzeriaceae', 'Schisandraceae', 'Schistochilaceae', 'Schistostegaceae', 'Schizaeaceae', 'Schlegeliaceae', 'Schoepfiaceae', 'Scorpidiaceae', 'Scrophulariaceae', 'Selaginellaceae', 'Seligeriaceae', 'Sematophyllaceae', 'Serpotortellaceae', 'Setchellanthaceae', 'Simaroubaceae', 'Simmondsiaceae', 'Siparunaceae', 'Sladeniaceae', 'Smilacaceae', 'Solanaceae', 'Sphaerosepalaceae', 'Sphagnaceae', 'Sphenocleaceae', 'Spiridentaceae', 'Splachnaceae', 'Splachnobryaceae', 'Stachyuraceae', 'Staphyleaceae', 'Stegnospermataceae', 'Stemonaceae', 'Stemonuraceae', 'Stereophyllaceae', 'Stilbaceae', 'Strasburgeriaceae', 'Strelitziaceae', 'Stylidiaceae', 'Styracaceae', 'Surianaceae', 'Symplocaceae', 'Takakiaceae', 'Talinaceae', 'Tamaricaceae', 'Tapisciaceae', 'Targioniaceae', 'Taxaceae', 'Taxodiaceae', 'Tecophilaeaceae', 'Tetrachondraceae', 'Tetramelaceae', 'Tetrameristaceae', 'Tetraphidaceae', 'Thamnobryaceae', 'Theaceae', 'Theliaceae', 'Thelypteridaceae', 'Thomandersiaceae', 'Thuidiaceae', 'Thurniaceae', 'Thymelaeaceae', 'Ticodendraceae', 'Timmiaceae', 'Tofieldiaceae', 'Torricelliaceae', 'Tovariaceae', 'Trachypodaceae', 'Treubiaceae', 'Trichocoleaceae', 'Trigoniaceae', 'Triuridaceae', 'Trochodendraceae', 'Tropaeolaceae', 'Typhaceae', 'Ulmaceae', 'Urticaceae', 'Vahliaceae', 'Velloziaceae', 'Verbenaceae', 'Vetaformaceae', 'Violaceae', 'Vitaceae', 'Vittariaceae', 'Vivianiaceae', 'Vochysiaceae', 'Wardiaceae', 'Welwitschiaceae', 'Wiesnerellaceae', 'Winteraceae', 'Woodsiaceae', 'Xanthorrhoeaceae', 'Xeronemataceae', 'Xyridaceae', 'Zamiaceae', 'Zingiberaceae', 'Zosteraceae', 'Zygophyllaceae');

        array_push($fam, 'unknown');
        $fam = array_unique($fam);
        sort($fam);

        $sp = json_decode(file_get_contents('../public/sp-data.json'));
        usort($sp, array($this, "sortCmp"));
        $spTrimmed = array();
        foreach($sp as $spItem) {
            $spItem->species = trim($spItem->species);
            $spTrimmed[] = $spItem;

        }

        $this->families = $fam;
        $this->sp = $sp;
    }

    private function sortCmp($a, $b) {
        $a1 = $a->species;
        $b1 = $b->species;
        if($a1[0] === "\"") {
            $a1 = substr($a1, 1);
        }
        if($b1[0] === "\"") {
            $b1 = substr($b1, 1);
        }
        return strcmp(ucfirst($a1), ucfirst($b1));
    }

    /**
     *
     */
    public function listFamilies()
    {
        /*
        $db = Database::getInstance();
        $query = $db->prepare('SELECT class_name as class, type FROM classes LEFT JOIN class_types ON classes.class_type = class_types.id');
        $query->execute();
        $res = $query->fetchAll();
        if(count($res) > 0) {
            return $res;
        }
        */

        $families = $this->families;

        $app = \Slim\Slim::getInstance();

        if(isset($app->abc_list) && $app->abc_list) {
            return $this->splitAbc($families);
        }
        
        return $families;
    }

    public function countFamilies() {
        return count($this->families);
    }

    /**
     *
     */
    public function listItems($name)
    {
        /*
        $db = Database::getInstance();

        $classExists = false;
        foreach($this->listFamilies() as $row) {
            if($row->class === $name) {
                $classExists = true;
                break;
            }
        }
        if($classExists) {
            $query = $db->prepare("SELECT id as _id, CONCAT(server , path) as path, title, FROM_UNIXTIME(created) as added, user_name as added_by FROM $name LEFT JOIN users ON {$name}.created_by = users.user_id LIMIT 10");
            $query->execute();
            $res = $query->fetchAll();
            if(count($res) > 0) {
                return $res;
            } else {
                return [];
            }
        }
        return false;
        */
        $sp = array();
        foreach($this->sp as $sp_item) {
            $sp_item->preview = $this->getPrev($sp_item->species);
            $sp[] = $sp_item;
        }

        if($name!=='all') {
            $this->filter_family = $name;
            $sp = array_filter($sp, array($this, 'filter_callback'));
        }


        $out = array('count' => count($sp));

        $app = \Slim\Slim::getInstance();
        if(isset($app->abc_list) && $app->abc_list) {
            $out['data'] = $this->splitAbc($sp, 'obj');
        } else {
            $out['data'] = $sp;
        }
        
        return $out;
    }

    private function getPrev($sp) {
        $sp_path = ucfirst(str_replace(' ', '_', $sp)) . '/';
        if(file_exists(IMG_PATH . $sp_path)) {
            $imgs = array_values(
                array_diff(
                    scandir(IMG_PATH . $sp_path),
                    array('.', '..', '.tiles')
                )
            );
            if(!empty($imgs)) {
                return 'taxa/' . $sp_path . $imgs[0];
            }
        }
        return 'placeholder-404.jpg';
    }

    private function filter_callback($element) {
        if (isset($element->family) && strtolower(trim($element->family)) === strtolower($this->filter_family)) {
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function rowsCount($name)
    {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT 1 FROM $name");
        $query->execute();
        return count($query->fetchAll());
    }

    /**
     *
     */
    public function showItem($name, $id)
    {
        /*
        $db = Database::getInstance();

        $classExists = false;
        foreach($this->listFamilies() as $row) {
            if($row->class === $name) {
                $classExists = true;
                break;
            }
        }
        if($classExists) {
            $query = $db->prepare("SELECT $name.id as _id, CONCAT(server , path) as path, title, FROM_UNIXTIME(created) as added, user_name as added_by FROM $name LEFT JOIN users ON {$name}.created_by = users.user_id WHERE id = :id LIMIT 1");
            $query->execute(array(':id' => $id));
            $res = $query->fetch();
            if($res !== false) {
                $query_meta = $db->prepare("SELECT tag as `key`, value FROM {$name}_metadata LEFT JOIN bind_{$name}_meta ON {$name}_metadata.id = bind_{$name}_meta.meta_id WHERE file_id = :id");
                $query_meta->execute(array(':id' => $id));
                $meta = $query_meta->fetchAll();
                if(count($meta) < 1) {
                    $meta = false;
                }
                $res->meta = $meta;
                return $res;
            }
        }
        return false;
        */
        $sp = $this->sp;

        $sp = array_filter($sp, function($el) use($id){
            if (isset($el->species) && strtolower(trim($el->species)) === strtolower($id)) {
            return true;
        }
        return false;
        });

        return array_values($sp)[0]; // should anyway only match one record, so no need for array
    }

    private function splitAbc($list, $type="str") {
        $out = array();

        $alph = range('A', 'Z');
        $i = 0;
        $temp = array(); // empty temp array

        foreach($list as $item) {
            if($type !== 'str') {
                $itmcheck = trim($item->species);
                if($itmcheck[0] === "\"") {
                    $itmcheck = substr($itmcheck, 1);
                }
                $itmcheck = ucfirst($itmcheck);
            } else {
                $itmcheck = $item;
            }

            if($alph[$i] === $itmcheck[0]) {
                $temp[] = $item;
            } else {
                if(!empty($temp)) {
                    // add array for letter
                    $out[] = array(
                        'key' => $alph[$i],
                        'data' => $temp);
                }
                $temp = array(); // empty temp array

                if($itmcheck !== 'unknown') {
                    do {
                        $i++;
                    } while($alph[$i] !== $itmcheck[0]);
                    $temp[] = $item;
                }
            }
        }

        if(!empty($temp)) {
            $out[] = array(
                'key' => $alph[$i],
                'data' => $temp);
        }

        if($type === 'str') {
            $out[] = array(
                'key' => 'unknown',
                'data' => array('unknown'));
        }

        return $out;
    }
}