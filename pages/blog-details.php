<?php
require_once '../includes/guard.php';
// Mock fetch single post based on ID
$post_id = $_GET['id'] ?? 1;

// Mock Data (Usually fetched from DB)
$post = [
    'title' => 'Top 5 des routes panoramiques au Maroc',
    'category' => 'Voyage',
    'image' => 'https://i.pinimg.com/736x/1d/d2/01/1dd201f98cc57d8f209bf48f5e817885.jpg',
    'content' => '
        <p>Le Maroc regorge de paysages diversifiés, des montagnes enneigées de l\'Atlas aux dunes dorées du Sahara, en passant par les côtes sauvages de l\'Atlantique. Pour les amateurs de conduite, c\'est un véritable paradis. Voici notre sélection des routes les plus spectaculaires à parcourir avec votre véhicule de location MaBagnole.</p>
        
        <h3>1. Le Col du Tizi n\'Tichka</h3>
        <p>Reliant Marrakech à Ouarzazate, cette route de montagne est sans doute la plus célèbre du pays. Elle serpente à travers le Haut Atlas, offrant des virages en épingle exaltants et des panoramas à couper le souffle. Au sommet, à 2 260 mètres d\'altitude, la vue est imprenable.</p>
        
        <h3>2. La Route Côtière d\'Essaouira à Agadir</h3>
        <p>Pour ceux qui préfèrent l\'océan, la route N1 longe la côte atlantique, traversant des forêts d\'arganiers et des villages de pêcheurs authentiques. C\'est l\'itinéraire idéal pour une décapotable ou un SUV confortable.</p>
        
        <blockquote>"La route n\'est pas qu\'un moyen de transport, c\'est une destination en soi."</blockquote>
        
        <h3>Conseils de conduite</h3>
        <p>Avant de partir, assurez-vous de vérifier l\'état de votre véhicule. Nos agences à Marrakech et Casablanca proposent des véhicules parfaitement entretenus pour ces longs trajets. N\'oubliez pas de l\'eau et votre appareil photo !</p>
    ',
    'date' => '2025-06-15',
    'author' => 'Amine T.',
    'tags' => ['Roadtrip', 'Atlas', 'Nature', '4x4']
];
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> | Blog MaBagnole</title>
    
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
                    },
                    typography: {
                        DEFAULT: {
                            css: {
                                color: '#333',
                                h3: {
                                    color: '#0a0a0a',
                                    fontWeight: '800',
                                    textTransform: 'uppercase',
                                    marginTop: '2em',
                                },
                                blockquote: {
                                    borderLeftColor: '#FF3B00',
                                    fontStyle: 'italic',
                                    fontWeight: '600',
                                    color: '#1a1a1a',
                                    backgroundColor: '#FFF5F0',
                                    padding: '1.5rem',
                                    borderRadius: '0 1rem 1rem 0',
                                }
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom typography simulation since we might not have tailwind typography plugin */
        .prose p { margin-bottom: 1.5rem; line-height: 1.8; }
        .prose h3 { font-size: 1.5rem; font-weight: 800; color: #0a0a0a; margin-top: 2.5rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: -0.02em; }
        .prose blockquote { border-left: 4px solid #FF3B00; padding-left: 1.5rem; font-style: italic; color: #555; margin: 2rem 0; }
    </style>
</head>
<body class="bg-white text-brand-black antialiased selection:bg-brand-orange selection:text-white">

    <?php $root_path = '../'; include 'header.php'; ?>

    <div class="fixed top-20 left-0 h-1 bg-brand-orange z-50 transition-all duration-300" id="progressBar" style="width: 0%"></div>

    <article>
        <header class="pt-32 pb-12 px-6 bg-gray-50 border-b border-gray-100">
            <div class="container mx-auto max-w-4xl text-center">
                <div class="flex items-center justify-center gap-2 mb-6">
                    <span class="bg-brand-orange text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        <?= $post['category'] ?>
                    </span>
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">
                        <?= date('d F Y', strtotime($post['date'])) ?>
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black uppercase mb-8 leading-tight text-brand-black">
                    <?= $post['title'] ?>
                </h1>

                <div class="flex items-center justify-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-xl font-black text-gray-400">
                        <?= substr($post['author'], 0, 1) ?>
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Écrit par</p>
                        <p class="font-bold text-brand-black"><?= $post['author'] ?></p>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto max-w-5xl px-6 -mt-8">
            <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl shadow-brand-black/10">
                <img src="<?= $post['image'] ?>" class="w-full h-full object-cover">
            </div>
        </div>

        <div class="container mx-auto max-w-3xl px-6 py-16">
            <div class="prose prose-lg text-gray-600 mx-auto">
                <?= $post['content'] ?>
            </div>

            <div class="mt-16 pt-8 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Thèmes associés</p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach($post['tags'] as $tag): ?>
                        <a href="blog.php?tag=<?= $tag ?>" class="px-4 py-2 bg-gray-50 hover:bg-brand-black hover:text-white rounded-lg text-xs font-bold transition text-gray-600">#<?= $tag ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-16 bg-brand-black rounded-3xl p-8 md:p-12 text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-brand-orange/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-black text-white uppercase mb-4">Envie de prendre la route ?</h3>
                    <p class="text-gray-400 mb-8 max-w-lg mx-auto">Réservez le véhicule idéal pour votre prochaine aventure dès aujourd'hui.</p>
                    <a href="vehicles.php" class="inline-block bg-white text-brand-black font-bold py-4 px-8 rounded-xl hover:bg-brand-orange hover:text-white transition shadow-lg">
                        Voir les véhicules disponibles
                    </a>
                </div>
            </div>
        </div>
    </article>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="container mx-auto px-6 text-center">
            <a href="blog.php" class="text-xs font-black text-gray-400 uppercase tracking-widest hover:text-brand-orange transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Retour au blog
            </a>
        </div>
    </footer>

    <script>
        // Reading Progress Bar
        window.onscroll = function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        };
    </script>
</body>
</html>