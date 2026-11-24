<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Club Events') · Club Events</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f7f5f0;        /* warm paper */
            --surface: #ffffff;
            --ink: #1d1b16;
            --muted: #6f6a60;
            --line: #e6e1d6;
            --accent: #2f5d50;    /* deep green */
            --accent-dark: #234a3f;
            --accent-soft: #e4eeea;
            --warm: #d9692c;      /* orange for dates */
            --danger: #b3261e;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Inter, system-ui, sans-serif; background: var(--bg); color: var(--ink); line-height: 1.6; font-size: 15px; }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 1.25rem; }

        /* Header */
        nav.topbar { background: var(--surface); border-bottom: 1px solid var(--line); }
        nav.topbar .container { display: flex; align-items: center; gap: 1.75rem; height: 64px; }
        .logo { display: flex; align-items: center; gap: .6rem; margin-right: auto; color: var(--ink); font-family: Fraunces, Georgia, serif; font-weight: 700; font-size: 1.25rem; }
        .logo:hover { text-decoration: none; }
        .logo .mark { width: 32px; height: 32px; border-radius: 8px; background: var(--accent); color: #fff; display: grid; place-items: center; font-size: .95rem; }
        nav.topbar .links a { color: var(--muted); font-weight: 500; padding: 1.3rem 0; border-bottom: 2px solid transparent; margin-left: 1.5rem; }
        nav.topbar .links a:hover { color: var(--ink); text-decoration: none; }
        nav.topbar .links a.active { color: var(--ink); border-bottom-color: var(--accent); }

        main.container { padding-top: 2.5rem; padding-bottom: 4rem; min-height: calc(100vh - 64px - 72px); }
        h1, h2, h3 { font-family: Fraunces, Georgia, serif; font-weight: 700; line-height: 1.2; letter-spacing: -.01em; }
        h1 { margin: 0 0 1.5rem; font-size: 2.2rem; }
        h2 { font-size: 1.35rem; margin: 2.25rem 0 1rem; }
        .page-head { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .page-head h1 { margin: 0; }
        .muted { color: var(--muted); font-size: .9rem; }

        /* Buttons */
        .btn { display: inline-block; padding: .5rem 1rem; border-radius: 8px; border: 1px solid var(--line); background: var(--surface); color: var(--ink); cursor: pointer; font: inherit; font-weight: 500; transition: background .15s, border-color .15s; }
        .btn:hover { text-decoration: none; border-color: #cfc8b8; background: #fbfaf7; }
        .btn-primary { background: var(--accent); border-color: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent-dark); border-color: var(--accent-dark); }
        .btn-danger { color: var(--danger); border-color: #ecc9c6; }
        .btn-danger:hover { background: var(--danger); border-color: var(--danger); color: #fff; }

        /* Panels */
        .card { background: var(--surface); border: 1px solid var(--line); border-radius: 12px; padding: 1.5rem; }

        /* Event cards: calendar date on the left, details on the right, capacity bar at the bottom */
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 1rem; }
        .event-card { background: var(--surface); border: 1px solid var(--line); border-radius: 12px; padding: 1.1rem; display: grid; grid-template-columns: 56px 1fr; gap: .25rem 1rem; transition: border-color .15s, box-shadow .15s, transform .15s; }
        .event-card:hover { border-color: #cfc8b8; box-shadow: 0 8px 20px rgba(29,27,22,.07); transform: translateY(-2px); }
        .event-card .date { grid-row: span 2; text-align: center; border: 1px solid var(--line); border-radius: 10px; overflow: hidden; align-self: start; }
        .event-card .date .mon { display: block; background: var(--warm); color: #fff; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; padding: .15rem 0; }
        .event-card .date .day { display: block; font-family: Fraunces, Georgia, serif; font-size: 1.5rem; font-weight: 700; padding: .2rem 0; }
        .event-card h3 { margin: 0; font-size: 1.1rem; }
        .event-card h3 a { color: var(--ink); }
        .event-card .info { color: var(--muted); font-size: .85rem; }
        .event-card .info a { color: var(--muted); text-decoration: underline; text-decoration-color: var(--line); }
        .event-card .foot { grid-column: 1 / -1; margin-top: .75rem; padding-top: .75rem; border-top: 1px dashed var(--line); display: flex; align-items: center; gap: .75rem; font-size: .8rem; color: var(--muted); }
        .bar { flex: 1; height: 6px; background: #efebe3; border-radius: 999px; overflow: hidden; }
        .bar span { display: block; height: 100%; background: var(--accent); border-radius: 999px; }

        .badge { display: inline-block; padding: .1rem .55rem; border-radius: 999px; font-size: .75rem; font-weight: 600; background: var(--accent-soft); color: var(--accent); white-space: nowrap; }
        .badge.past { background: #efebe3; color: var(--muted); }
        .badge.full { background: #f8e3e1; color: var(--danger); }

        .alert { padding: .8rem 1rem; border-radius: 10px; margin-bottom: 1.5rem; }
        .alert-success { background: var(--accent-soft); color: var(--accent-dark); border: 1px solid #c5dbd3; }
        .alert-error { background: #f8e3e1; color: var(--danger); border: 1px solid #ecc9c6; }

        /* Forms */
        form.filters { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.75rem; }
        form.filters input[type=search] { flex: 1; min-width: 200px; }
        label { display: block; font-weight: 600; font-size: .9rem; margin-bottom: .3rem; }
        label .muted { font-weight: 400; }
        input, select, textarea { width: 100%; padding: .55rem .75rem; border: 1px solid var(--line); border-radius: 8px; font: inherit; background: var(--surface); color: var(--ink); }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-soft); }
        form.filters input, form.filters select { width: auto; }
        .field { margin-bottom: 1.2rem; }
        .field.has-error input, .field.has-error select, .field.has-error textarea { border-color: var(--danger); }
        .error { color: var(--danger); font-size: .85rem; margin: .3rem 0 0; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .checklist { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: .25rem .75rem; max-height: 260px; overflow-y: auto; padding: .6rem .75rem; border: 1px solid var(--line); border-radius: 8px; background: var(--surface); }
        .field.has-error .checklist { border-color: var(--danger); }
        label.check { display: flex; align-items: center; gap: .5rem; font-weight: 400; font-size: .95rem; margin: 0; padding: .25rem .35rem; border-radius: 6px; cursor: pointer; }
        label.check:hover { background: var(--bg); }
        label.check input { width: auto; margin: 0; accent-color: var(--accent); }

        /* Tables */
        table { width: 100%; border-collapse: separate; border-spacing: 0; background: var(--surface); border: 1px solid var(--line); border-radius: 12px; overflow: hidden; }
        th, td { text-align: left; padding: .75rem 1rem; border-bottom: 1px solid #f0ece4; }
        th { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); background: #fbfaf7; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fbfaf7; }
        td a { font-weight: 500; }

        /* Pagination */
        ul.pagination { list-style: none; padding: 0; display: flex; gap: .5rem; justify-content: center; }
        ul.pagination li > * { display: inline-block; padding: .45rem 1rem; border: 1px solid var(--line); border-radius: 8px; background: var(--surface); }
        ul.pagination li.disabled > * { color: var(--muted); opacity: .6; }

        footer.site { border-top: 1px solid var(--line); height: 72px; display: flex; align-items: center; }
        footer.site .container { width: 100%; display: flex; justify-content: space-between; color: var(--muted); font-size: .85rem; }

        @media (max-width: 600px) {
            nav.topbar .container { gap: 1rem; }
            nav.topbar .links a { margin-left: .9rem; }
            .logo .name { display: none; }
            h1 { font-size: 1.75rem; }
            .row { grid-template-columns: 1fr; gap: 0; }
            table { display: block; overflow-x: auto; }
        }
    </style>
</head>
<body>
    @include('partials.nav')

    <main class="container">
        @include('partials.flash')

        @yield('content')
    </main>

    <footer class="site">
        <div class="container">
            <span>Club Events</span>
            <span>© {{ date('Y') }}</span>
        </div>
    </footer>
</body>
</html>
