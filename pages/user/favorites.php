<?php
require_once '../../includes/guard.php';
require_login();
// Mock Data for Favorites
$favorites = [
    [
        'id' => 1,
        'model' => 'Mercedes-Benz Classe C',
        'category' => 'Berline',
        'price' => 120,
        'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png',
        'rating' => 5
    ],
    [
        'id' => 2,
        'model' => 'Range Rover Evoque',
        'category' => 'SUV',
        'price' => 180,
        'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png',
        'rating' => 4
    ]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris | MaBagnole</title>
    
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
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <?php 
    $root_path = '../../';
    include '../header.php'; 
    ?>

    <div class="pt-20 min-h-screen flex flex-col">
        
        <!-- Main Content -->
        <main class="flex-1 p-8 w-full">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-black mb-8">Mes Favoris</h1>

                <?php if(empty($favorites)): ?>
                    <div class="bg-white rounded-xl p-12 text-center border border-gray-100">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                            <i class="fa-solid fa-heart-crack text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Aucun favori</h3>
                        <p class="text-gray-500 mb-6">Vous n'avez pas encore ajouté de véhicules à vos favoris.</p>
                        <a href="../../index.php" class="inline-block bg-locar-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                            Explorer les véhicules
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach($favorites as $car): ?>
                        <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition group">
                            <div class="relative h-48 bg-gray-100">
                                <img src="<?= $car['image'] ?>" alt="<?= $car['model'] ?>" class="w-full h-full object-cover">
                                <button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center text-red-500 shadow-sm hover:bg-red-50 transition" title="Retirer des favoris">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="text-xs font-bold text-locar-orange uppercase tracking-wider"><?= $car['category'] ?></span>
                                        <h3 class="text-lg font-bold group-hover:text-locar-orange transition"><?= $car['model'] ?></h3>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-lg font-black"><?= $car['price'] ?>€</span>
                                        <span class="text-xs text-gray-400">/jour</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 text-yellow-400 text-xs mb-4">
                                    <?php for($i=0; $i<5; $i++): ?>
                                        <i class="fa-<?= $i < $car['rating'] ? 'solid' : 'regular' ?> fa-star"></i>
                                    <?php endfor; ?>
                                    <span class="text-gray-400 ml-1">(12 avis)</span>
                                </div>
                                <a href="../vehicle-details.php?id=<?= $car['id'] ?>" class="block w-full py-3 bg-gray-50 text-center font-bold text-sm rounded-lg hover:bg-locar-black hover:text-white transition">
                                    Réserver maintenant
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
