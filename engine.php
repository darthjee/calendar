<html><body>
<?php
@require_once('includes/basic.php');


if (User::isLoged())
{
  global $_USER;
  $_USER = User::getUser();
}

if (key_exists('action',$_REQUEST))
{
  switch ($_REQUEST['action'])
  {
    case 'login' :
    case 'register' :
    case 'logout' :
      include('templates/login.php');
      break;
    case 'calendar' :
      include('templates/calendar.php');
      break;
    case 'event-list' :
      include('templates/event-list.php');
      break;
  }
}

?>
</body></html>