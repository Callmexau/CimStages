<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CIMBURKINA')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind (pour cohérence avec welcome) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'cim-green': '#1a5a45',
                        'cim-green-dark': '#009E49',
                        'cim-beige': '#f5f3e9'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-800">

<!-- ================= HEADER ================= -->
<nav class="bg-white shadow-sm px-6 py-4 sticky top-0 z-50 backdrop-blur-lg bg-opacity-80">
    <div class="max-w-7xl mx-auto flex items-center justify-between">

        <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
            <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}"
                 alt="Logo CIM Burkina"
                 class="h-12 rounded transition duration-300 group-hover:scale-105">

            <div class="flex flex-col items-center">
                <span class="text-2xl font-bold text-cim-green tracking-wide group-hover:text-cim-green-dark transition leading-none">
                    CIMBURKINA
                </span>
                <span class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold mt-1">
                    Portail des Stages
                </span>
            </div>
        </a>

        <div class="flex items-center space-x-3">
            <a href="{{ route('register') }}"
               class="px-6 py-2 border-2 border-cim-green text-cim-green rounded-lg hover:bg-cim-green hover:text-white transition">
                S'inscrire
            </a>
            <a href="{{ route('login') }}"
               class="px-6 py-2 bg-cim-green text-white rounded-lg hover:bg-cim-green-dark transition">
                Se connecter
            </a>
        </div>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<main>
    @yield('content')
</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-cim-green text-white py-6 px-5 mt-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start gap-8 border-b border-white/10 pb-6">
            
            <div class="max-w-xs">
                <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}" class="h-10 mb-2 rounded shadow-sm">
                <p class="text-cim-beige text-xs leading-relaxed">
                    Plateforme officielle de gestion des stages de CIMBURKINA.
                </p>
            </div>

            <div class="flex gap-12 text-sm">
                <div>
                    <h4 class="font-bold text-white mb-2 text-xs uppercase tracking-wider">Liens</h4>
                    <ul class="space-y-1 text-cim-beige">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">À propos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Mentions</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-2 text-xs uppercase tracking-wider">Contact</h4>
                    <ul class="space-y-1 text-cim-beige text-xs">
                        <li>Ouagadougou, BF</li>
                        <li>contact@cimburkina.gov.bf</li>
                        <li>Tel : 25 30 00 48</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center pt-4 text-cim-beige text-[10px] opacity-70">
            © {{ date('Y') }} CIMBURKINA - Tous droits réservés.
        </div>
    </div>
</footer>

</body>
</html>
