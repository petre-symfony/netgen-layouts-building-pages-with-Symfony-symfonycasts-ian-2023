<?php

namespace App\ContentBrowser;

use Netgen\ContentBrowser\Backend\BackendInterface;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\ContentBrowser\Item\LocationInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('netgen_content_browser.backend', ['item_type' => 'doctrine_recipe'])]
class ContentBrowserBackend implements BackendInterface {
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
		return [];
	}

	public function getSubItemsCount(LocationInterface $location): int {
		return 0;
	}

	public function search(string $searchText, int $offset = 0, int $limit = 25): iterable {
		return [];
	}

	public function searchCount(string $searchText): int {
		return 0;
	}

}
