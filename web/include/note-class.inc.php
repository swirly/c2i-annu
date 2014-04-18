<?php
require_once 'Spreadsheet/Excel/Writer.php';

class note{
    public $ine;
    public $nom;
    public $prenom;
    public $rne;
    public $etablissement;
    public $classe;

    public $a1;
    public $a2;
    public $b1;
    public $b2;
    public $b3;
    public $b4;
    public $b5;
    public $b6;
    public $b7;


    function __construct($ine=null,$nom=null,$prenom=null,$rne=null,$classe=null,$year=null,$a1=null,$a2=null,$b1=null,$b2=null,$b3=null,$b4=null,$b5=null,$b6=null,$b7=null){
       $this->ine=$ine;
       $this->nom=$nom;
       $this->prenom=$prenom;
       $this->rne=$rne;
       $this->etablissement=$etablissement;
       $this->classe=$classe;
       $this->year=$year;
       $this->a1=$a1;
       $this->a2=$a2;
       $this->b1=$b1;
       $this->b2=$b2;
       $this->b3=$b3;
       $this->b4=$b4;
       $this->b5=$b5;
       $this->b6=$b6;
       $this->b7=$b7;


    }


    function save(){
        $sql_verif="SELECT ine FROM `c2i_annu_note`.`pupils` where ine='$this->ine'";
        $res_verif=mysql_query($sql_verif);
        if(mysql_num_rows($res_verif)==0){
                $sql_pupils="INSERT INTO `c2i_annu_note`.`pupils` (
                            `ine` ,
                            `nom` ,
                            `prenom` ,
                            `rne` ,
                            `etablissement` ,
                            `classe`,
                            `year`
                            )
                            VALUES (
                            '$this->ine',
                            '$this->nom',
                            '$this->prenom',
                            '$this->rne',
                            '$this->etablissement',
                            '$this->classe',
                            '$this->year'
                            )";
                      $result_pupils = mysql_query($sql_pupils);

                      $sql_eval="  INSERT INTO `c2i_annu_note`.`eval` (
                            `ine_pupils` ,
                            `A1` ,
                            `A2` ,
                            `B1` ,
                            `B2` ,
                            `B3` ,
                            `B4` ,
                            `B5` ,
                            `B6` ,
                            `B7`
                            )
                            VALUES (
                             '$this->ine',
                             '$this->a1',
                             '$this->a2',
                             '$this->b1',
                             '$this->b2',
                             '$this->b3',
                             '$this->b4',
                             '$this->b5',
                             '$this->b6',
                             '$this->b7'
                            )";
            
                        $result_eval=mysql_query($sql_eval);
        }else{

           $sql_eval="  UPDATE `c2i_annu_note`.`eval` SET
                            
                            `A1` ='$this->a1',
                            `A2` ='$this->a2',
                            `B1` ='$this->b1',
                            `B2` ='$this->b2',
                            `B3` ='$this->b3',
                            `B4` ='$this->b4',
                            `B5` ='$this->b5',
                            `B6` ='$this->b6',
                            `B7` ='$this->b7' WHERE  `ine_pupils`='$this->ine'
                            ";
          
           $result_eval=mysql_query($sql_eval);

        }


        
    }

