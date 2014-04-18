<?php

require_once('/etc/c2i-annu/config.php');
require_once('include/ldap.inc.php');
require_once('include/people-class.inc.php');


class user {
  public $auth;
  public $uid;
  public $type;
  public $rne;

  function __construct($login) {
    $this->uid = $login;
  }

  function __tostring() {
    return $this->uid;
  }
      

  function unlog() {
  }

  
  protected static function validate_login_in_file($login,$password) {
      global $c2i_password_file;
      if (!is_file($c2i_password_file)) {
	  throw new C2iException('file_open_failure');
      }
      /* read the lines ... */
      $fcontents = file($c2i_password_file);
      while (list($line_num, $line) = each($fcontents)) {
	  $line = trim($line);
	  list($file_login, $file_password) = explode(":", $line, 2);
	  /* make password test only for the good login :) */
	  if ($file_login == $login) {
	      /* hashing password with the same file_password salt and compare */
	      $crypted_pass = crypt($password, $file_password);
	      if ($crypted_pass == $file_password) {
		  return true;
	      } else {
		  throw new C2iException('file_auth_failure');
	      }
	  }
      }
      return false;
  }
  
  protected static function validate_login_in_ldap($login,$password) {
      global $c2i_ldap;
      
      if ($ds= @ldap_connect($c2i_ldap['ip'],$c2i_ldap['port'])) {
	  if ( @ldap_bind($ds, "uid=".$login.",".$c2i_ldap["people_dn"], $password)) {
	      return true;
	  } else {
	      if (@ldap_errno($ds) == 49) {
		  throw new C2iException('ldap_auth_failure'); 
	      } else {
		  throw new C2iException('ldap_bind_failure'," erreur LDAP numéro ".@ldap_errno($ds)." : ".@ldap_error($ds));
	      }
	  }
	  @ldap_close($ds);
      } else {
	  throw new C2iException('ldap_connect_failure');
      }
      
      return false;
  }
  
  protected static function validate_login($login,$password) {
      /* first file login */
      if (user::validate_login_in_file($login,$password)) {
	  return "file";
      }	
      if (user::validate_login_in_ldap($login,$password)) {
	  return 'ldap';
      }
      /* else not logged in */
      return false;
  }
  
  public static function authentify($login,$password) {
      
      switch (user::validate_login($login,$password)) {
      case 'file':
	  $user = new user($login);
	  $user->type='sadmin';
	  $user->rne='-1';
	  $user->auth='file';
	  $_SESSION['user']=$user;
	  return true;
	  break;
      case 'ldap':
	  $user = new user($login);
	  $user->auth='ldap';
	  $people = new people($login);
	  $user->type = $people->type;
	  if ($user->type=='sadmin') {
	      $user->rne='-1';
	  } 
	  else {
	      $user->rne=$people->rne;
	  }	
	  $_SESSION['user']=$user;
	  return true;
	  break;
      default:
	  return false;
	  break;
      }
  }
  
}

session_start();

?>