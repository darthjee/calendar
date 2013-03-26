<?php

define("PASSFILE", '.htcalpass');

abstract class User
{
  /**
   * @brief checa se o usuario esta logado
   * @return <type>
   */
  static function isLoged()
  {
    if (key_exists("user", $_SESSION) && User::getConf($_SESSION['user']))
      return true;

    return false;
  }

  /**
   * @brief loga o usuario
   * @param <type> $user : nome do usuario
   * @param <type> $senha : senha criptografada
   * @return boolean : resultado do login
   */
  static function login($user, $senha)
  {
    $pass = User::getPass($user);
    if (is_string($pass) && $pass == $senha)
    {
      $_SESSION['user'] = $user;
      return true;
    }
    return false;
  }

  static function getPass($user)
  {
    $udir = "users/$user";
    $passfile =$udir."/".PASSFILE;
    if (file_exists($passfile))
    {
      $pass = file($passfile);
      return $pass[0];
    }
    else
      return null;
  }

  static function getUser()
  {
    if (key_exists("user", $_SESSION))
    {
      return $_SESSION['user'];
    }

    return null;
  }

  /**
   * @brief registra o usuario
   * @param <type> $user : nick
   * @param <type> $pass : senha criptografada
   * @return boolean : codigo de success/falha
   */
  static function registerUser($user, $pass)
  {
    $udir = User::getDir($user, true);
    $passfile = $udir."/".PASSFILE;
    
    if (User::getPass($user) !== null)
      return false;
      
    if (mkdir($udir))
    {
      chmod($udir, DMODE);
      $group = filegroup('users');
      chgrp($udir, $group);
      $FILE = fopen($passfile, 'w');
      fwrite($FILE, $pass);
      fclose($FILE);

      chgrp($passfile, $group);
      chmod($passfile, FMODE);

      $conffile = User::getConf($user, true);
      $conf = new Conf($conffile);
      $conf->save();
      return true;
    }
    return false;
  }

  public static function getDir($user, $nocreate=false)
  {
    $dir = "users/$user";
    if (file_exists($dir) || $nocreate)
      return $dir;
    return false;
  }

  public static function getConf($user, $create=false)
  {
    $file = User::getDir($user)."/.htpal.conf";
    if (file_exists($file) || $create)
      return $file;
    return false;
  }

  public static function logout()
  {
    unset ($_SESSION['user']);
  }

}

?>