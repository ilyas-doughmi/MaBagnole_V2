<?php
// Start session as seen in your Header.php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Location de Voitures</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito Sans', 'sans-serif'],
                    },
                    colors: {
                        'locar-orange': '#FF5F00', // Your exact orange color
                        'locar-black': '#1a1a1a',
                        'locar-dark': '#0F0F0F',
                    },
                    boxShadow: {
                        'neon': '0 0 20px rgba(255, 95, 0, 0.4)',
                    }
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; }
        ::-webkit-scrollbar-thumb { background: #FF5F00; border-radius: 4px; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased overflow-x-hidden">

    <?php $root_path = ''; include 'pages/header.php'; ?>

    <div id="loginModal" class="fixed inset-0 z-50 hidden bg-black/90 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white w-full max-w-4xl rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative">
            <button onclick="toggleLogin()" class="absolute top-4 right-4 text-gray-400 hover:text-locar-orange font-bold text-xl z-20">✕</button>
            
            <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
                <div class="text-center mb-8">
                    <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/logo1233.png" class="h-12 mx-auto mb-4" alt="Logo">
                    <h3 class="font-black text-2xl uppercase">Connexion</h3>
                </div>
                <form action="login.php" method="POST" class="space-y-5">
                    <div>
                        <label class="text-xs font-bold text-gray-400">EMAIL</label>
                        <input type="text" name="Em_log" class="w-full p-3 bg-gray-100 rounded border-none focus:ring-2 focus:ring-locar-orange outline-none font-bold" placeholder="votre@email.com">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400">MOT DE PASSE</label>
                        <input type="password" name="Mp_log" class="w-full p-3 bg-gray-100 rounded border-none focus:ring-2 focus:ring-locar-orange outline-none font-bold" placeholder="••••••••">
                    </div>
                    <button type="submit" name="BTNLOGIN" class="w-full bg-locar-orange hover:bg-black text-white font-bold py-4 rounded shadow-lg transition-all duration-300">
                        SE CONNECTER
                    </button>
                </form>
            </div>

            <div class="w-full md:w-1/2 bg-locar-orange text-white p-10 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-black text-2xl mb-4">Pas encore membre ?</h3>
                    <p class="text-sm opacity-90 mb-6 leading-relaxed">
                        Adhésion GRATUITE ! Grâce au programme <strong>CAR&RENT+</strong>, la location de voiture n’a jamais été aussi facile.
                    </p>
                    <ul class="text-left text-sm font-bold space-y-2 mb-8 inline-block">
                        <li><i class="fa-solid fa-check mr-2 text-black/30"></i> C'est rapide</li>
                        <li><i class="fa-solid fa-check mr-2 text-black/30"></i> C'est Flexible</li>
                        <li><i class="fa-solid fa-check mr-2 text-black/30"></i> C'est facile</li>
                    </ul>
                    <a href="pages/inscription.php" class="inline-block bg-black hover:bg-gray-900 text-white font-bold py-3 px-8 rounded-full shadow-xl transition">
                        S'INSCRIRE
                    </a>
                </div>
                <i class="fa-solid fa-car-side absolute -bottom-10 -right-10 text-9xl text-white opacity-20 transform -rotate-12"></i>
            </div>
        </div>
    </div>

    <!-- Nav removed, using header.php -->

    <section id="ShowCars" class="relative bg-locar-dark text-white min-h-screen pt-20 flex items-center overflow-hidden">
        <div class="absolute top-0 right-0 w-2/3 h-full bg-gradient-to-l from-[#151515] to-transparent z-0"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-locar-orange rounded-full blur-[150px] opacity-20"></div>

        <div class="container mx-auto px-4 relative z-10 w-full">
            <div class="text-center mb-12 animate-fade-in-down">
                <h5 class="text-locar-orange font-bold tracking-[0.3em] uppercase mb-2 text-sm">Modèles de Véhicules</h5>
                <h1 class="text-3xl md:text-5xl font-black uppercase leading-tight">
                    Réservez maintenant <br> et obtenez <span class="text-transparent bg-clip-text bg-gradient-to-r from-locar-orange to-red-500">la meilleure offre</span>
                </h1>
                <div class="w-16 h-1 bg-locar-orange mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                
                <div class="lg:w-1/4 text-center lg:text-left space-y-6">
                    <div>
                        <span class="inline-block bg-gray-800 px-3 py-1 rounded text-xs font-bold text-gray-400 uppercase mb-2">Catégorie : Confort</span>
                        <h2 class="text-6xl font-black italic tracking-tighter">VOLVO <span class="text-stroke-orange text-transparent" style="-webkit-text-stroke: 1px #FF5F00;">V6</span></h2>
                    </div>
                    
                    <div class="flex items-baseline justify-center lg:justify-start gap-2">
                        <span class="text-6xl font-bold text-locar-orange">75$</span>
                        <span class="text-gray-400 font-bold">/ JOUR</span>
                    </div>

                    <button class="bg-locar-orange hover:bg-white hover:text-black text-white font-bold py-4 px-8 rounded w-full shadow-neon transition transform hover:-translate-y-1">
                        RÉSERVER MAINTENANT
                    </button>
                </div>

                <div class="lg:w-1/2 relative group">
                    <div class="absolute inset-0 bg-locar-orange/10 blur-3xl rounded-full transform group-hover:scale-110 transition duration-700"></div>
                    <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png" alt="Car" class="relative z-10 w-full drop-shadow-2xl transform group-hover:scale-105 transition duration-500">
                </div>

                <div class="lg:w-1/4 grid grid-cols-2 lg:grid-cols-1 gap-4">
                    <div class="flex items-center gap-4 bg-white/5 p-3 rounded-lg border border-white/10 hover:border-locar-orange transition">
                        <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/Door.png" class="w-8 h-8 invert opacity-70">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Portes</p>
                            <span class="font-bold text-lg">5</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/5 p-3 rounded-lg border border-white/10 hover:border-locar-orange transition">
                        <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/person.png" class="w-8 h-8 invert opacity-70">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Passagers</p>
                            <span class="font-bold text-lg">5</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/5 p-3 rounded-lg border border-white/10 hover:border-locar-orange transition">
                        <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/travel.png" class="w-8 h-8 invert opacity-70">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Bagages</p>
                            <span class="font-bold text-lg">5 Sacs</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/5 p-3 rounded-lg border border-white/10 hover:border-locar-orange transition">
                        <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/shifter.png" class="w-8 h-8 invert opacity-70">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Boite</p>
                            <span class="font-bold text-lg">ATM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="relative -mt-16 z-20 px-4 mb-20">
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-2xl p-8 border-b-4 border-locar-orange">
            <div class="text-center mb-6">
                <h3 class="text-xl font-black text-gray-800 uppercase">Réservez une voiture aujourd'hui !</h3>
            </div>
            
            <form class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/calendar (3).png" class="w-5 h-5 opacity-50">
                    </div>
                    <input type="text" name="dateP" placeholder="DATE DEPART" onfocus="(this.type='date')" onblur="(this.type='text')" 
                        class="w-full pl-10 pr-4 py-4 bg-gray-100 rounded-lg font-bold text-sm focus:ring-2 focus:ring-locar-orange outline-none transition cursor-pointer">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/calendar (3).png" class="w-5 h-5 opacity-50">
                    </div>
                    <input type="text" name="dateR" placeholder="DATE RETOUR" onfocus="(this.type='date')" onblur="(this.type='text')" 
                        class="w-full pl-10 pr-4 py-4 bg-gray-100 rounded-lg font-bold text-sm focus:ring-2 focus:ring-locar-orange outline-none transition cursor-pointer">
                </div>

                <div>
                    <button type="submit" class="w-full h-full bg-black hover:bg-locar-orange text-white font-bold rounded-lg uppercase tracking-wide transition shadow-lg flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>


    <section id="Service" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-locar-orange font-bold uppercase tracking-widest text-sm">Nos Services</span>
                <h2 class="text-4xl font-black text-gray-900 mt-2">LE MEILLEUR SERVICE AU MONDE</h2>
            </div>

            <div class="flex flex-col md:flex-row items-center bg-white rounded-2xl overflow-hidden shadow-xl mx-auto max-w-6xl">
                <div class="w-full md:w-1/2 h-80 md:h-auto relative">
                    <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/Propos.jpg" class="absolute inset-0 w-full h-full object-cover">
                </div>
                
                <div class="w-full md:w-1/2 p-12 bg-white relative">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-locar-orange/10 rounded-full"></div>
                    
                    <h3 class="text-3xl font-black uppercase mb-6 text-gray-800">Fuel Plans</h3>
                    <p class="text-gray-500 leading-8 text-lg">
                        Nous proposons un certain nombre d'options pratiques de plan de location de carburant. 
                        Payez à l'avance pour une réservation plein d'essence et ramenez la voiture vide ou 
                        achetez simplement un réservoir plein juste avant de retourner la voiture au lieu de restitution.
                    </p>
                    
                    <div class="mt-8 flex gap-4">
                        <div class="bg-gray-100 p-3 rounded-full text-locar-orange"><i class="fa-solid fa-gas-pump text-xl"></i></div>
                        <div class="bg-gray-100 p-3 rounded-full text-locar-orange"><i class="fa-solid fa-wallet text-xl"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="Propos" class="py-20 bg-white">
        <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2">
                <span class="text-locar-orange font-bold uppercase tracking-widest text-sm">À Propos De Nous</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-3 mb-8">LARGE GAMME DE VÉHICULES</h2>
                
                <div class="border-l-4 border-locar-orange pl-6 py-2 mb-8">
                    <h4 class="text-xl font-bold text-gray-800 uppercase mb-2">Meilleurs tarifs de location</h4>
                    <p class="text-gray-500 leading-relaxed">
                        L'une des plus grandes sociétés de location de voitures au monde. Plus de 200 véhicules dans le monde et plus de 80 voitures premium.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-6 bg-gray-50 rounded-xl">
                        <span class="block text-4xl font-black text-locar-orange">200+</span>
                        <span class="text-xs font-bold text-gray-400 uppercase">Véhicules</span>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-xl">
                        <span class="block text-4xl font-black text-locar-orange">80+</span>
                        <span class="text-xs font-bold text-gray-400 uppercase">Premium</span>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 relative">
                <div class="absolute inset-0 bg-locar-orange transform rotate-3 rounded-2xl opacity-10"></div>
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="About" class="relative rounded-2xl shadow-2xl transform -rotate-2 hover:rotate-0 transition duration-500">
            </div>
        </div>
    </section>

    <section id="Contact" class="py-20 bg-locar-orange text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        
        <div class="container mx-auto px-4 relative z-10 max-w-4xl text-center">
            <h2 class="text-4xl font-black uppercase mb-4">Nous Contacter</h2>
            <p class="text-white/80 mb-2 font-medium">Vous avez des questions ou besoin d'informations complémentaires ?</p>
            <p class="bg-black/20 inline-block px-4 py-1 rounded-full text-sm font-bold mb-10">
                <i class="fa-solid fa-location-dot mr-2"></i> 4 Bloc 24 Quartier Riyad 45060, SAFI
            </p>

            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" placeholder="VOTRE NOM" class="w-full p-4 bg-white/10 border border-white/20 rounded text-white placeholder-white/60 focus:bg-white/20 focus:outline-none font-bold">
                    <input type="text" placeholder="VOTRE PRÉNOM" class="w-full p-4 bg-white/10 border border-white/20 rounded text-white placeholder-white/60 focus:bg-white/20 focus:outline-none font-bold">
                </div>
                <textarea rows="5" placeholder="VOTRE MESSAGE..." class="w-full p-4 bg-white/10 border border-white/20 rounded text-white placeholder-white/60 focus:bg-white/20 focus:outline-none font-bold"></textarea>
                
                <button type="button" class="bg-black hover:bg-gray-900 text-white font-bold py-4 px-12 rounded shadow-xl mt-4 transition">
                    ENVOYER LE MESSAGE
                </button>
            </form>
        </div>
    </section>

    <section id="Adresse" class="py-16 bg-white border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-center items-center gap-12 text-center">
                <div class="bg-gray-50 p-8 rounded-2xl w-full md:w-64 hover:shadow-lg transition group">
                    <i class="fa-solid fa-location-arrow text-3xl text-gray-300 group-hover:text-locar-orange mb-4 transition"></i>
                    <h4 class="font-black text-gray-800 uppercase">Mohammedia</h4>
                    <p class="text-sm text-gray-500 font-bold mt-2">3 QUARTIER LA COLINE</p>
                </div>

                <div class="opacity-50 grayscale hover:grayscale-0 transition duration-500">
                    <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_Site/logo1233.png" alt="Locar Logo" class="h-16">
                </div>

                <div class="bg-gray-50 p-8 rounded-2xl w-full md:w-64 hover:shadow-lg transition group">
                    <i class="fa-solid fa-location-arrow text-3xl text-gray-300 group-hover:text-locar-orange mb-4 transition"></i>
                    <h4 class="font-black text-gray-800 uppercase">Safi</h4>
                    <p class="text-sm text-gray-500 font-bold mt-2">RÉSIDENCE NAWRES</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-locar-dark text-white py-10">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <p class="font-bold tracking-wider text-sm">© 2025 MA BAGNOLE. TOUS DROITS RÉSERVÉS</p>
                <p class="text-xs text-gray-500 mt-1 font-bold">CRÉÉ PAR ID</p>
            </div>
            
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded bg-gray-800 flex items-center justify-center hover:bg-locar-orange transition text-white">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded bg-gray-800 flex items-center justify-center hover:bg-locar-orange transition text-white">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded bg-gray-800 flex items-center justify-center hover:bg-locar-orange transition text-white">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded bg-gray-800 flex items-center justify-center hover:bg-locar-orange transition text-white">
                    <i class="fa-brands fa-skype"></i>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Modal Logic
        function toggleLogin() {
            const modal = document.getElementById('loginModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        // Placeholder for the AJAX search logic in your original script
        // async function remplissage_Select_Mod() { ... }
    </script>
</body>
</html>