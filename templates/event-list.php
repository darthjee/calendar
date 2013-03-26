<?php

$file = cleanFileName($_REQUEST['file']);

if ($file)
{
  $event = new EventsFile($file, EF_MODEFILE);
  $color = $event->getColor();
  $type = $event->getType();
  $name = $event->getName();
  $cod = $event->getCod();

  ?>
  <form>
    <input type="hidden" name="file" id="file" value="<?php echo $file ?>" />
    <table>
      <tr>
        <td><label for="name">Nome</label></td>
        <td>
          <input type="text" name="name" id="name" value="<?php echo $name ?>"/>
        </td>
      </tr>
      <tr>
        <td><label for="cod">Codigo</label></td>
        <td>
          <input type="text" name="cod" id="cod" value="<?php echo $cod ?>"/>
        </td>
      </tr>
      <tr>
        <td><label for="color">Cor</label></td>
        <td>
          <input type="text" name="color" id="color" value="<?php echo $color ?>"/>
        </td>
      </tr>
      <tr>
        <td><label for="typer">Tipo</label></td>
        <td>
          <input type="text" name="type" id="type" value="<?php echo $type ?>"/>
        </td>
      </tr>
    </table>
  </form>
  <?php
}
else
  include('calendar.php');

?>