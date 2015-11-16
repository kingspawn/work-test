<?php
	namespace Framtidsutveckling;
	
	class RecipeRepository {
		protected $items = [];
		protected $filename;
		protected $dirty = false;
		
		function __construct(array $cfg = []) {
			if (empty($cfg['filename'])) { // Default file
				$cfg['filename'] = __DIR__.'/recipes.txt';
			}

			$this->filename = $cfg['filename'];
			
			if (is_readable($cfg['filename'])) { // Allow creation of new files 
				foreach(file($cfg['filename'], FILE_IGNORE_NEW_LINES) as $line) {
					$parts = explode(';', $line);
					
					if (count($parts) == 3) {
						$this->items [$parts[0]]= (object) ['name'        => $parts[0],
															 'ingredients' => explode(',', $parts[1]),
															 'creator'     => $parts[2]];				
					}
					else {
						//throw new \ErrorException('Unable to load recipe: '.$line);
					}
				}
			}
		}

		function __destruct() {
			if ($this->dirty) {
				file_put_contents(
						$this->filename, 
						implode("\n", 
								array_map(
										function($v) {
											return implode(
													';',
													[$v->name, implode(',', $v->ingredients), $v->creator]
													);
										},
										$this->items 
								))
				);			
			}
		}
		
		public function getAllRecipes() {
			return $this->items;
		}
		
		public function getRecipe($name) {
			return array_key_exists($name, $this->items) ? $this->items[$name] : null;
		}
		
		public function addRecipe($name, $ingredients, $creator) {
			$this->items [$name]= (object) ['name'        => $name,
											 'ingredients' => $ingredients,
											 'creator'     => $creator];
			
			$this->dirty = true;
		}
	}