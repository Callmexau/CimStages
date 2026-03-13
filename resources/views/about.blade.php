<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos | CIMBURKINA</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'cim-green': '#1a5a45',
                        'cim-green-light': '#2d7a5f',
                        'cim-green-dark': '#009E49',
                        'cim-beige': '#f5f3e9'
                    }
                }
            }
        };
    </script>

    <style>
        .card-hover {
            transition: 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

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

<section class="bg-cim-green text-white py-20 px-6">
    <div class="max-w-5xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
            À propos de CIMBURKINA
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-3xl mx-auto leading-relaxed">
            Une institution engagée pour le développement industriel et la formation des talents au Burkina Faso.
        </p>
    </div>
</section>

<section class="py-20 bg-white px-6 border-b border-gray-100">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-3xl font-bold text-cim-green mb-6">Qui sommes-nous ?</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">
                CIMBURKINA est un acteur majeur du secteur industriel au Burkina Faso. 
                Engagée dans la production et la distribution de ciment de haute qualité, 
                l'entreprise contribue activement au développement des infrastructures nationales.
            </p>
            <p class="text-gray-600 leading-relaxed">
                À travers sa plateforme officielle de gestion des stages, CIMBURKINA facilite 
                l’accès aux opportunités professionnelles pour les étudiants et jeunes diplômés, 
                tout en assurant un processus structuré, sécurisé et transparent.
            </p>
        </div>
        <div class="relative">
            <img src="{{ asset('images/Gemini_Generated_Image_cywo5ucywo5ucywo.png') }}"
                 class="rounded-2xl shadow-xl w-full object-cover transform hover:scale-[1.02] transition duration-500">
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50 px-6">
    <div class="max-w-6xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-bold text-cim-green">Notre Engagement</h2>
    </div>

    <div class="grid md:grid-cols-3 gap-10">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 card-hover">
            <h3 class="text-xl font-bold text-cim-green mb-4">🎯 Notre Mission</h3>
            <p class="text-gray-600">
                Offrir un cadre structuré et sécurisé pour la gestion des stages, 
                favorisant l'intégration professionnelle des jeunes talents.
            </p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 card-hover">
            <h3 class="text-xl font-bold text-cim-green mb-4">🚀 Notre Vision</h3>
            <p class="text-gray-600">
                Rester une référence nationale en matière d'accompagnement et de formation pratique 
                en entreprise.
            </p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 card-hover">
            <h3 class="text-xl font-bold text-cim-green mb-4">🤝 Nos Valeurs</h3>
            <p class="text-gray-600">
                Transparence, professionnalisme, innovation et responsabilité sociale.
            </p>
        </div>
    </div>
</section>

<section class="py-20 bg-white px-6">
    <div class="max-w-4xl mx-auto text-center bg-cim-beige p-10 rounded-3xl border border-gray-200 shadow-inner">
        <h2 class="text-3xl font-bold text-cim-green mb-6">
            Pourquoi une plateforme de gestion des stages ?
        </h2>
        <p class="text-gray-600 leading-relaxed mb-8">
            Afin d'assurer une meilleure organisation interne et un traitement équitable des demandes, 
            CIMBURKINA a mis en place un système digital permettant :
        </p>
        <ul class="text-gray-700 space-y-4 text-left max-w-md mx-auto font-medium">
            <li class="flex items-center"><span class="text-cim-green-dark mr-3">✔</span> Centralisation des demandes de stage</li>
            <li class="flex items-center"><span class="text-cim-green-dark mr-3">✔</span> Validation interne sécurisée</li>
            <li class="flex items-center"><span class="text-cim-green-dark mr-3">✔</span> Protection des données personnelles</li>
        </ul>
    </div>
</section>

<footer class="bg-cim-green text-white py-6 px-6 mt-8">
    <div class="max-w-7xl mx-auto text-center">
        <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}"
             class="h-10 mx-auto mb-2 rounded shadow-sm">

        <p class="text-cim-beige text-sm mb-4">
            Plateforme officielle de gestion des stages de CIMBURKINA.
        </p>

        <div class="w-full h-px bg-white/10 mb-4"></div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-cim-beige">
            <div class="text-xs">
                © {{ date('Y') }} CIMBURKINA - Tous droits réservés.
            </div>

            <div class="flex flex-col items-center md:items-end">
                <p class="text-[9px] uppercase tracking-[0.2em] text-cim-beige/60 mb-1 font-semibold">
                    Conception & Développement
                </p>
                <div class="flex items-center gap-4">
                    <span class="text-[11px] font-bold text-white uppercase tracking-wider bg-white/5 px-3 py-1 rounded-full border border-white/10">
                        Exaucé Jackson L.
                    </span>
                    
                    <div class="flex items-center gap-3 text-[10px]">
                        <a href="mailto:exaucejacsonl@gmail.com" class="hover:text-white transition-colors">Email</a>
                        <span class="opacity-20">|</span>
                        <a href="https://github.com/Callmexau" target="_blank" class="hover:text-white transition-colors">GitHub</a>
                        <span class="opacity-20">|</span>
                        <a href="https://www.linkedin.com/in/exaucejacksonl/" target="_blank" class="hover:text-white transition-colors">LinkedIn</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>