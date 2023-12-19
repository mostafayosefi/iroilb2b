<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if($postes)
        @foreach ($postes as $post)
            <url>
                <loc>{{ url('en/post/' . $post['slug']) }}</loc>
                <lastmod>{{ $post['time']->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>WEEKLY</changefreq>
                <priority>1</priority>
            </url>
        @endforeach
    @endif;
</urlset>
