<?php

function fixMonth($month)
{
  $month = preg_replace("/.*(\d{2}|Abril)[-\/](\d{4}).*$/", "$1/$2", $month);
  if (preg_match("/^(\d{2}|Abril)[-\/]\d{4}$/", $month))
    return $month;
  return null;
}

function cleanFileName($name)
{
  $name = preg_replace("/^([\w\d-_]+)$/", "$1", $name);
  if (preg_match("/^([\w\d-_]+)$/", $name))
    return $name;
  return null;
}

?>
