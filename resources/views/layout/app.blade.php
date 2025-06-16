<!DOCTYPE html>
<html lang="en" @if(!empty(session('locale')) && session('locale') == "ar") dir="rtl" @endif>
<head>
    <title>@yield('title') - Javul.org</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
@include('layout.head')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.querySelector('.search_form button');
    const searchInput = document.querySelector('.search_form input');

    if (!searchButton || !searchInput) return;

    searchButton.addEventListener('click', function (e) {
        e.preventDefault();
        const keyword = searchInput.value.trim();
        alert("You searched for: " + keyword);
    });
});
</script>

</body>
</html>
