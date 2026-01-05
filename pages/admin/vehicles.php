<?php
session_start();
require_once "../../Classes/db.php";
require_once "../../Classes/vehicle.php";
require_once "../../Classes/Category.php";

$db = DB::connect();
$vehicleObj = new vehicle($db);
$categoryObj = new Category($db);

$edit_vehicle = null;
if (isset($_GET['edit'])) {
    $edit_vehicle = $vehicleObj->getVehicleById($_GET['edit']);
}

$data = $vehicleObj->getVehicles();
$vehicles_data = $data['vehicles'];
$categories_data = $categoryObj->getCategories();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Véhicules | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: { 
                        'locar-orange': '#FF3B00', 
                        'locar-black': '#1a1a1a',
                        'locar-dark': '#0f0f0f',
                        'locar-gray': '#f4f4f5'
                    },
                    boxShadow: {
                        'premium': '0 20px 40px -10px rgba(0,0,0,0.1)',
                        'card': '0 0 0 1px rgba(0,0,0,0.03), 0 2px 8px rgba(0,0,0,0.04)',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-locar-gray text-gray-800 antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50/50">
        <div class="container mx-auto px-8 py-10">
            <!-- Header -->
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-4xl font-extrabold text-locar-black tracking-tight mb-2">Flotte de Véhicules</h2>
                    <p class="text-gray-500 font-medium">Gérez votre inventaire et la disponibilité en temps réel.</p>
                </div>
                <button onclick="openModal('addModal')" class="bg-locar-black hover:bg-locar-orange text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center group">
                    <span class="bg-white/20 p-1 rounded-md mr-3 group-hover:rotate-90 transition-transform"><i class="fa-solid fa-plus text-sm"></i></span>
                    Ajouter un véhicule
                </button>
            </div>


            <!-- Vehicle Grid -->
            <?php if (empty($vehicles_data)): ?>
                <div class="bg-white rounded-2xl p-12 text-center shadow-card">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-car-side text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun véhicule trouvé</h3>
                    <p class="text-gray-500 mb-6">Commencez par ajouter des véhicules à votre flotte.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <?php foreach($vehicles_data as $v): ?>
                    <div class="group bg-white rounded-2xl shadow-card hover:shadow-premium transition-all duration-300 overflow-hidden relative border border-transparent hover:border-gray-100 flex flex-col h-full">
                        
                        <!-- Image Container -->
                        <div class="relative h-56 overflow-hidden bg-gray-100">
                            <img src="<?= $v['image'] ?>" alt="<?= $v['brand'] ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 right-4 z-10">
                                <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase shadow-sm tracking-wide backdrop-blur-md
                                    <?= $v['is_available'] ? 'bg-green-500/90 text-white' : 'bg-red-500/90 text-white' ?>">
                                    <?= $v['is_available'] ? 'Disponible' : 'Indisponible' ?>
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Action Buttons on Hover -->
                            <div class="absolute bottom-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <a href="?edit=<?= $v['vehicle_id'] ?>" class="bg-white text-blue-600 p-2.5 rounded-lg shadow-lg hover:bg-blue-50 transition" title="Éditer">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="actions/vehicle_action.php" method="POST" onsubmit="return confirm('Supprimer ce véhicule ?');">
                                    <input type="hidden" name="vehicle_id" value="<?= $v['vehicle_id'] ?>">
                                    <button type="submit" name="delete_vehicle" class="bg-white text-red-600 p-2.5 rounded-lg shadow-lg hover:bg-red-50 transition" title="Supprimer">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-xs font-bold text-locar-orange uppercase tracking-wider"><?= $v['category_name'] ?></p>
                                <p class="text-xs font-medium text-gray-400"><?= date('d M Y', strtotime($v['created_at'])) ?></p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex-1"><?= $v['brand'] ?> <span class="text-gray-500 font-semibold"><?= $v['model'] ?></span></h3>
                            
                            <div class="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center bg-gray-50/50 -mx-6 -mb-6 px-6 py-4">
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Prix journalier</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-black text-locar-black"><?= $v['price_per_day'] ?></span>
                                        <span class="text-sm font-bold text-gray-500">$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('addModal')"></div>
        <div class="bg-white w-full max-w-3xl rounded-3xl p-8 max-h-[90vh] overflow-y-auto relative shadow-2xl transform transition-all scale-100">
            
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-2xl text-gray-900">Ajouter des véhicules</h3>
                    <p class="text-gray-500 text-sm mt-1">Remplissez les informations pour un ou plusieurs véhicules.</p>
                </div>
                <button onclick="closeModal('addModal')" class="bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="actions/vehicle_action.php" class="space-y-6" method="POST">
                <!-- Single Entry for Add -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Marque</label>
                        <input type="text" name="brand[]" placeholder="Ex: Toyota" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Modèle</label>
                        <input type="text" name="model[]" placeholder="Ex: RAV4" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Catégorie</label>
                        <div class="relative">
                            <select name="category[]" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition appearance-none cursor-pointer" required>
                                <option value="">Sélectionner...</option>
                                <?php foreach($categories_data as $cat): ?>
                                    <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Prix par jour</label>
                        <div class="relative">
                            <input type="number" name="price[]" placeholder="0.00" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-bold">$</div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Image URL</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"><i class="fa-solid fa-link"></i></span>
                        <input type="url" name="image[]" placeholder="https://example.com/image.jpg" class="w-full p-4 pl-12 bg-white rounded-xl border border-gray-200 font-medium text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="add_vehicle" class="w-full bg-locar-black text-white font-bold py-4 rounded-xl hover:bg-locar-orange shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                        ENREGISTRER LE VÉHICULE
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($edit_vehicle): ?>
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="window.location.href='vehicles.php'"></div>
        <div class="bg-white w-full max-w-3xl rounded-3xl p-8 max-h-[90vh] overflow-y-auto relative shadow-2xl animate-fade-in-up">
            
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-2xl text-gray-900">Modifier Véhicule</h3>
                    <p class="text-gray-500 text-sm mt-1">Mise à jour des informations du véhicule.</p>
                </div>
                <a href="vehicles.php" class="bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </a>
            </div>

            <form action="actions/vehicle_action.php" class="space-y-6" method="POST">
                <input type="hidden" name="vehicle_id" value="<?= $edit_vehicle['vehicle_id'] ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Marque</label>
                        <input type="text" name="brand" value="<?= htmlspecialchars($edit_vehicle['brand']) ?>" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Modèle</label>
                        <input type="text" name="model" value="<?= htmlspecialchars($edit_vehicle['model']) ?>" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Catégorie</label>
                        <div class="relative">
                            <select name="category" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition appearance-none cursor-pointer" required>
                                <?php foreach($categories_data as $cat): ?>
                                    <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id'] == $edit_vehicle['category_id'] ? 'selected' : '' ?>>
                                        <?= $cat['category_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Prix par jour</label>
                        <div class="relative">
                            <input type="number" name="price" value="<?= htmlspecialchars($edit_vehicle['price_per_day']) ?>" class="w-full p-4 bg-white rounded-xl border border-gray-200 font-bold text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-bold">$</div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Image URL</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"><i class="fa-solid fa-link"></i></span>
                        <input type="url" name="image" value="<?= htmlspecialchars($edit_vehicle['image']) ?>" class="w-full p-4 pl-12 bg-white rounded-xl border border-gray-200 font-medium text-gray-700 outline-none focus:border-locar-orange focus:ring-2 focus:ring-locar-orange/10 transition" required>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <input type="checkbox" name="is_available" id="is_available" <?= $edit_vehicle['is_available'] ? 'checked' : '' ?> class="w-5 h-5 text-locar-orange rounded focus:ring-locar-orange border-gray-300">
                    <label for="is_available" class="font-bold text-gray-700 select-none cursor-pointer">Véhicule disponible</label>
                </div>

                <div class="pt-4">
                    <button type="submit" name="update_vehicle" class="w-full bg-locar-black text-white font-bold py-4 rounded-xl hover:bg-locar-orange shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                        METTRE À JOUR
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function openModal(id) { 
            document.getElementById(id).classList.remove('hidden'); 
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) { 
            document.getElementById(id).classList.add('hidden'); 
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>
