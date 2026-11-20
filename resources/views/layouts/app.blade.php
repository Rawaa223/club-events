<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Club Events') · Club Events</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, sans-serif; background: #f5f6f8; color: #1f2328; line-height: 1.5; }
        a { color: #2a5bd7; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 1rem; }
        nav.topbar { background: #1f2a44; color: #fff; padding: .8rem 0; }
        nav.topbar .container { display: flex; gap: 1.5rem; align-items: center; }
        nav.topbar a { color: #fff; }
        nav.topbar .brand { font-weight: 700; font-size: 1.15rem; margin-right: auto; }
        main { padding: 1.5rem 0 3rem; }
        h1 { margin: 0 0 1rem; }
        .page-head { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .btn { display: inline-block; padding: .45rem .9rem; border-radius: 6px; border: 1px solid #c9ced6; background: #fff; color: #1f2328; cursor: pointer; font-size: .95rem; }
        .btn:hover { text-decoration: none; background: #eef0f3; }
        .btn-primary { background: #2a5bd7; border-color: #2a5bd7; color: #fff; }
        .btn-primary:hover { background: #224bb3; }
        .btn-danger { background: #c62828; border-color: #c62828; color: #fff; }
        .btn-danger:hover { background: #a61f1f; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; }
        .card { background: #fff; border: 1px solid #e1e4e8; border-radius: 8px; padding: 1rem; }
        .card h3 { margin: 0 0 .3rem; }
        .muted { color: #656d76; font-size: .9rem; }
        .badge { display: inline-block; padding: .1rem .5rem; border-radius: 999px; font-size: .8rem; background: #e7edfb; color: #2a5bd7; }
        .badge.past { background: #eee; color: #656d76; }
        .badge.full { background: #fde8e8; color: #c62828; }
        .alert { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert-success { background: #e6f4ea; color: #1e6b34; border: 1px solid #b7dfc3; }
        .alert-error { background: #fde8e8; color: #8a1c1c; border: 1px solid #f3baba; }
        form.filters { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1rem; }
        label { display: block; font-weight: 600; margin-bottom: .25rem; }
        input, select, textarea { width: 100%; padding: .5rem; border: 1px solid #c9ced6; border-radius: 6px; font: inherit; background: #fff; }
        form.filters input, form.filters select { width: auto; }
        .field { margin-bottom: 1rem; }
        .field.has-error input, .field.has-error select, .field.has-error textarea { border-color: #c62828; }
        .error { color: #c62828; font-size: .9rem; margin: .25rem 0 0; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { text-align: left; padding: .6rem; border-bottom: 1px solid #e1e4e8; }
        ul.pagination { list-style: none; padding: 0; display: flex; gap: .5rem; }
        ul.pagination li > * { display: inline-block; padding: .35rem .8rem; border: 1px solid #c9ced6; border-radius: 6px; background: #fff; }
        ul.pagination li.disabled { opacity: .5; }
    </style>
</head>
<body>
    @include('partials.nav')

    <main class="container">
        @include('partials.flash')

        @yield('content')
    </main>
</body>
</html>
