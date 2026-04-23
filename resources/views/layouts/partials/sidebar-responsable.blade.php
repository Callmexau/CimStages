<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <a href="{{ route('responsable.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">CIMBURKINA Responsable</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ route('responsable.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('responsable.besoins.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>Emmétre un besoin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('responsable.besoins.etat') }}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Mes Besoins</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('responsable.stagiaires.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Liste stagiaires</p>
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
