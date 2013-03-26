<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

define("EF_TITLE", 1);
define("EF_EVENT", 2);
define("EF_HIDTYPE", 'Escondido');
define("EF_PADTYPE", 'Padrao');
define("EF_HIDSTR", 'file_hide');
define("EF_PADSTR", 'file');

define("EF_MODEROW", 1);
define("EF_MODENOREAD", 2);
define("EF_MODEFILE", 3);


/**
 * Description of eventsclass
 *
 * @author darthjee
 */
class EventsFile {
  
  private $file;
  private $dir;
  private $color;
  private $type;
  private $name;
  private $key;
  private $events = array();

  static $titleexp = "/^\s*([\w\d]{2})\s*([^\s]*)$/";
  static $confexp = "/^\s*(file[^\s]*)\s*([^\s]*)\s*\((.*)\)[\n\r]*/";

  public function __construct($string, $mode=EF_MODEROW)
  {
    switch ($mode)
    {
      case EF_MODEROW :
        $this->EventsFileFromRow($string);
        break;
      case EF_MODENOREAD :
        $this->setMainData($string);
        break;
      case EF_MODEFILE :
        $this->EventsFileFromFile($string);
        break;
    }
    $user = User::getUser();
    $this->dir = User::getDir($user);
  }

  private function setMainData($row)
  {
    $this->file = EventsFile::extractFileName($row);
    $this->color = EventsFile::extractColor($row);
    $this->type = EventsFile::extractType($row);
  }

  private function EventsFileFromRow($row)
  {
    $this->setMainData($row);
    $this->parseFileToName();
  }

  private function EventsFileFromFile($file)
  {
    $this->setFileName($file);
    $conf = User::getConf(User::getUser());
    $rows = file($conf);

    foreach ($rows as $row)
    {
      if (EventsFile::isFile($row) && EventsFile::extractFileName($row) == $this->file)
      {
        $this->setMainData($row);
        break;
      }
    }
    $this->parseFile();
  }

  public function getFile()
  {
    return $this->file;
  }

  public function getColor()
  {
    return $this->color;
  }

  public function getType()
  {
    return $this->type;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getCod()
  {
    return $this->key;
  }
  
  public function getSaveString()
  {
    switch ($this->type)
    {
      case EF_HIDTYPE :
        $type = EF_HIDSTR; 
        break;
      case EF_PADTYPE :
        $type = EF_PADSTR; 
        break;
    }
    $file = $this->file;
    $color = $this->color;
    return "$type $file ($color)";
  }

  public function getFileName()
  {
    return preg_replace("/.htpal(.*).pal/", "$1", $this->file);
  }

  public function setFileName($file)
  {
    $this->file = ".htpal$file.pal";
  }

  public function setName($row)
  {
    $conf = EventsFile::extractTitleLine($row);
    $this->key = $conf->key;
    $this->name = $conf->name;
  }

  public function save()
  {
    $group = filegroup("users");
    $fname = $this->dir."/".$this->file;
    $file = fopen($fname, "w");
    $key = $this->key;
    $name = $this->name;
    fwrite($file, "$key $name\n");

    $events = $this->events;
    if ($events) foreach ($events as $event)
    {
      $str = $event->getSaveString();
      fwrite($file, "$str\n");
    }
    fclose($file);
    chgrp($fname, $group);
    chmod($fname, FMODE);
  }

  public function add($event)
  {
    $this->events[] = $event;
  }

  public function toString()
  {
    $color = $this->color;
    $name = $this->name;
    $file = $this->getFileName();
    $href = "engine.php?action=event-list&amp;file=$file";
    $str = "<a class='evtn-$color ajax' href='$href' target='#calendar' onclick='return false;'>";
    $str.= "$name</a>";

    return $str;
  }

  public function parseFileToName()
  {
    global $_USER;

    $dir = User::getDir($_USER);
    $file = $dir."/".$this->file;
    $rows = file($file);

    foreach ($rows as $row)
    {
      if (EventsFile::identifyLine($row) == EF_TITLE)
      {
        $this->setName($row);
        break;
      }
    }
  }

  public function parseFile()
  {
    global $_USER;

    $dir = User::getDir($_USER);
    $file = $dir."/".$this->file;
    $rows = file($file);

    foreach ($rows as $row)
    {
      switch (EventsFile::identifyLine($row))
      {
        case EF_TITLE :
          if (!$this->name)
          {
            $conf = EventsFile::extractTitleLine($row);
            $this->key = $conf->key;
            $this->name = $conf->name;
          }
          break;
      }
    }
  }

  public static function identifyLine($row)
  {
    if (preg_match(EventsFile::$titleexp, $row))
      return EF_TITLE;
    if(Event::isEvent($row))
      return EF_EVENT;
  }


  public static function extractTitleLine($row)
  {
    $rtn->key = preg_replace(EventsFile::$titleexp, "$1", $row);
    $rtn->name = preg_replace(EventsFile::$titleexp, "$2", $row);
    return $rtn;
  }

  public static function getAllEvents($user)
  {
    $conf = User::getConf($user);

    $rows = file($conf);

    $Events = array();

    if ($rows) foreach($rows as $row)
    {
      if (EventsFile::isFile($row))
        $Events[] = new EventsFile($row);
    }
    return $Events;
  }

  public static function isFile($row)
  {
    return preg_match(EventsFile::$confexp, $row);
  }

  public static function extractFileName($row)
  {
    return preg_replace(EventsFile::$confexp, "$2", $row);
  }

  public static function extractColor($row)
  {
    return preg_replace(EventsFile::$confexp, "$3", $row);
  }

  public static function extractType($row)
  {
    $aux = preg_replace(EventsFile::$confexp, "$1", $row);
    $type = '';
    switch ($aux)
    {
      case EF_HIDSTR :
        $type = EF_HIDTYPE;
        break;
      case EF_PADSTR :
        $type = EF_PADTYPE;
        break;
    }
    return $type;
  }
}
?>
