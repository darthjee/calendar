<?php
  global $INCLUDED;
  $INCLUDED = true;
  session_start();

  define("FMODE", 0660);
  define("DMODE", 0770);

  @require_once('func.php');
  @require_once('user_class.php');
  @require_once('month_table.class.php');
  @require_once('events_file.class.php');
  @require_once('event.class.php');
  @require_once('conf.class.php');
?>
