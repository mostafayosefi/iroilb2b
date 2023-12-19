<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($ads as $ad)
        <url>
            <loc>{{ url('en/ads/' . $ad['slug']) }}</loc>
            <lastmod>{{ $ad['time']->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>Daily</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
</urlset>
