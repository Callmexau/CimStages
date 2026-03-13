<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIM BURKINA - Forgez votre futur</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

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
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .swiper-slide img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR -->

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

<!-- HERO avec CAROUSEL -->
<section class="relative text-white py-6 md:py-10 px-6">
    <div class="max-w-7xl mx-auto">

        <!-- Carousel -->
        <div class="relative w-full overflow-hidden rounded-2xl shadow-lg">
            <div class="carousel relative w-full h-64 md:h-96">

                <!-- Slide 1 -->
                <div class="carousel-item absolute inset-0 transition-opacity duration-1000 opacity-100">
                    <img src="{{ asset('images/Gemini_Generated_Image_cywo5ucywo5ucywo.png') }}" alt="CIMBURKINA Stage 1"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col items-start justify-center px-6 md:px-16">
                        <h1 class="text-3xl md:text-5xl font-extrabold mb-2">Forgez votre futur avec CIMBURKINA</h1>
                        <p class="text-lg md:text-2xl max-w-xl opacity-90">La plateforme officielle de gestion des stages.</p>
                        <div class="mt-4 flex space-x-3">
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-cim-green text-white font-semibold rounded-lg hover:bg-cim-green-dark transition shadow-md">S'inscrire</a>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-white text-cim-green font-semibold rounded-lg hover:bg-gray-100 transition shadow-md">Se connecter</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item absolute inset-0 transition-opacity duration-1000 opacity-0">
                    <img src="{{ asset('images/Gemini_Generated_Image_e1amjxe1amjxe1am.png') }}" alt="CIMBURKINA Stage 2"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col items-start justify-center px-6 md:px-16">
                        <h1 class="text-3xl md:text-5xl font-extrabold mb-2">Simplifiez vos stages</h1>
                        <p class="text-lg md:text-2xl max-w-xl opacity-90">Un processus clair et sécurisé pour candidats et structures.</p>
                        <div class="mt-4 flex space-x-3">
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-cim-green text-white font-semibold rounded-lg hover:bg-cim-green-dark transition shadow-md">S'inscrire</a>
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-white text-cim-green font-semibold rounded-lg hover:bg-gray-100 transition shadow-md">Se connecter</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
<div class="carousel-item absolute inset-0 transition-opacity duration-1000 opacity-0">
    <img src="{{ asset('images/Gemini_Generated_Image_5jd0f65jd0f65jd0.png') }}" alt="CIMBURKINA Stage 3"
        class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col items-start justify-center px-6 md:px-16">
        <h1 class="text-3xl md:text-5xl font-extrabold mb-2">Déposez vos demandes en quelques clics</h1>
        <p class="text-lg md:text-2xl max-w-xl opacity-90">
            Une plateforme simple et sécurisée pour envoyer vos demandes de stage et être contacté rapidement.
        </p>
        <div class="mt-4 flex space-x-3">
            <a href="{{ route('register') }}" class="px-6 py-2 bg-cim-green text-white font-semibold rounded-lg hover:bg-cim-green-dark transition shadow-md">S'inscrire</a>
            <a href="{{ route('login') }}" class="px-6 py-2 bg-white text-cim-green font-semibold rounded-lg hover:bg-gray-100 transition shadow-md">Se connecter</a>
        </div>
    </div>
</div>


            </div>

            <!-- Carousel Controls -->
            <button class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-80 text-cim-green rounded-full p-2" onclick="prevSlide()">
                &#10094;
            </button>
            <button class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-80 text-cim-green rounded-full p-2" onclick="nextSlide()">
                &#10095;
            </button>
        </div>

    </div>
</section>

<script>
    // Carousel JS minimal
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-item');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.opacity = (i === index) ? '1' : '0';
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    // Auto-play toutes les 5 secondes
    setInterval(nextSlide, 5000);

    showSlide(currentSlide);
</script>


<!-- SECTION : Pourquoi choisir CIM -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-bold text-cim-green">Pourquoi choisir CIMBURKINA ?</h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
            Une plateforme moderne, simple et sécurisée mise à disposition des stagiaires et des structures.
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">
        <div class="text-center p-8 bg-gray-50 rounded-2xl shadow-sm hover:shadow-xl card-hover">
            <h3 class="text-xl font-bold text-cim-green mb-2">Simplicité</h3>
            <p class="text-gray-600">Un portail unique pour toutes les demandes de stage.</p>
        </div>

        <div class="text-center p-8 bg-gray-50 rounded-2xl shadow-sm hover:shadow-xl card-hover">
            <h3 class="text-xl font-bold text-cim-green mb-2">Confidentialité</h3>
            <p class="text-gray-600">Les informations sensibles sont traitées en interne et ne sont pas publiques.</p>
        </div>

        <div class="text-center p-8 bg-gray-50 rounded-2xl shadow-sm hover:shadow-xl card-hover">
            <h3 class="text-xl font-bold text-cim-green mb-2">Sécurité</h3>
            <p class="text-gray-600">Les données sont protégées et hébergées localement.</p>
        </div>
    </div>
</section>

<!-- SECTION : Processus -->
<section class="py-20 bg-white px-6">
    <div class="max-w-7xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-bold text-cim-green">Comment ça fonctionne ?</h2>
    </div>

    <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">
        <div class="text-center p-8">
            <div class="w-16 h-16 mx-auto bg-cim-green text-white flex items-center justify-center rounded-full mb-4 text-2xl font-bold shadow-md">1</div>
            <h3 class="text-xl font-bold text-cim-green mb-2">Créez votre compte</h3>
            <p class="text-gray-600">Inscrivez-vous pour accéder à votre espace personnel.</p>
        </div>

        <div class="text-center p-8">
            <div class="w-16 h-16 mx-auto bg-cim-green text-white flex items-center justify-center rounded-full mb-4 text-2xl font-bold shadow-md">2</div>
            <h3 class="text-xl font-bold text-cim-green mb-2">Déposez votre demande</h3>
            <p class="text-gray-600">Soumettez votre demande de stage en ligne.</p>
        </div>

        <div class="text-center p-8">
            <div class="w-16 h-16 mx-auto bg-cim-green text-white flex items-center justify-center rounded-full mb-4 text-2xl font-bold shadow-md">3</div>
            <h3 class="text-xl font-bold text-cim-green mb-2">Validation interne</h3>
            <p class="text-gray-600">Les responsables et RH valident vos demandes en interne.</p>
        </div>
    </div>
</section>

<!-- FOOTER -->
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
