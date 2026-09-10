{{--
  XML sitemap.

  Every URL is built with route(), not a hardcoded domain, so the whole
  sitemap follows APP_URL. While the app is served from /app the entries read
  https://jaipurbnb.com/app/... ; once the document root is repointed at
  laravel_app/public and APP_URL loses its /app suffix, the same template
  emits root-domain URLs with no edit.

  Only publicly visible listings appear - Property::publiclyVisible() is the
  same scope the browse page uses, so the sitemap can never advertise a
  pending, rejected or expired listing.

  The declaration below is assembled by concatenation on purpose. A literal
  XML prolog written out in full contains a PHP close sequence, and Blade
  tokenises the template with token_get_all() before compiling - so the
  prolog terminates the generated PHP early and the view dies with a syntax
  error. Splitting the angle brackets keeps that sequence out of the source.
--}}
{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>{{ url('/') }}</loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>{{ route('properties.browse') }}</loc>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc>{{ route('contact') }}</loc>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
@foreach ($properties as $property)
  <url>
    <loc>{{ route('properties.show', $property->id) }}</loc>
    <lastmod>{{ $property->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
@endforeach
  <url>
    <loc>{{ route('legal.terms') }}</loc>
    <changefreq>yearly</changefreq>
    <priority>0.3</priority>
  </url>
  <url>
    <loc>{{ route('legal.privacy') }}</loc>
    <changefreq>yearly</changefreq>
    <priority>0.3</priority>
  </url>
  <url>
    <loc>{{ route('legal.refund') }}</loc>
    <changefreq>yearly</changefreq>
    <priority>0.3</priority>
  </url>
  <url>
    <loc>{{ route('legal.host-terms') }}</loc>
    <changefreq>yearly</changefreq>
    <priority>0.3</priority>
  </url>
</urlset>
