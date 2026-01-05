<?php
header('Content-Type: application/json');


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 6;
$offset = ($page - 1) * $limit;
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

$mock_vehicles = [
    ['id' => 1, 'marque' => 'Volvo', 'modele' => 'V60', 'categorie' => 'Confort', 'prix_jour' => 75, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Diesel', 'boite' => 'Auto', 'passagers' => 5],
    ['id' => 2, 'marque' => 'Mercedes', 'modele' => 'C-Class', 'categorie' => 'Luxe', 'prix_jour' => 120, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Essence', 'boite' => 'Auto', 'passagers' => 5],
    ['id' => 3, 'marque' => 'BMW', 'modele' => 'X5', 'categorie' => 'SUV', 'prix_jour' => 150, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Diesel', 'boite' => 'Auto', 'passagers' => 7],
    ['id' => 4, 'marque' => 'Audi', 'modele' => 'A3', 'categorie' => 'Citadine', 'prix_jour' => 50, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Essence', 'boite' => 'Manuelle', 'passagers' => 5],
    ['id' => 5, 'marque' => 'Range Rover', 'modele' => 'Evoque', 'categorie' => 'SUV', 'prix_jour' => 130, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Diesel', 'boite' => 'Auto', 'passagers' => 5],
    ['id' => 6, 'marque' => 'Peugeot', 'modele' => '208', 'categorie' => 'Citadine', 'prix_jour' => 40, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Essence', 'boite' => 'Manuelle', 'passagers' => 5],
    ['id' => 7, 'marque' => 'Volkswagen', 'modele' => 'Golf 8', 'categorie' => 'Confort', 'prix_jour' => 60, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Diesel', 'boite' => 'Auto', 'passagers' => 5],
    ['id' => 8, 'marque' => 'Toyota', 'modele' => 'RAV4', 'categorie' => 'SUV', 'prix_jour' => 90, 'image' => 'https://raw.githubusercontent.com/AChaoub/Fil_rouge_2020/master/Public/IMG/Img_voiture/Lexus.png', 'carburant' => 'Hybride', 'boite' => 'Auto', 'passagers' => 5],
];

// Filter Data
$filtered_vehicles = array_filter($mock_vehicles, function($v) use ($category, $search) {
    $match_category = ($category === 'all') || (strtolower($v['categorie']) === strtolower($category));
    $match_search = ($search === '') || (strpos(strtolower($v['marque'] . ' ' . $v['modele']), $search) !== false);
    return $match_category && $match_search;
});

// Pagination Logic
$total_items = count($filtered_vehicles);
$total_pages = ceil($total_items / $limit);
$paginated_vehicles = array_slice($filtered_vehicles, $offset, $limit);

echo json_encode([
    'vehicles' => array_values($paginated_vehicles),
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_items' => $total_items
    ]
]);
?>