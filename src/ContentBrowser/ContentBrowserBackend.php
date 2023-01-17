<?php

namespace App\ContentBrowser;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Netgen\ContentBrowser\Backend\BackendInterface;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\ContentBrowser\Item\LocationInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('netgen_content_browser.backend', ['item_type' => 'doctrine_recipe'])]
class ContentBrowserBackend implements BackendInterface {
	public function __construct(private RecipeRepository $recipeRepository) {
	}

	public function getSections(): iterable {
		return [new BrowserRootLocation()];
	}

	public function loadLocation($id): LocationInterface {
		if ($id === '0'){
			return new BrowserRootLocation();
		}

		throw new \InvalidArgumentException(sprintf('Invalid location "%s"', $id));
	}

	public function loadItem($value): ItemInterface {

	}

	public function getSubLocations(LocationInterface $location): iterable {
		return [];
	}

	public function getSubLocationsCount(LocationInterface $location): int {
		return 0;
	}

	public function getSubItems(LocationInterface $location, int $offset = 0, int $limit = 25): iterable {
		$recipes = $this->recipeRepository
			->createQueryBuilderOrderedByNewest()
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery()
			->getResult();

		return array_map(fn(Recipe $recipe) => new RecipeBrowserItem($recipe), $recipes);
	}

	public function getSubItemsCount(LocationInterface $location): int {
		return $this->recipeRepository
			->createQueryBuilderOrderedByNewest()
			->select('COUNT(recipe.id)')
			->getQuery()
			->getSingleScalarResult();
	}

	public function search(string $searchText, int $offset = 0, int $limit = 25): iterable {
		$recipes = $this->recipeRepository
			->createQueryBuilderOrderedByNewest($searchText)
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery()
			->getResult();

		return array_map(fn(Recipe $recipe) => new RecipeBrowserItem($recipe), $recipes);
	}

	public function searchCount(string $searchText): int {
		return $this->recipeRepository
			->createQueryBuilderOrderedByNewest($searchText)
			->select('COUNT(recipe.id)')
			->getQuery()
			->getSingleScalarResult();
	}

}
