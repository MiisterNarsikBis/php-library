<?php

/**
 * Génère un sitemap XML.
 *
 * @param array $urls Les URLs à inclure dans le sitemap.
 * @param string $filePath Le chemin du fichier XML à générer.
 * @return bool true en cas de succès, false sinon.
 */
function generateSitemap($urls, $filePath)
{
    $xml = new SimpleXMLElement('<urlset/>');
    $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    foreach ($urls as $url) {
        $urlElement = $xml->addChild('url');
        $urlElement->addChild('loc', htmlspecialchars($url['loc']));
        if (isset($url['lastmod'])) {
            $urlElement->addChild('lastmod', $url['lastmod']);
        }
        if (isset($url['changefreq'])) {
            $urlElement->addChild('changefreq', $url['changefreq']);
        }
        if (isset($url['priority'])) {
            $urlElement->addChild('priority', $url['priority']);
        }
    }

    return $xml->asXML($filePath);
}

// Exemple d'utilisation
$urls = [
    ['loc' => 'https://www.example.com/', 'lastmod' => '2024-01-01', 'changefreq' => 'daily', 'priority' => '1.0'],
    ['loc' => 'https://www.example.com/about', 'lastmod' => '2024-01-01', 'changefreq' => 'monthly', 'priority' => '0.8'],
];
generateSitemap($urls, __DIR__ . '/sitemap.xml');
