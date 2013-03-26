<?php

define("CFN_WAIT",1);
define("CFN_LOAD",2);


class Conf
{
  private $file;
  private $dir;
  private $user;
  private $events = array();

  static $dirRegexp = "/^(users\/[^\/]+\/)(.*)$/";
  
  public function __construct($file, $mode=CFN_WAIT)
  {
    $this->file = preg_replace(Conf::$dirRegexp, "$2", $file);
    $this->dir = preg_replace(Conf::$dirRegexp, "$1", $file);
    
    switch ($mode)
    {
      case CFN_WAIT :
        break;
      case CFN_LOAD :
        break;
    }
  }
  
  public function save()
  {
    $fname = $this->dir."/".$this->file;
    $group = filegroup($this->dir);

    $file = fopen($fname, 'w');
    $events = $this->events;
    if ($events) foreach ($events as $event)
    {
      fwrite($file, $event->getSaveString()."\n");
      $event->save();
    }
    fclose($file);
    chgrp($fname, $group);
    chmod($fname, FMODE);
  }
  
  public function addEventFile($event)
  {
    $this->events[] = $event;
  }
}

?>