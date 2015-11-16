<?php
require '../vendor/autoload.php';

$app = new \Slim\Slim(['templates.path' => '../templates']);

$repo = new \Framtidsutveckling\RecipeRepository();

/**
 * One recipe can have:
 * 
 * - name
 * - ingredients
 * - creator
 *
 * Your task: see TODOs and make this work (and make it better). Do this however you like (classes, libs etc)
 * but the storage method must be file based (as it is now).
 * 
 * Keep it simple but elegant!
 */

$app
	->get('/', function () use ($repo, $app) {
		$recipes = $repo->getAllRecipes();
		
		if (strcasecmp('asc', $app->request->get('order')) == 0) {
			ksort($recipes);
		}
		else if (strcasecmp('desc', $app->request->get('order')) == 0) {
			krsort($recipes);
		}
		else {
			ksort($recipes);
		}
		
		$app->render('list_recipes.php', ['recipes' => $recipes]);
	})
	->name('recipe_list');

$app->get('/recipes/:name', function ($name) use ($repo, $app) {
	if (strcasecmp($name, 'add') == 0) { // Special case for '/recipes/add' - Add new recipe route
		$app->render('add_recipe.php');
		return;
	}
	
	$recipe = $repo->getRecipe($name);
    $app->render('view_recipe.php', ['recipe' => $recipe]);
});

$app
	->post('/recipes/add', function () use ($repo, $app) {
		$args = [
				'name'        => trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)), 
				'ingredients' => array_map(function($v) { return trim(filter_var($v, FILTER_SANITIZE_STRING)); }, (array) $_POST['ingredients']), 
				'creator'	  => trim(filter_var($_POST['creator'], FILTER_SANITIZE_STRING))
				];
		$args = array_filter($args);
	
		$submit_ok = true;
		if (count($args) == 3) {
			$repo->addRecipe($args['name'], $args['ingredients'], $args['creator']);
		}
		else {
			$submit_ok = false;
		}
		
		if ($submit_ok) {
			$app->redirect($app->urlFor('recipe_list'));
		}
		else {
			$app->flash('form.name', $_POST['name']);
			$app->flash('form.ingredients', $_POST['ingredients']);
			$app->flash('form.creator', $_POST['creator']);
			$app->flash('form.submit_error', 'Save failed. This was probably because one or more fields were empty.');
			$app->redirect($app->urlFor('recipe_add'));		
		}
	})
	->name('recipe_add');

$app->get('/json', function () use ($repo, $app) {
	$contents = json_encode($repo->getAllRecipes());

	$app->response->headers->set('Content-Description', 'File Transfer');
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->headers->set('Content-Disposition', 'attachment; filename="recipes.txt"');
	$app->response->headers->set('Content-Length', strlen($contents));
	$app->response->headers->set('Expires', '0');
	$app->response->headers->set('Cache-Control', 'must-revalidate');
	$app->response->headers->set('Pragma', 'public');

	$app->response->setBody($contents);
});

$app->run();

