<aside class="main-sidebar sidebar-dark-info elevation-4">
    <a href="{{ route('stagiaire.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">CIMBURKINA Stagiaire</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ route('stagiaire.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stagiaire.demande.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Nouvelle demande</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stagiaire.demande.show') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Ma demande</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
