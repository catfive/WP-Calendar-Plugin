<?php 
echo "here is my array of choices: ". print_r($_POST['array']) . "<br>";
echo "here is what i get when i trim it: ".trim($_POST['array']); 
?>

<form method="post">
<select style="width:100px" multiple="multiple" name="array[]">
<option value="1">1</option>
<option value="2">2</option>
</select><br>
<input type="submit">
</form>