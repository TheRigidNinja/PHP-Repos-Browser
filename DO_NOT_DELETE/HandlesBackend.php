<?php 

    session_start();

    $repoIMG = array();
    $php_v = 5;
    $directory = str_replace("DO_NOT_DELETE","",dirname(__FILE__))."/php$php_v";
    $contextmenutype  = true;
    $_SESSION["folderNames"]  = array();
    $_SESSION["folderStamps"]  = array();
    $_SESSION["filteredSearch"]  = array();

    // Gets all folder/timestamps in the selected directory
    foreach (array_diff(scandir($directory), array('..', '.')) as $fname) {
        array_push($_SESSION["folderNames"],$fname);
        array_push($_SESSION["folderStamps"],stat($directory."/$fname")["atime"]);
    }

    $_SESSION["filteredSearch"] = $_SESSION["folderNames"];


    
    if(isset($_POST["filterSearch"])){

        function FilterSearch($word){
            $cleanoutFname = preg_replace('/[^a-zA-Z]/', "", strtolower($word)); 
            $cleanoutUserSearch = preg_replace('/[^a-zA-Z]/', "", strtolower($_POST["filterSearch"])); 

            return strstr($cleanoutFname,$cleanoutUserSearch);
        }

        $_SESSION["filteredSearch"] = array_filter($_SESSION["folderNames"],"FilterSearch");
        echo json_encode($_SESSION["filteredSearch"]);
    }

//   var_dump($folders)
    // echo system("cd php5 && ls")
?>