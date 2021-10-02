<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>
        <li class="sidebar-item {{ (request()->is('dashboard*')) ? 'active' : '' }} ">
            <a href="{{route("dashboard")}}" class='sidebar-link'>
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item {{ (request()->is('ebikes*')) ? 'active' : '' }} ">
            <a href="{{route("ebikes.index")}}" class='sidebar-link'>
                <i class="fas fa-bicycle"></i>
                <span>Bici Elettriche</span>
            </a>
        </li>
        <li class="sidebar-item {{ (request()->is('sparepars*')) ? 'active' : '' }} ">
            <a href="{{route("spareparts.index")}}" class='sidebar-link'>
                <i class="fas fa-wrench"></i>
                <span>Parti di ricambio</span>
            </a>
        </li>
        <li class="sidebar-item {{ (request()->is('users*')) ? 'active' : '' }} ">
            <a href="{{route("users.index")}}" class='sidebar-link'>
                <i class="fas fa-users"></i>
                <span>Utenti</span>
            </a>
        </li>
    </ul>
</div>
