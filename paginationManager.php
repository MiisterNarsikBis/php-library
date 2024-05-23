<?php

/**
 * Génère des liens de pagination.
 *
 * @param int $totalItems Le nombre total d'éléments.
 * @param int $currentPage La page actuelle.
 * @param int $perPage Le nombre d'éléments par page.
 * @return array Les liens de pagination.
 */
function paginate($totalItems, $currentPage, $perPage)
{
    $totalPages = ceil($totalItems / $perPage);
    $pagination = [];

    for ($page = 1; $page <= $totalPages; $page++) {
        $pagination[] = [
            'page' => $page,
            'isCurrent' => $page == $currentPage,
            'url' => '?page=' . $page
        ];
    }

    return $pagination;
}

// Exemple d'utilisation
$totalItems = 100;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$paginationLinks = paginate($totalItems, $currentPage, $perPage);

foreach ($paginationLinks as $link) {
    if ($link['isCurrent']) {
        echo '<strong>' . $link['page'] . '</strong> ';
    } else {
        echo '<a href="' . $link['url'] . '">' . $link['page'] . '</a> ';
    }
}
