<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
    <div id="app">
        <div class="flex h-screen">
	  		<div class="flex-1 flex flex-col overflow-hidden">
				@include('layouts.partials.header')
    			<div class="flex h-full">
					@guest
					@else
	  					@include('layouts.partials.sidebar')
					@endguest
					<main class="flex flex-col w-full bg-white mb-14 mt-5">	
						@yield('content')
					</main>
    			</div>
  			</div>
		</div>
    </div>
	<script type="text/javascript">
        let base_url = "{{URL::to('/')}}/";
	</script>
	@include('layouts.partials.footer')
	@yield('script')
</body>
</html>
