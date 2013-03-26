<?php
  @require_once('engines/calendarCalc.php');
  global $TABLES;
  global $ENDLINE;
    
  foreach($TABLES as $table)
  {
    echo $table->toString();
  }
  echo $ENDLINE;
?>
