<?php
	if (isset($_GET['input']))
	echo stripslashes(htmlentities($_GET['input']));
?>

<form method="get">
<input name="input" type="text"/>
<input type="submit"/>
</form>