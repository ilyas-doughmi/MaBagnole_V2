<?php
require_once '../includes/guard.php';
require_once '../Classes/db.php';
require_once '../Classes/vehicle.php';

require_login();

$db = DB::connect();
$vehicleObj = new vehicle($db);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;

if ($page < 1) $page = 1;

if (!empty($search)) {
    $data = $vehicleObj->searchVehicles($search);
    $vehicles = $data['vehicles'];
} else {
    $vehicles = $vehicleObj->getVehiclesPaginated($page, $perPage);
}

$totalVehicles = $vehicleObj->getTotalVehicles();
$totalPages = ($totalVehicles / $perPage) + 1;
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre Flotte | MaBagnole Premium</title>
    
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
        .hero-pattern {
            background-image: radial-gradient(#FF3B00 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.1;
        }
    </style>
</head>
<body class="bg-gray-50 text-brand-black antialiased selection:bg-brand-orange selection:text-white">

    <!-- Navigation -->
    <?php $root_path = '../'; include 'header.php'; ?>

    <!-- Hero Section -->
    <header class="relative bg-brand-black text-white pt-40 pb-24 overflow-hidden">
        <div class="absolute inset-0 hero-pattern"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-orange/10 to-transparent"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 border border-brand-orange/50 rounded-full text-brand-orange text-xs font-bold tracking-widest uppercase mb-6 bg-brand-orange/5 backdrop-blur-sm">
                Collection 2025
            </span>
            <h1 class="text-5xl md:text-7xl font-black uppercase mb-6 tracking-tight leading-tight">
                Trouvez votre <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Route</span>
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto text-lg font-light leading-relaxed">
                Une sélection exclusive de véhicules pour transformer chaque déplacement en expérience inoubliable.
            </p>
        </div>
    </header>

    <!-- Filter Bar -->
    <div class="bg-white border-b border-gray-100 sticky top-0 z-40 backdrop-blur-md bg-white/80">
        <div class="container mx-auto px-6 py-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <form action="vehicles.php" method="GET" class="w-full md:w-auto">
                    <div class="relative">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                               placeholder="Rechercher par marque, modèle..." 
                               class="w-full md:w-80 pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-full text-sm font-medium outline-none focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 transition">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <?php if (!empty($search)): ?>
                            <a href="vehicles.php" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-orange">
                                <i class="fa-solid fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
                <div id="filterButtons" class="flex gap-2 overflow-x-auto no-scrollbar">
                    <button data-category="all" class="filter-btn active bg-brand-black text-white px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap">Tous</button>
                    <button data-category="SUV" class="filter-btn bg-gray-100 text-gray-500 hover:bg-gray-200 px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap">SUV</button>
                    <button data-category="Sedan" class="filter-btn bg-gray-100 text-gray-500 hover:bg-gray-200 px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap">Berlines</button>
                    <button data-category="Luxury" class="filter-btn bg-gray-100 text-gray-500 hover:bg-gray-200 px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap">Luxe</button>
                    <button data-category="Economy" class="filter-btn bg-gray-100 text-gray-500 hover:bg-gray-200 px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap">Économique</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Grid -->
    <section class="py-20 min-h-screen bg-gray-50">
        <div class="container mx-auto px-6">
            
            <?php if (empty($vehicles)): ?>
                <div class="flex flex-col items-center justify-center py-32 text-center opacity-50">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-6">
                        <i class="fa-solid fa-car text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun véhicule disponible</h3>
                    <p class="text-gray-500">Notre flotte est actuellement en cours de mise à jour.</p>
                </div>
            <?php else: ?>
                <div id="vehicleGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <?php foreach ($vehicles as $vehicle): ?>
                        <div class="vehicle-card group relative bg-white rounded-3xl overflow-hidden cursor-pointer hover:shadow-2xl transition-all duration-500 ease-out flex flex-col h-full border border-gray-100" data-category="<?= htmlspecialchars($vehicle['category_name']) ?>">
                            
                            <!-- Image Container -->
                            <div class="relative h-64 overflow-hidden bg-gray-100/50">
                                <div class="absolute top-4 left-4 z-20">
                                    <span class="bg-brand-black/90 backdrop-blur text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                                        <?= htmlspecialchars($vehicle['category_name']) ?>
                                    </span>
                                </div>
                                
                                <img src="<?= htmlspecialchars($vehicle['image']) ?>" 
                                     alt="<?= htmlspecialchars($vehicle['brand']) ?>" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                
                                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-8 flex-1 flex flex-col relative">
                                <div class="mb-6">
                                    <div class="flex justify-between items-end mb-2">
                                        <h3 class="text-2xl font-black text-brand-black uppercase tracking-tight group-hover:text-brand-orange transition-colors">
                                            <?= htmlspecialchars($vehicle['brand']) ?>
                                        </h3>
                                        <div class="text-right">
                                            <span class="text-sm font-bold text-gray-400 line-through decoration-brand-orange/50"><?= number_format($vehicle['price_per_day'] * 1.2, 0) ?>$</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-500 font-medium"><?= htmlspecialchars($vehicle['model']) ?></p>
                                        <p class="text-3xl font-black text-brand-black">
                                            <?= htmlspecialchars($vehicle['price_per_day']) ?><span class="text-base align-top text-brand-orange">$</span><span class="text-xs text-gray-400 font-bold ml-1">/Jour</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Specs (Mock) -->
                                <div class="flex justify-between items-center mb-8 p-4 bg-gray-50 rounded-2xl border border-gray-100 group-hover:border-brand-orange/10 transition-colors">
                                    <div class="flex flex-col items-center gap-1.5 flex-1 border-r border-gray-200/50 last:border-0">
                                        <i class="fa-solid fa-gauge-high text-gray-400 group-hover:text-brand-orange transition-colors"></i>
                                        <span class="text-[10px] uppercase font-bold text-gray-600">Auto</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 flex-1 border-r border-gray-200/50 last:border-0">
                                        <i class="fa-solid fa-droplet text-gray-400 group-hover:text-brand-orange transition-colors"></i>
                                        <span class="text-[10px] uppercase font-bold text-gray-600">Diesel</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 flex-1">
                                        <i class="fa-solid fa-user text-gray-400 group-hover:text-brand-orange transition-colors"></i>
                                        <span class="text-[10px] uppercase font-bold text-gray-600">5 Places</span>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <a href="vehicle-details.php?id=<?= $vehicle['vehicle_id'] ?>" 
                                       class="block w-full bg-brand-black text-white font-bold py-4 rounded-xl text-center shadow-lg transform group-hover:translate-y-[-2px] group-hover:shadow-xl group-hover:bg-brand-orange transition-all duration-300">
                                        Réserver ce véhicule
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (empty($search) && $totalPages > 1): ?>
            <div class="flex justify-center items-center gap-2 mt-12">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-white border border-gray-200 rounded-lg font-bold hover:bg-brand-orange hover:text-white hover:border-brand-orange transition">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="px-4 py-2 rounded-lg font-bold transition <?= $i == $page ? 'bg-brand-black text-white' : 'bg-white border border-gray-200 hover:bg-gray-100' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-white border border-gray-200 rounded-lg font-bold hover:bg-brand-orange hover:text-white hover:border-brand-orange transition">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-brand-black text-white py-12 border-t border-white/5">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-black uppercase mb-6 tracking-widest">Ma Bagnole</h2>
            <div class="flex justify-center gap-6 mb-8 text-gray-400">
                <a href="#" class="hover:text-brand-orange transition"><i class="fa-brands fa-instagram text-xl"></i></a>
                <a href="#" class="hover:text-brand-orange transition"><i class="fa-brands fa-twitter text-xl"></i></a>
                <a href="#" class="hover:text-brand-orange transition"><i class="fa-brands fa-facebook text-xl"></i></a>
            </div>
            <p class="text-gray-600 text-xs font-bold tracking-widest uppercase">© 2025 Ma Bagnole Premium. Tous droits réservés.</p>
        </div>
    </footer>
<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const category = this.dataset.category;
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active', 'bg-brand-black', 'text-white');
            b.classList.add('bg-gray-100', 'text-gray-500');
        });
        this.classList.add('active', 'bg-brand-black', 'text-white');
        this.classList.remove('bg-gray-100', 'text-gray-500');
        document.querySelectorAll('.vehicle-card').forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>
