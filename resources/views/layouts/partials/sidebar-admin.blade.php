<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.users.index') }}" class="brand-link">
        <span class="brand-text font-weight-light">CIMBURKINA Admin</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Utilisateurs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.structures.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Structures</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
