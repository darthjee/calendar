<?php
  global $TABLES;
  global $ENDLINE;
  $TABLES = array();
  
  if (key_exists('from', $_REQUEST))
    $from = fixMonth($_REQUEST['from']);

  if ($from != null)
    $dateopt = "-d $from";
  if ($conf = User::getConf($_USER))
  {
    exec("pal --html -f $conf $dateopt", $output);
    $table = new MonthTable();

    foreach ($output as $row)
    {
      if (!$table->addRow($row))
      {
        $TABLES[] = $table;
        $table = new MonthTable();
      }
    }
    $ENDLINE = $table->toString();
  }
  
?>
