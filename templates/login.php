<?php
@require_once('includes/basic.php');

if (key_exists("action", $_REQUEST))
{
  if (key_exists('login', $_POST))
    $user = $_POST['login'];
  if (key_exists('pass-crypt', $_POST))
    $pass = $_POST['pass-crypt'];
    
  switch ($_REQUEST['action'])
  {
    case 'login' :
      if ($logged = User::login($user, $pass))
      {
        global $_USER;
        $_USER = User::getUser();
        include('main.php');
      }
      else
        echo "Login Falhou";
      break;

    case 'register' :
      if ($logged = User::registerUser($user, $pass))
      {
        global $_USER;
        $_USER = User::getUser();
        include('main.php');
      }
      else
        echo "Usuario ja cadastrado";
      break;

    case 'logout' :
      User::logout();
      $logged = false;
      break;
  }
}

if (!(isset($logged) && $logged))
{
?>
  <form id="loginform" action="engine.php" method="post" class="ajax" return="body" validate="return checkLogin(this);" onsubmit="return false;">
    <input type="hidden" id="pass-crypt" name="pass-crypt"/>
    <table>
      <tr>
        <td><label for="login" class="required">Login: </label></td>
        <td><input type="text" id="login" name="login"/></td>
      </tr>
      <tr>
        <td><label for="pass" class="required">Password: </label></td>
        <td><input type="password" id="pass" name="pass"/></td>
      </tr>
    </table>
    <input type ="radio" name="action" value="login" id="action-login" checked="checked" />
    <label for="action-login">Login</label>
    <input type ="radio" name="action" value="register" id="action-register" />
    <label for="action-register">Register</label>
    <br />
    <input type="submit" id="submitbt" class="ajax" />
  </form>
<?php
}

?>