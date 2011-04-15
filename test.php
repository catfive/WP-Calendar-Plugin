<?php print_r($_POST['select']); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$('#submit').click(function(){
			$('#select option').attr('selected','selected');
		});
		$('#add').click(function(){
			$('#select').append('<option>new option</option>');
		});
		$('#remove').click(function(){
			$('option:selected').remove();
		})
	});
</script>

<form method="post">
	<select style="float:left" name="select[]" id="select" multiple="multiple">
		<option value="oh">ohai</option>
		<option value="kt">kthxbai</option>
	</select>
	<input type="button" id="add" value="+"><br>
	<input type="button" id="remove" value="&minus;"><br>
	<br>
	<input style="clear:both" id="submit" type="submit">
</form>