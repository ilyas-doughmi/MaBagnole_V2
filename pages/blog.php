<?php
session_start();
require_once "../Classes/db.php";
require_once "../Classes/Article.php";
require_once "../Classes/Theme.php";


require_once "../includes/guard.php";

require_login();

$db = DB::connect();
if(isset($_GET["category"])){
    $articleObj = new Article($db);
    $articleObj->__set("themeId",$_GET["category"]);
}
else if(isset($_GET["tag"])){
    echo "tag";
}
else{
    header("location: theme.php?msg=choose_theme_first");
    exit();
}
$posts = $articleObj->getArticlesPerTheme();

?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog & Actualités | MaBagnole</title>
    
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
                        'locar-orange': '#FF5F00', // Matches index.php
                        'locar-black': '#1a1a1a',
                        'locar-dark': '#0F0F0F',
                    },
                    boxShadow: {
                        'neon': '0 0 20px rgba(255, 95, 0, 0.4)',
                        'card': '0 10px 30px -5px rgba(0, 0, 0, 0.1)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar from index.php */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; }
        ::-webkit-scrollbar-thumb { background: #FF5F00; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-locar-orange selection:text-white">

    <?php $root_path = '../'; include 'header.php'; ?>

    <header class="relative bg-locar-dark text-white pt-32 pb-20 overflow-hidden">
        <div class="absolute top-0 right-0 w-2/3 h-full bg-gradient-to-l from-[#252525] to-transparent z-0"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-locar-orange rounded-full blur-[150px] opacity-20"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center md:text-left">
            <span class="inline-block py-1 px-3 border border-locar-orange/50 rounded text-locar-orange text-xs font-bold tracking-[0.2em] uppercase mb-4 bg-locar-orange/10">
                Magazine
            </span>
            <h1 class="text-4xl md:text-6xl font-black uppercase leading-tight mb-6">
                Actualités <span class="text-transparent bg-clip-text bg-gradient-to-r from-locar-orange to-red-500">& Conseils</span>
            </h1>
            <p class="text-gray-400 text-lg font-medium max-w-xl leading-relaxed">
                Tout ce que vous devez savoir sur la location de voiture, l'entretien mécanique et les meilleures destinations de voyage.
            </p>
        </div>
    </header>

    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <div class="lg:w-3/4">
                    
                    <?php if (empty($posts)): ?>
                        <div class="text-center py-20">
                            <i class="fa-solid fa-file-circle-xmark text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-800">No article found</h3>
                            <p class="text-gray-500 mt-2">Nous n'avons trouvé aucun article dans cette catégorie pour le moment.</p>
                        </div>
                    <?php else: ?>

                    <div class="group relative rounded-2xl overflow-hidden shadow-2xl mb-12 h-[400px] md:h-[500px]">
                        <img src="<?= $posts[0]['media'] ?>" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 md:p-12">
                            <span class="bg-locar-orange text-white text-xs font-bold px-3 py-1 rounded uppercase mb-3 inline-block">
                                Article
                            </span>
                            <h2 class="text-3xl md:text-4xl font-black text-white uppercase mb-4 leading-tight group-hover:text-locar-orange transition">
                                <?= $posts[0]['name'] ?>
                            </h2>
                            <div class="flex items-center text-gray-300 text-sm font-bold gap-4">
                                <span><i class="fa-solid fa-user mr-2 text-locar-orange"></i> Admin</span>
                                <span><i class="fa-solid fa-calendar mr-2 text-locar-orange"></i> <?= $posts[0]['createdAt'] ?></span>
                            </div>
                        </div>
                        <a href="#" class="absolute inset-0 z-20"></a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php foreach($posts as $post): ?>
                        <article class="bg-white rounded-2xl overflow-hidden shadow-card border border-gray-100 hover:shadow-neon hover:border-locar-orange/30 transition duration-300 group flex flex-col h-full">
                            <div class="relative h-56 overflow-hidden">
                                <span class="absolute top-4 left-4 z-10 bg-black/80 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded uppercase tracking-wider">
                                    Article
                                </span>
                                <img src="<?= $post['media'] ?>" alt="<?= $post['name'] ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            </div>
                            
                            <div class="p-8 flex-1 flex flex-col">
                                <div class="flex items-center text-xs font-bold text-gray-400 mb-3 gap-2">
                                    <span class="text-locar-orange"><?= $post['createdAt'] ?></span>
                                    <span>•</span>
                                    <span><?= $post["full_name"] ?></span>
                                </div>
                                <h3 class="text-xl font-black text-gray-800 uppercase mb-3 leading-snug group-hover:text-locar-orange transition">
                                    <?= $post['name'] ?>
                                </h3>
                                <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                                    <?= $post['description'] ?>
                                </p>
                                <div class="mt-auto">
                                    <a href="blog-details.php?article=<?= $post["artid"] ?>" class="inline-flex items-center text-sm font-black text-locar-black hover:text-locar-orange transition uppercase tracking-wide">
                                        Lire l'article <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-16 flex justify-center gap-2">
                        <button class="w-10 h-10 rounded bg-locar-black text-white flex items-center justify-center font-bold hover:bg-locar-orange transition">1</button>
                        <button class="w-10 h-10 rounded bg-white border border-gray-200 text-gray-500 flex items-center justify-center font-bold hover:border-locar-orange hover:text-locar-orange transition">2</button>
                        <button class="w-10 h-10 rounded bg-white border border-gray-200 text-gray-500 flex items-center justify-center font-bold hover:border-locar-orange hover:text-locar-orange transition"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                    <?php endif; ?>
                </div>

                <aside class="lg:w-1/4 space-y-8">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="font-black text-lg uppercase mb-4">Contribution</h4>
                        <p class="text-xs text-gray-500 mb-4 font-bold">Partagez votre passion avec la communauté.</p>
                        <a href="user/add-article.php" class="flex items-center justify-center w-full bg-locar-black text-white font-bold py-3 rounded hover:bg-locar-orange transition uppercase text-xs tracking-wider">
                            <i class="fa-solid fa-plus mr-2"></i> Proposer un article
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="font-black text-lg uppercase mb-4">Recherche</h4>
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="w-full p-3 bg-gray-50 rounded-lg border-none font-bold text-sm focus:ring-2 focus:ring-locar-orange outline-none">
                            <button class="absolute right-3 top-3 text-gray-400 hover:text-locar-orange"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="font-black text-lg uppercase mb-4">Thémes</h4>
                        <ul class="space-y-2">
                            <?php
                            $categoriesObj = new Theme($db);
                            $categories = $categoriesObj->getThemes();
                            
                            foreach($categories as $cat): 
                            $articleObj->__set("themeId",$cat["id"]);
                            $count = count($articleObj->getArticlesPerTheme());
                            ?>
                            <li>
                                <a href="blog.php?category=<?= $cat["id"] ?>" class="flex justify-between items-center text-gray-500 font-bold text-sm hover:text-locar-orange hover:bg-orange-50 p-2 rounded transition group">
                                    <span><?= $cat["name"] ?></span>
                                    <span class="bg-gray-100 text-gray-400 text-xs px-2 py-1 rounded group-hover:bg-locar-orange group-hover:text-white transition"><?= $count ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="bg-locar-orange text-white p-8 rounded-2xl text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                        <div class="relative z-10">
                            <i class="fa-regular fa-paper-plane text-4xl mb-4"></i>
                            <h4 class="font-black text-xl uppercase mb-2">Newsletter</h4>
                            <p class="text-sm opacity-90 mb-6">Recevez nos meilleures offres et conseils directement.</p>
                            <input type="email" placeholder="Votre Email" class="w-full p-3 rounded bg-white/20 border border-white/30 placeholder-white/70 text-white font-bold mb-3 focus:outline-none focus:bg-white/30">
                            <button class="w-full bg-black hover:bg-gray-900 py-3 rounded font-bold shadow-lg transition">S'ABONNER</button>
                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </section>

    <footer class="bg-locar-dark text-white py-10 border-t border-gray-800">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <p class="font-bold tracking-wider text-sm">© 2025 MA BAGNOLE. TOUS DROITS RÉSERVÉS</p>
                <p class="text-xs text-gray-500 mt-1 font-bold">CRÉÉ AVEC PASSION</p>
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
            </div>
        </div>
    </footer>

</body>
</html>