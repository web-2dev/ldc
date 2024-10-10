<?php 
include "tools/init.inc.php";

$user = substr($_SERVER["REQUEST_URI"], 1);


$fileNameList = "$user.json";
if ( !file_exists("data/$fileNameList") ) $fileNameList = "list.json";
ob_start();
    include "data/$fileNameList";
    $list = ob_get_contents();
ob_end_clean();
$list = (array)json_decode($list);

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        $listName = "Liste $user";
        displayHTML("tableList", compact("list", "listName"));
        exit;
        break;
    
    case 'POST':
        if( isset($_POST["btDel"]) && !empty($_POST["delete"]) ) {
            unset($_POST["btDel"]);
            foreach ($_POST["delete"] as $index => $item) {
                unset($list[$item]);
            }
            unset($_POST["delete"]);
        }
        foreach ($list as $item => $checked) {
            // ! dans $_POS, les espaces des clés sont remplacés par des _
            if( in_array(str_replace(" ", "_", $item), array_keys($_POST)) ) {
                $list[$item] = true;
                unset($_POST[$item]);
            } else {
                $list[$item] = false;
            }    
        }

        if( !empty($_POST["add"]) ) {
            foreach ($_POST["add"] as $key => $item) {
                if( in_array($item, array_keys($list)) || !$item) continue;
                $list[$item] = false;
            }
        }

        $file = fopen("data/$fileNameList", "w");
        fwrite($file, json_encode($list, JSON_UNESCAPED_UNICODE) );
        fclose($file);
        header("Location: /$user"); exit;
        break;
    
    default:
        # code...
        break;
}


// $fichier = fopen("liste.json.php", "a");
// fwrite($fichier, json_encode(["huile", "beurre"]));
// fclose($fichier);


// $jdnFile = fopen($fileName, "w+");
// fwrite($jdnFile, "<?php\n\nreturn [\n");
// foreach($noms as $prenom => $nom) {
//     fwrite($jdnFile, "\t\"$prenom\" => \"$nom\",\n");
// }
// fwrite($jdnFile, "];");
// fclose($jdnFile);