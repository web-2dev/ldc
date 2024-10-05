<?php 

function vd($var) {
    echo "<pre>"; exit(var_dump($var));
}


$fileNameList = "list.json";
ob_start();
    include $fileNameList;
    $list = ob_get_contents();
ob_end_clean();
$list = (array)json_decode($list);

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        include "views/tableList.html.php";
        exit;
        break;
    
    case 'POST':
        // vd($_POST);
        if( isset($_POST["btDel"]) && !empty($_POST["delete"]) ) {
            unset($_POST["btDel"]);
            $toDelete = is_array($_POST["delete"]) ? $_POST["delete"] : [$_POST["delete"]];
            foreach ($_POST["delete"] as $index => $item) {
                unset($list[$item]);
            }
            unset($_POST["delete"]);
        }

        foreach ($list as $item => $checked) {
            if( in_array($item, array_keys($_POST)) ) {
                $list[$item] = true;
                unset($_POST[$item]);
            } else {
                $list[$item] = false;
            }    
        }


        $file = fopen($fileNameList, "w");
        fwrite($file, json_encode($list) );
        fclose($file);
        header("Location: /"); exit;
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