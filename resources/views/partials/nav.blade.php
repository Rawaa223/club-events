<nav class="topbar">
    <div class="container">
        <a href="{{ route('home') }}" class="logo"><span class="mark">CE</span><span class="name">Club Events</span></a>
        <div class="links">
            <a href="{{ route('events.index') }}" @class(['active' => request()->routeIs('events.*') && ! request()->routeIs('events.json')])>Events</a>
            <a href="{{ route('members.index') }}" @class(['active' => request()->routeIs('members.*')])>Members</a>
            <a href="{{ route('events.json') }}">JSON</a>
        </div>
    </div>
</nav>