/*retourne  les notes d'une classe dans un tableau*/
function load_section($rne,$section){

        $tab_note=array();
        
        $classe=$rne."_".$section;
        $sql_load="SELECT * FROM `c2i_annu_note`.`pupils` WHERE `rne` LIKE '$rne' and `classe` LIKE '$classe'";
        //echo $sql_load;
        $res_load=mysql_query($sql_load);
        if(mysql_num_rows($res_load)>0){
            while($ary=mysql_fetch_array($res_load)){
                $sql_note="SELECT * from eval WHERE `ine_pupils` LIKE '$ary[ine]' ";
                
                $res_note=mysql_query($sql_note);
                $ary_note=mysql_fetch_array($res_note);
                $tab_note[$ary[ine]][a1]=$ary_note[A1];
                $tab_note[$ary[ine]][a2]=$ary_note[A2];
                $tab_note[$ary[ine]][b1]=$ary_note[B1];
                $tab_note[$ary[ine]][b2]=$ary_note[B2];
                $tab_note[$ary[ine]][b3]=$ary_note[B3];
                $tab_note[$ary[ine]][b4]=$ary_note[B4];
                $tab_note[$ary[ine]][b5]=$ary_note[B5];
                $tab_note[$ary[ine]][b6]=$ary_note[B6];
                $tab_note[$ary[ine]][b7]=$ary_note[B7];
                
            }
            return $tab_note;

        }else{
            return NULL;
        }
    }





 function export_Excel_note_section($aryInfo){
    $i=1;
    
    $workbook = new Spreadsheet_Excel_Writer();

    $format_bold =& $workbook->addFormat();
    $format_bold->setBold();

    $format_title =& $workbook->addFormat();
    $format_title->setBold();

    $format_title->setPattern(1);
    $format_title->setFgColor('silver');

    $worksheet =& $workbook->addWorksheet();
    $worksheet->write(0, 0, "INE", $format_title);
    $worksheet->write(0, 1, "Nom", $format_title);
    $worksheet->setColumn(0,10,15);
    $worksheet->write(0, 2, "Prénom", $format_title);
    $worksheet->write(0, 3, "B1", $format_title);
    $worksheet->write(0, 4, "B2", $format_title);
    $worksheet->write(0, 5, "B3", $format_title);
    $worksheet->write(0, 6, "B4", $format_title);
    $worksheet->write(0, 7, "B5", $format_title);
    $worksheet->write(0, 8, "B6", $format_title);
    $worksheet->write(0, 9, "B7", $format_title);
    asort(&$aryInfo);
    foreach($aryInfo as $key => $value){
         $worksheet->write($i, 0, $key, $format_bold);
         $worksheet->write($i, 1, $value['nom'], $format_bold);
         $worksheet->write($i, 2, $value['prenom'], $format_bold);
         $worksheet->write($i, 3, $value['b1']);
         $worksheet->write($i, 4, $value['b2']);
         $worksheet->write($i, 5, $value['b3']);
         $worksheet->write($i, 6, $value['b4']);
         $worksheet->write($i, 7, $value['b5']);
         $worksheet->write($i, 8, $value['b6']);
         $worksheet->write($i, 9, $value['b7']);
         $i++;

    }
    // While we are at it, why not throw some more numbers around


    $workbook->send('note_c2i.xls');
    $workbook->close();
     //print_r($aryInfo);
 }

 function Import_Excel_note_section($fichier,$section,$rne){
     global $current_year;
     $link=mysqlConnexion();

    $content_dir = 'upload/'; // dossier où sera déplacé le fichier
  
    $tmp_file = $fichier['fichier']['tmp_name'];
    
    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $fichier['fichier']['type'];



    // on copie le fichier dans le dossier de destination
    $name_file = $fichier['fichier']['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }

  

    $fichier="upload/".$fichier['fichier']['name'];


      /* On ouvre le fichier à importer en lecture seulement */
 if (file_exists($fichier))
     $fp = fopen("$fichier", "r");
 else
     { /* le fichier n'existe pas */
       echo "Fichier introuvable !<br>Importation stoppée.";
       exit();
     }
     $i=0;
    while (!feof($fp)) /* Et Hop on importe */
    { /* Tant qu'on n'atteint pas la fin du fichier */
       $ligne = fgets($fp,4096); /* On lit une ligne */

       /* On récupère les champs séparés par ; dans liste*/
       $ligne=str_replace("\"","",$ligne);
        $ligne=str_replace('\'',"",$ligne);
       $liste = explode( ";",$ligne);
     
       /* On assigne les variables */
       $ine = $liste[0];
       $nom = $liste[1];
       $prenom = $liste[2];
       $b1 = $liste[3];
       $b2 = $liste[4];
       $b3 = $liste[5];
       $b4 = $liste[6];
       $b5 = $liste[7];
       $b6 = $liste[8];
       $b7 = $liste[9];
      if($i!=0){
        
       $sql_test="SELECT * FROM pupils WHERE `ine` LIKE '$ine' ";
     
       $res_test=mysql_query($sql_test);
       if(mysql_num_rows($res_test)>0){
          $sql="UPDATE `c2i_annu_note`.`eval` SET
                            `B1` ='$b1',
                            `B2` ='$b2',
                            `B3` ='$b3',
                            `B4` ='$b4',
                            `B5` ='$b5',
                            `B6` ='$b6',
                            `B7` ='$b7' WHERE  `ine_pupils`='$ine'
                            ";

       }else{
         $sql1="INSERT INTO `c2i_annu_note`.`pupils` (
                            `ine` ,
                            `nom` ,
                            `prenom` ,
                            `rne` ,
                            `etablissement` ,
                            `classe`,
                            `year`
                            )
                            VALUES (
                            '$ine',
                            '$nom',
                            '$prenom',
                            '$rne',
                            '',
                            '$section',
                            '$current_year'
                            )";
         mysql_query($sql1);
         $sql="INSERT INTO `c2i_annu_note`.`eval` (
                            `ine_pupils` ,

                            `B1` ,
                            `B2` ,
                            `B3` ,
                            `B4` ,
                            `B5` ,
                            `B6` ,
                            `B7`
                            )
                            VALUES (
                             '$ine',
                             '$b1',
                             '$b2',
                             '$b3',
                             '$b4',
                             '$b5',
                             '$b6',
                             '$b7'
                            )";
       }
       mysql_query($sql);
       if(mysql_error())
        { /* Erreur dans la base de donnees, sûrement la table qu'il faut créer */
           print "Erreur dans la base de données : ".mysql_error();
           print "<br>Importation stoppée.";
           exit();
        }
        
      }$i++;
     }

    

     /* Fermeture */
     fclose($fp);

 }
}

?>
