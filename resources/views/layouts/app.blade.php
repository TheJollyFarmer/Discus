<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/trix.css') }}" rel="stylesheet">
    <link href="{{ asset('css/OverlayScrollbars.css') }}" rel="stylesheet">
    @yield('head')
  </head>
  <body class="has-navbar-fixed-top">
    <div
      id="app"
      v-cloak>
      <app :trending="{{ json_encode($trending) }}">
        @yield('content')
      </app>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>