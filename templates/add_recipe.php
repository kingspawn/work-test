<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Add new recipe</title>
  <meta name="description" content="New recipe form">
  <meta name="author" content="Recipe Ltd">

  <style type="text/css">
	fieldset {
	    border-style: none;
	}
	label {
	    display: block;
	    margin-bottom: .5em;
	}
	label span {
		display: inline-block;
		width: 20em;
	}
  </style>
</head>

<body>
	<form action="/recipes/add" method="post">
		<fieldset>
			<label>
				<span>Recipe name</span>
				<input type="text" name="name" <?php echo trim($flash['form.name'])!='' ? 'value="'.$flash['form.name'].'" ' : ''; ?>/>
			</label>
			<label>
				<span>Comma separated list of ingredients</span>
				<input type="text" name="ingredients" <?php echo trim($flash['form.ingredients'])!='' ? 'value="'.$flash['form.ingredients'].'" ' : ''; ?>/>
			</label>
			<label>
				<span>Creator of recipe</span>
				<input type="text" name="creator" <?php echo trim($flash['form.creator'])!='' ? 'value="'.$flash['form.creator'].'" ' : ''; ?>/>
			</label>
			<?php
				if (isset($flash['form.submit_error'])) {
					echo '<p class="errormsg">'.$flash['form.submit_error'].'</p>';
				}
			?>
		</fieldset>
		
		<fieldset>
			<input type="submit" value="Save recipe" />
			<a href="/">To recipe list</a>
		</fieldset>
	</form>
</body>
</html>