<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tableclass
 *
 * @author darthjee
 */
class MonthTable {
    //put your code here
    private $rows;
    private $month;

    public function MonthTable()
    {
      $this->rows = array();
      $this->month = "";
    }

    public function addRow($row)
    {
      $this->rows[] = $row;
      if (MonthTable::desCribeMonth($row))
        $this->month = MonthTable::retrieveMonth($row);
      return !$this->hasEnded();
    }

    public static function isNewMonthTable($row)
    {
      if (preg_match("/<table [^>]*class=[\"']pal-cal[\"'][^>]*>/", $row))
        return true;
      return false;
    }

    public static function desCribeMonth($row)
    {
      if (preg_match("/<td [^>]*class=[\"']pal-month[\"'][^>]*>[a-zA-Z]*[^<a-zA-Z]*\d{4}<\/td>/", $row))
        return true;
      return false;
    }

    public static function retrieveMonth($row)
    {
      return preg_replace("/.*<td [^>]*class=[\"']pal-month[\"'][^>]*>([a-zA-Z]*)[^<a-zA-Z]*\d{4}<\/td>.*/", "$1", $row);
    }

    public function toString()
    {
      return implode("\n", $this->rows);
    }

    public function hasEnded()
    {
      $regexp = "/.*<\/table>.*/";
      if (count($this->rows) && preg_match($regexp, end($this->rows)))
        return true;
      return false;
    }

    public function getMonth()
    {
      return $this->month;
    }

}
?>
