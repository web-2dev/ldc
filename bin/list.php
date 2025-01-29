<?php 
    include "../tools/init.inc.php";
    
    if( getServer("REQUEST_METHOD") == "POST" ) {

        // liste précédente
        $list = getDataFileValue("../data/list.php", []);
        foreach ($list as $item => $checked) {
            // ! dans $_POST, les espaces des clés sont remplacés par des _
            /**
             * Dans la liste, toutes les lignes ont une case à cocher pour sélectionner les éléments à supprimer.
             * Ces champs ont pour name, le texte de l'élément de la liste. Si un élément est présent, c'est qu'il a été coché.
             * Si le bouton btDel a été cliqué, ces chanps vont être supprimé de la liste.
             */
            if( in_array(str_replace(" ", "_", $item), array_keys($_POST)) ) { // si l'élément  présent dans $_POST est aussi dans la liste
                if( isset($_POST["btDel"]) ) {                                              // et si le bouton supp a été cliqué
                    unset($list[$item]);                                                // alors suppression de l'élément
                } else {                                                            // sinon (bouton supp non cliqué)
                    $list[$item] = true;                                                //  il est coché            
                }
                unset($_POST[$item]);                                               // on retire l'élément du $_POST
            } else {                                                            // sinon (= élément n'est pas dans la liste)
                $list[$item] = false;                                               // élément ajouté non coché
            }    
        }
        if( !empty($item = $_POST["add"]) ) {
                $list[$item] = false;
        }

        updateDataFile("../data/list.php", $list);
    } else {
        setMessage("danger", "405 : Méthode proscrite !");
    }
    redirect("/");

