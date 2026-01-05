<?php
require_once '../includes/guard.php';
require_once '../Classes/db.php';
require_once '../Classes/vehicle.php';
require_once '../Classes/Review.php';

require_login();

$db = DB::connect();
$vehicleObj = new vehicle($db);
$reviewObj = new Review($db);

$vehicle_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$vehicle = $vehicleObj->getVehicleById($vehicle_id);

if (!$vehicle) {
    header('Location: vehicles.php');
    exit;
}

$reviews = $reviewObj->getReviewsByVehicleId($vehicle_id);
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']) ?> | MaBagnole Premium</title>
    
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
            opacity: 0.05;
        }
    </style>
</head>
<body class="bg-gray-50 text-brand-black antialiased selection:bg-brand-orange selection:text-white">

    <!-- Navigation -->
    <?php $root_path = '../'; include 'header.php'; ?>

    <!-- Main Content -->
    <div class="pt-32 pb-20 min-h-screen">
        <div class="container mx-auto px-6">
            
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm font-medium text-gray-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="vehicles.php" class="inline-flex items-center hover:text-brand-orange transition">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Retour à la flotte
                        </a>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Left Column: Images & Details -->
                <div class="lg:w-2/3">
                    <!-- Title Section Mobile -->
                    <div class="lg:hidden mb-6">
                        <span class="text-brand-orange font-bold tracking-widest uppercase text-xs mb-2 block"><?= htmlspecialchars($vehicle['category_name']) ?></span>
                        <h1 class="text-3xl font-black uppercase"><?= htmlspecialchars($vehicle['brand']) ?> <span class="text-gray-500 font-medium"><?= htmlspecialchars($vehicle['model']) ?></span></h1>
                    </div>

                    <!-- Main Image -->
                    <div class="bg-white rounded-3xl p-2 shadow-xl shadow-brand-black/5 mb-10 overflow-hidden border border-gray-100 relative group">
                        <div class="relative rounded-2xl overflow-hidden aspect-video bg-gray-100 flex items-center justify-center">
                            <div class="absolute top-4 left-4 z-20">
                                <span class="bg-brand-black text-white text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wider shadow-lg">
                                    <?= htmlspecialchars($vehicle['category_name']) ?>
                                </span>
                            </div>
                            <!-- Availability Badge -->
                            <div class="absolute top-4 right-4 z-20">
                                <?php if ($vehicle['is_available']): ?>
                                    <span class="bg-green-500/90 backdrop-blur text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1"><i class="fa-solid fa-check"></i> Disponible</span>
                                <?php else: ?>
                                    <span class="bg-red-500/90 backdrop-blur text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1"><i class="fa-solid fa-times"></i> Indisponible</span>
                                <?php endif; ?>
                            </div>

                            <img src="<?= htmlspecialchars($vehicle['image']) ?>" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-in-out" 
                                 alt="<?= htmlspecialchars($vehicle['brand']) ?>">
                        </div>
                    </div>

                    <!-- Specs Grid (Static for now) -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:border-brand-orange/20 transition-colors">
                            <div class="w-12 h-12 rounded-full bg-brand-orange/5 flex items-center justify-center text-brand-orange text-xl">
                                <i class="fa-solid fa-gas-pump"></i>
                            </div>
                            <div class="text-center">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Carburant</p>
                                <p class="font-bold text-brand-black">Essence</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:border-brand-orange/20 transition-colors">
                            <div class="w-12 h-12 rounded-full bg-brand-orange/5 flex items-center justify-center text-brand-orange text-xl">
                                <i class="fa-solid fa-gears"></i>
                            </div>
                            <div class="text-center">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Boite</p>
                                <p class="font-bold text-brand-black">Auto</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:border-brand-orange/20 transition-colors">
                            <div class="w-12 h-12 rounded-full bg-brand-orange/5 flex items-center justify-center text-brand-orange text-xl">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="text-center">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Passagers</p>
                                <p class="font-bold text-brand-black">5 Places</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:border-brand-orange/20 transition-colors">
                            <div class="w-12 h-12 rounded-full bg-brand-orange/5 flex items-center justify-center text-brand-orange text-xl">
                                <i class="fa-solid fa-suitcase"></i>
                            </div>
                            <div class="text-center">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Valises</p>
                                <p class="font-bold text-brand-black">3 Max</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-lg max-w-none text-gray-500 mb-16">
                        <h3 class="text-2xl font-black text-brand-black uppercase mb-6 tracking-tight">À propos du véhicule</h3>
                        <p>
                            Découvrez le plaisir de conduire avec notre <?= htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']) ?>. 
                            Alliant confort exceptionnel et design élégant, ce véhicule de la catégorie <?= htmlspecialchars($vehicle['category_name']) ?> 
                            est le compagnon idéal pour vos déplacements professionnels ou vos escapades le week-end. 
                            Entretenu méticuleusement par nos experts MaBagnole, il vous garantit sécurité et sérénité sur la route.
                        </p>
                    </div>

                    <!-- Reviews Section -->
                    <div class="border-t border-gray-200 pt-12">
                        <h3 class="text-2xl font-black text-brand-black uppercase mb-6">Avis Clients</h3>

                        <!-- Add Review Form -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-8">
                            <h4 class="font-bold text-brand-black mb-4">Laisser un avis</h4>
                            <form action="submit_review.php" method="POST" class="space-y-4">
                                <input type="hidden" name="vehicle_id" value="<?= $vehicle['vehicle_id'] ?>">
                                <div class="flex items-center gap-4">
                                    <label class="text-sm font-bold text-gray-400">Note:</label>
                                    <select name="rating" required class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 font-bold outline-none focus:border-brand-orange">
                                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                                        <option value="4">⭐⭐⭐⭐ (4)</option>
                                        <option value="3">⭐⭐⭐ (3)</option>
                                        <option value="2">⭐⭐ (2)</option>
                                        <option value="1">⭐ (1)</option>
                                    </select>
                                </div>
                                <div>
                                    <textarea name="comment" rows="3" placeholder="Partagez votre expérience..." required
                                        class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:border-brand-orange text-sm"></textarea>
                                </div>
                                <button type="submit" class="bg-brand-black text-white font-bold px-6 py-3 rounded-xl hover:bg-brand-orange transition">
                                    <i class="fa-solid fa-paper-plane mr-2"></i> Envoyer
                                </button>
                            </form>
                        </div>

                        <!-- Reviews List -->
                        <div class="grid gap-6">
                            <?php if (empty($reviews)): ?>
                                <p class="text-gray-400 italic">Aucun avis pour ce véhicule. Soyez le premier à laisser un avis !</p>
                            <?php else: ?>
                                <?php foreach($reviews as $review): ?>
                                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-10 h-10 bg-brand-black text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            <?= strtoupper(substr($review['full_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-brand-black"><?= htmlspecialchars($review['full_name']) ?></h5>
                                            <div class="flex text-xs text-brand-orange">
                                                <?php for($i=0; $i<$review['rating']; $i++) 
                                                echo '<i class="fa-solid fa-star"></i>'; ?>
                                            </div>
                                        </div>
                                        <span class="ml-auto text-xs font-bold text-gray-300 uppercase"><?= date('d M Y', strtotime($review['review_date'])) ?></span>
                                    </div>
                                    <p class="text-gray-600 text-sm leading-relaxed"><?= htmlspecialchars($review['comment']) ?></p>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Reservation Form -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-3xl shadow-2xl shadow-brand-black/10 p-8 sticky top-24 border border-gray-100">
                        <div class="mb-8 border-b border-gray-100 pb-8">
                            <span class="text-brand-orange font-bold tracking-widest uppercase text-xs mb-1 block"><?= htmlspecialchars($vehicle['category_name']) ?></span>
                            <h2 class="text-3xl font-black uppercase mb-4 leading-none"><?= htmlspecialchars($vehicle['brand']) ?> <span class="text-gray-400"><?= htmlspecialchars($vehicle['model']) ?></span></h2>
                            
                            <div class="flex items-baseline gap-1">
                                <span class="text-5xl font-black text-brand-black"><?= htmlspecialchars($vehicle['price_per_day']) ?></span>
                                <span class="text-3xl font-bold text-brand-orange">$</span>
                                <span class="text-gray-400 font-bold ml-1">/ jour</span>
                            </div>
                        </div>

                        <form action="submit_reservation.php" method="POST" class="space-y-6">
                            <?php if (isset($_GET['error'])): ?>
                                <?php if ($_GET['error'] === 'unavailable'): ?>
                                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        Ce véhicule n'est pas disponible pour ces dates.
                                    </div>
                                <?php elseif ($_GET['error'] === 'past_date'): ?>
                                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                                        <i class="fa-solid fa-calendar-xmark"></i>
                                        Vous ne pouvez pas réserver dans le passé.
                                    </div>
                                <?php elseif ($_GET['error'] === 'invalid_dates'): ?>
                                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        La date de retour doit être après la date de départ.
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <input type="hidden" name="vehicle_id" value="<?= $vehicle['vehicle_id'] ?>">
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide">Dates de location</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 focus-within:border-brand-orange focus-within:ring-1 focus-within:ring-brand-orange transition-all">
                                            <span class="block text-[10px] text-gray-400 uppercase font-bold mb-1">Départ</span>
                                            <input type="date" name="date_debut" required min="<?= date('Y-m-d') ?>" class="w-full bg-transparent font-bold text-sm outline-none text-brand-black">
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 focus-within:border-brand-orange focus-within:ring-1 focus-within:ring-brand-orange transition-all">
                                            <span class="block text-[10px] text-gray-400 uppercase font-bold mb-1">Retour</span>
                                            <input type="date" name="date_fin" required min="<?= date('Y-m-d') ?>" class="w-full bg-transparent font-bold text-sm outline-none text-brand-black">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide">Options</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                                            <input type="checkbox" name="options[]" value="gps" class="w-4 h-4 text-brand-orange rounded focus:ring-brand-orange border-gray-300">
                                            <span class="font-bold text-sm text-gray-600 flex-1">GPS Navigation</span>
                                            <span class="text-xs font-bold text-brand-black">+10$</span>
                                        </label>
                                        <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                                            <input type="checkbox" name="options[]" value="siege" class="w-4 h-4 text-brand-orange rounded focus:ring-brand-orange border-gray-300">
                                            <span class="font-bold text-sm text-gray-600 flex-1">Siège Enfant</span>
                                            <span class="text-xs font-bold text-brand-black">+5$</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-brand-black text-white font-black py-5 rounded-xl text-lg hover:bg-brand-orange shadow-xl shadow-brand-orange/20 transition-all duration-300 transform hover:-translate-y-1 block mt-8">
                                RÉSERVER
                            </button>
                            
                            <p class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-4 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-lock"></i> Paiement sécurisé
                            </p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="bg-brand-black text-white py-12 border-t border-white/5">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-black uppercase mb-6 tracking-widest">Ma Bagnole</h2>
            <p class="text-gray-600 text-xs font-bold tracking-widest uppercase">© 2025 Ma Bagnole Premium. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
