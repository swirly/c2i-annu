<?php

class C2iException extends Exception {
    static public $errors=array(
	'ldap_connect_failure'=>array('number'=>'1',
				      'message'=>"connexion au ldap impossible"),
	'ldap_bind_failure'=>array('number'=>'2',
				   'message'=>"connexion au ldap impossible"),
	'ldap_auth_failure'=>array('number'=>'3',
				   'message'=>'Echec à l\'authentification'),

	'file_open_failure'=>array('number'=>'10',
				   'message'=>'Impossible d\'accéder au fichier'),
	'file_auth_failure'=>array('number'=>'11',
				   'message'=>'Echec à l\'authentification'),
	'passwords_dont_match'=>array('number'=>'128',
				      'message'=>'Les mots de passe de concordent pas'),
	'empty_password'=>array('number'=>'129',
				'message'=>'Les mots de passe vide sont proscrits'),
	'no_file_upload'=>array('number'=>'130',
				'message'=>'Le téléchargement a échoué'),
	'empty_file_upload'=>array('number'=>'131',
				'message'=>'Le fichier est vide'),
	'no_file_open'=>array('number'=>'132',
				'message'=>'Impossible d\'ouvrir le fichier'),
	'bad_csv'=>array('number'=>'133',
				'message'=>'Le format du CSV est mauvais')	
				);

    protected $details;

    public function  __construct($id,$details="") {
	parent::__construct(C2iException::$errors[$id]['message'],C2iException::$errors[$id]['number']);
	$this->details=$details;
   }    

    public function getDetails() {
	return $this->details;
    }

}

?>