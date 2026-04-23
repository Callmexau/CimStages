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

                <li class="nav-item">
                    <a href="{{ route('admin.logs.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Journal d'activité</p>
                    </a>
                </li>

                <!-- Déconnexion -->
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start w-100">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Déconnexion</p>
                        </button>
                    </form>
                </li>
                
            </ul>
        </nav>
    </div>
</aside>
