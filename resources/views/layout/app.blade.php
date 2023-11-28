<!DOCTYPE html>
<html lang="en" @if(!empty(session('locale')) && session('locale') == "ar") dir="rtl" @endif>
<head>
    <title>@yield('title') - Javul.org</title>
</head>
<body>
@include('layout.head')
</body>
</html>
