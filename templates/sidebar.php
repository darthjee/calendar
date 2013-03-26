<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $TABLES;
global $_USER;

$evtnFiles = EventsFile::getAllEvents($_USER);

?>
<ul id="menu-list">
  <li>
    Months
    <ul id='month-list'>
      <?php
      foreach ($TABLES as $table)
      {
        $month = $table->getMonth();
        ?>
        <li>
          <?php echo $month ?>
        </li>
        <?php
      }
      ?>
    </ul>
  </li>
  <li>Tipos de Eventos
    <ul id="event-list">
      <?php
      if ($evtnFiles) foreach ($evtnFiles as $event)
      {
        $str = $event->toString();
        ?>
        <li><?php echo $str ?></li>
        <?php
      }
      ?>
    </ul>
  </li>
  <li>Configura&ccedil;&otilde;es</li>
</ul>
