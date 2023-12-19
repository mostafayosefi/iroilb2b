<!DOCTYPE html>
<html {{app()->getLocale()=='fa'?"dir=rtl":"'dir=ltr"}} lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/final-site.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/feather/feather.css') }}">
    <title>{{ app()->getLocale()=='fa'?$setting['site_title_fa'] : $setting['site_title_en']}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('upload/site/' . $setting['fav_icon']) }}" type="image/x-icon">
    <meta name="description" content="ir oil market">
    <meta name="keywords" content="iroilmarket">
</head>
<body class="main">
<div id="site" style="position: relative; min-height: 100vh;"></div>
@vite('resources/js/app.js')
</body>
</html>
