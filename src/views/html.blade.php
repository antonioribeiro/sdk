<!DOCTYPE html>
<html lang="{!! $html_lang or 'en' !!}" {!! isset($html_attributes) ? explode_attributes($html_attributes) : '' !!}> <!--<![endif]-->
	<head>
		<meta charset="{!! $html_charset or 'utf-8' !!}" />

		<title>{!! $html_title or '' !!}</title>

		<meta name="keywords" content="{!! $html_keywords or '' !!}" />
		<meta name="description" content="{!! $html_description or '' !!}" />
		<meta name="Author" content="{!! $html_author or '' !!}" />

		@if (isset($html_meta_tags))
		    @foreach ($html_meta_tags as $meta)
		        {!! $meta !!}
		    @endforeach
		@endif

        @if (isset($html_viewport))
		    <!-- mobile settings -->
		    <meta name="viewport" content="{!! $html_viewport !!}" />
		@endif

		@yield('html.head')
	</head>

	<body {!! isset($html_body_attributes) ? explode_attributes($html_body_attributes) : '' !!}>

		@yield('html.body')

		@yield('html.footer')

		@yield('pragmarx/sdk::partials.googleanalytics')

	</body>
</html>
