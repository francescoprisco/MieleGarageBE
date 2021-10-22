<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>
        <li class="sidebar-item {{ (request()->is('dashboard*')) ? 'active' : '' }} ">
            <a href="{{route("dashboard")}}" class='sidebar-link'>
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-gear-fill"></i>
                <span>Bici Elettriche</span>
            </a>
            <ul class="submenu">
                <li class="submenu-item {{ (request()->is('ebikes*')) ? 'active' : '' }}">
                    <a href="{{route('ebikes.index')}}" class='sidebar-link'>
                        <i class="bi bi-bicycle"></i>
                        <span>Lista Bici</span>
                    </a>
                </li>
                <li class="submenu-item {{ (request()->is('*connector*')) ? 'active' : '' }}">
                <a href="{{route('ebikesconnector.index')}}" class='sidebar-link'>
                        <i class="bi bi-bicycle"></i> <i class="bi bi-people"></i>
                        <span>Assegna Bici</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item {{ (request()->is('spareparts*')) ? 'active' : '' }} ">
            <a href="{{route("spareparts.index")}}" class='sidebar-link'>
                <i class="fas fa-wrench"></i>
                <span>Parti di ricambio</span>
            </a>
        </li>
        <li class="sidebar-item {{ (request()->is('orders*')) ? 'active' : '' }} ">
            <a href="{{route("orders.index")}}" class='sidebar-link'>
                <i class="fas fa-list"></i>
                <span>Ordini</span>
            </a>
        </li>
        <li class="sidebar-item {{ (request()->is('users*')) ? 'active' : '' }} ">
            <a href="{{route("users.index")}}" class='sidebar-link'>
                <i class="fas fa-users"></i>
                <span>Utenti</span>
            </a>
        </li>
        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-gear-fill"></i>
                <span>Impostazioni</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="{{route('deliveryfees.index')}}" class='sidebar-link'>
                        <i class="bi bi-pen-fill"></i>
                        <span>Costi di spedizione</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
