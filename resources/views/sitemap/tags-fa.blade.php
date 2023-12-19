<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($tags as $tag)
        <url>
            <loc>{{ url('fa/tag/' . $tag['slug']) }}</loc>
            <lastmod>{{ $tag['time']->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>WEEKLY</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
</urlset>
