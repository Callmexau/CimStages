<!-- Sidebar AdminLTE pour Agent RH -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Logo -->
    <a href="{{ route('agent.dashboard') }}" class="brand-link text-center">
        <span class="brand-text fw-bold">CIMBURKINA RH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('agent.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Demandes stagiaires -->
                <li class="nav-item">
                    <a href="{{ route('agent.demande.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Demandes stagiaires</p>
                    </a>
                </li>

                <!-- Demandes besoins responsables -->
                <li class="nav-item">
                    <a href="{{ route('agent.besoins.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Besoins responsables</p>
                    </a>
                </li>

                <!-- Profil / Déconnexion -->
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Profil</p>
                    </a>
                </li>
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
