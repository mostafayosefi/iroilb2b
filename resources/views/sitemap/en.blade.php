<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('en/sitemap.xml/companies') }}</loc>
        <lastmod>{{ $companies->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>WEEKLY</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ url('en/sitemap.xml/ads') }}</loc>
        <lastmod>{{ $ads->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>Daily</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ url('en/sitemap.xml/pages') }}</loc>
        <lastmod>{{ $pages->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>WEEKLY</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('en/sitemap.xml/articles') }}</loc>
        <lastmod>{{ $articles->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>Daily</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('en/sitemap.xml/categories') }}</loc>
        <lastmod>{{ $categories->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>WEEKLY</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ url('en/sitemap.xml/tags') }}</loc>
        <lastmod>{{ $tags->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>WEEKLY</changefreq>
        <priority>0.6</priority>
    </url>
</urlset>
