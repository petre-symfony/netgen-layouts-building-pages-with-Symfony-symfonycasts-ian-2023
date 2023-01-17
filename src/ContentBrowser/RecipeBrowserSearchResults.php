<?php

namespace App\ContentBrowser;

use App\Entity\Recipe;
use Netgen\ContentBrowser\Backend\SearchResultInterface;

class RecipeBrowserSearchResults implements SearchResultInterface {
	public function __construct(private array $results) {
	}

	public function getResults(): iterable {
		return array_map(fn (Recipe $recipe) => new RecipeBrowserItem($recipe), $this->results);
	}
}
