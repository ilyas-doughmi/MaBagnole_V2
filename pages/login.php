<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | MaBagnole</title>
    
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
                        'locar-orange': '#FF5F00',
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
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Elements -->
    <div class="absolute top-0 right-0 w-2/3 h-full bg-gradient-to-l from-gray-200 to-transparent -z-10"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-locar-orange rounded-full blur-[150px] opacity-10 -z-10"></div>

    <div class="bg-white w-full max-w-5xl rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative z-10">
        
        <!-- Left Side: Login Form -->
        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">
            <div class="mb-10">
                <a href="../index.php" class="inline-flex items-center gap-2 text-gray-400 hover:text-locar-orange transition mb-6 font-bold text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Retour à l'accueil
                </a>
                <h2 class="font-black text-4xl uppercase mb-2">Bon retour !</h2>
                <p class="text-gray-500 font-medium">Connectez-vous pour gérer vos locations.</p>
            </div>

            <form action="../includes/login.php" method="POST" class="space-y-6">
                <input type="text" name="login" id="" hidden>
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="w-full pl-12 pr-4 py-4 bg-gray-50 rounded-lg border border-gray-100 focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/20 outline-none font-bold transition" placeholder="votre@email.com">
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Mot de passe</label>
                        <a href="#" class="text-xs font-bold text-locar-orange hover:underline">Mot de passe oublié ?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="w-full pl-12 pr-4 py-4 bg-gray-50 rounded-lg border border-gray-100 focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/20 outline-none font-bold transition" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full bg-locar-orange hover:bg-black text-white font-bold py-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    SE CONNECTER
                </button>
            </form>
        </div>

        <!-- Right Side: Promo/Register Link -->
        <div class="w-full md:w-1/2 bg-locar-dark text-white p-10 md:p-16 flex flex-col justify-center items-center text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-b from-transparent to-black/80"></div>
            
            <div class="relative z-10">
                <div class="w-20 h-20 bg-locar-orange rounded-2xl flex items-center justify-center text-3xl font-bold mb-8 mx-auto shadow-neon transform rotate-3">
                    <i class="fa-solid fa-car"></i>
                </div>
                
                <h3 class="font-black text-3xl mb-4 uppercase">Nouveau ici ?</h3>
                <p class="text-gray-400 mb-8 leading-relaxed font-medium">
                    Rejoignez <strong>MaBagnole</strong> aujourd'hui et profitez des meilleurs tarifs de location de voitures avec notre programme de fidélité.
                </p>
                
                <a href="inscription.php" class="inline-block bg-white text-black hover:bg-locar-orange hover:text-white font-black py-4 px-10 rounded-full shadow-xl transition-all duration-300 transform hover:scale-105">
                    CRÉER UN COMPTE
                </a>
            </div>

            <!-- Decorative Car Image -->
            <img src="https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png" class="absolute -bottom-20 -right-20 w-96 opacity-30 transform -rotate-12 pointer-events-none">
        </div>
    </div>

</body>
</html>
