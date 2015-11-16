<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>List recipes</title>
  <meta name="description" content="Recipes overview">
  <meta name="author" content="Recipe Ltd">
</head>

<body>
	<table>
		<thead>
			<tr>
				<th>Recipe name</th>
				<th>Ingedient(s)</th>
				<th>Created by</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($recipes as $recipe) {
			?>
				<tr>
					<td><?php echo htmlentities($recipe->name, ENT_COMPAT, 'utf-8'); ?></td>
					<td><?php echo htmlentities(implode(', ', $recipe->ingredients), ENT_COMPAT, 'utf-8'); ?></td>
					<td><?php echo htmlentities($recipe->creator, ENT_COMPAT, 'utf-8'); ?></td>
					<td><a href="/recipes/<?php echo urlencode($recipe->name); ?>">View</a></td>
				</tr>			
			<?php
				}
			?>
		</tbody>
	</table>	
	<a href="/recipes/add">Add new recipe</a>	
	<a href="/json">Download all recipes (JSON)</a>
</body>
</html>