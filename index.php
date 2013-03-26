<?php
  @require_once('includes/basic.php');
?>
<html>
  <head>
    <title>Pal Calendar Web Interface</title>
    <link rel='stylesheet' href='calendar.css' type='text/css' />
    <script type="text/javascript" src='scripts/jquery-1.3.2.js'></script>
    <script type="text/javascript" src='scripts/jquery.cookie.js'></script>
    <script type="text/javascript" src='scripts/jquery.pure.js'></script>
    <script type="text/javascript" src='scripts/md5.js'></script>
    <script type="text/javascript" src='scripts/calendar.js'></script>
  </head>  
  <body>
  <?php
    if (User::isLoged())
    {
      global $_USER;
      $_USER = User::getUser();
      include('templates/main.php');
    }
    else
    {
      include('templates/login.php');
    }
  ?>
  </body>

</html>
