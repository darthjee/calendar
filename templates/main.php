<?php
  @require_once('engines/calendarCalc.php');
?>
<div id="main">
  <div id="breadcrumb">
    <ul class="sidelist">
      <form action="engine.php" method="post" onsubmit="return false;" class="ajax" return="div#calendar" validate="return checkLogin(this);">
        <input type="hidden" name="action" value="calendar" />
        <li>
          <label for="fromquery" class="required">Inicio</label>
          <input type="text" name="from" id="fromquery" value="03-2010" />
        </li>
        <li>
          <input type="submit" value="buscar" class="ajax" />
        </li>
      </form>
      <li style="float:right;"><a href="#" onclick="$('body').load('engine.php?action=logout')">logout</a></li>
    </ul>
  </div>
  <div id="block">
    <div id="sidebar">
      <?php
      include('sidebar.php');
      ?>
    </div>
    <div id="calendar">
      <?php
      include('calendar.php');
      ?>
    </div>
  </div>
</div>