<?php
session_start();
require_once "../Classes/db.php";
require_once "../Classes/Theme.php";
require_once "../includes/guard.php";

require_login();

$db = DB::connect();
$themeObj = new Theme($db);
$themes = $themeObj->getThemes();
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir un Thème | Blog MaBagnole</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        'brand-orange': '#FF3B00',
                        'brand-black': '#0a0a0a',
                        'brand-gray': '#121212',
                        'surface': '#ffffff',
                    }
                }
            }
        }
    </script>
    <style>
        /* Premium Background Pattern */
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
        }
        .card-hover-effect {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover-effect:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-gray-50 text-brand-black antialiased selection:bg-brand-orange selection:text-white flex flex-col min-h-screen">

    <?php $root_path = '../'; include 'header.php'; ?>

    <header class="pt-32 pb-12 px-6 relative bg-white border-b border-gray-100 overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-50"></div>
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-gray-50 to-transparent"></div>
        
        <div class="container mx-auto max-w-7xl relative z-10 text-center">
            <span class="inline-block py-1 px-3 border border-brand-black/10 rounded-full text-brand-black text-[10px] font-bold tracking-widest uppercase mb-4 bg-white shadow-sm">
                Magazine Lifestyle
            </span>
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tight mb-4 text-brand-black">
                Explorez par <span class="text-brand-orange">Thématique</span>
            </h1>
            <p class="text-gray-500 text-lg font-medium max-w-2xl mx-auto leading-relaxed">
                Sélectionnez un univers pour découvrir nos articles, guides et actualités exclusifs.
            </p>
        </div>
    </header>

    <main class="flex-grow py-20 px-6 bg-gray-50 relative">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-orange/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto max-w-7xl relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <?php foreach ($themes as $theme): ?>
                <a href="blog.php?category=<?= $theme['id'] ?>" class="group relative h-[400px] rounded-3xl overflow-hidden card-hover-effect bg-white border border-gray-100">
                    
                    <div class="absolute inset-0">
                        <img src="<?= $theme['image'] ?>"  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                    </div>


                    <div class="absolute top-8 right-8 w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-300">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full p-8 md:p-10 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        

                        <h2 class="text-3xl md:text-4xl font-black text-white uppercase mb-4 leading-none">
                            <?= $theme['name'] ?>
                        </h2>

                        <p class="text-gray-300 text-sm font-medium leading-relaxed max-w-md opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">
                            <?= $theme['description'] ?>
                        </p>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r <?= $theme['color'] ?> transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                </a>
                <?php endforeach; ?>

            </div>

            <div class="text-center mt-16">
                <a href="blog.php" class="inline-flex items-center gap-3 text-brand-black hover:text-brand-orange font-bold uppercase tracking-widest text-xs transition-colors group">
                    <span class="w-8 h-[1px] bg-brand-black group-hover:bg-brand-orange transition-colors"></span>
                    Voir tous les articles sans filtre
                    <span class="w-8 h-[1px] bg-brand-black group-hover:bg-brand-orange transition-colors"></span>
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-brand-black text-white py-12 border-t border-white/5">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-black uppercase mb-6 tracking-widest">Ma Bagnole</h2>
            <div class="flex justify-center gap-6 mb-8 text-gray-400">
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
            </div>
            <p class="text-gray-600 text-xs font-bold tracking-widest uppercase">© 2025 Ma Bagnole. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>