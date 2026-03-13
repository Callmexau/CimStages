<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.users.index') }}" class="brand-link">
        <span class="brand-text font-weight-light">CIM Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Utilisateurs internes</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
