<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title'){{site_name()}}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    @include('admin.partials.style')
    </head>
    <body>
    @include('admin.partials.header')
    @include('admin.partials.aside')
    
    @yield('content')
    @include('admin.partials.footer')
    @include('admin.partials.script')
    </body>
</html>