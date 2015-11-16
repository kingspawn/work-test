<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>View recipe - <?php echo $recipe ? htmlentities($recipe->name, ENT_COMPAT, 'utf-8') : 'Not found'; ?></title>
  <meta name="description" content="Recipe information">
  <meta name="author" content="Recipe Ltd">
</head>

<body>
	<?php if ($recipe) { ?>
	<div>
		<p>Name: <?php echo htmlentities($recipe->name, ENT_COMPAT, 'utf-8'); ?></p>
		<p>
			Ingredients
			<ul>
				<?php
					foreach($recipe->ingredients as $ingredient) {
						echo '<li>'.htmlentities($ingredient, ENT_COMPAT, 'utf-8').'</li>';
					}
				?>
			</ul>
		</p>		
		<p>Created by: <?php echo htmlentities($recipe->creator, ENT_COMPAT, 'utf-8'); ?></p>
	</div>
	<?php } else { ?>
		<p>Unknown recipe! Apologies!</p>
	<?php } ?>
	<a href="/">Back to recipe list</a>
</body>
</html>