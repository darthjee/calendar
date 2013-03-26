<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

define ("EV_DAILY", 1);
define ("EV_MONTHLY", 2);
define ("EV_ANNUAL", 3);
define ("EV_ANNUALORDER", 4);
define ("EV_MONTHLYORDER", 5);
define ("EV_ANNUALLAST", 6);
define ("EV_MONTHLYLAST", 7);
define ("EV_EASTER", 8);

/**
 * Description of eventclass
 *
 * @author darthjee
 */
class Event {
  var $type;

  static $eventRepeatTypeRexp = array(
    EV_DAILY => '(DAILY|MON|TUE|WED|THU|FRI|SAT|SUN)',
    EV_MONTHLY => '(0{6}\d{2})',
    EV_ANNUAL => '(0{4}\d{4})',
    EV_ANNUALORDER => '(\*\d{4})',
    EV_MONTHLYORDER => '(\*00\d{2})',
    EV_ANNUALLAST => '(\*\d{2}L\d)',
    EV_MONTHLYLAST => '(\*00L\d)',
    EV_EASTER => '(Easter[+-]\d{3})'
  );
  static $eventRepeatRexp = array(
    "((:\d{8}){2})",
    "(\/\d{1,}:\d{8})"
  );
  static $eventSingleRexp = array(
    'unique' => '([1-9][0-9]{7})',
    'todo' => '(TODO)'
  );
  static $eventTimeRexp = "((\d{2}:\d{2})\s*)?";
  static $eventNameRexp = "(.*)";

  public function getSaveString()
  {
    return "20121229 00:00 fim do mundo";
  }

  public static function getEventTypeRexp()
  {
    $repeats = "(".implode("|", Event::$eventRepeatTypeRexp).")(".implode("|", Event::$eventRepeatRexp).")?";
    $single = "(".implode("|", Event::$eventSingleRexp).")";
    $regexp = "^\s*($single|$repeats)\s*".Event::$eventTimeRexp;
    $regexp = "/$regexp/";
    return $regexp;
  }

  public static function isEvent($row)
  {
    if (preg_match(Event::getEventTypeRexp(), $row))
    {
      echo "$row-><br />";
    }
    return false;
  }
}
?>
