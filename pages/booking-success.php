<?php
require_once '../includes/guard.php';
require_login();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation Confirmée | MaBagnole</title>
    
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
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- Navigation -->
    <?php $root_path = '../'; include 'header.php'; ?>

    <!-- Content -->
    <div class="flex-grow flex items-center justify-center pt-20 px-4">
        <div class="max-w-lg w-full bg-white rounded-3xl shadow-2xl overflow-hidden text-center relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-locar-orange"></div>
            
            <div class="p-10 md:p-12">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 ">
                    <i class="fa-solid fa-check text-4xl text-green-500"></i>
                </div>

                <h1 class="text-3xl font-black uppercase mb-4 text-gray-900">Réservation Confirmée !</h1>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    Merci pour votre réservation. Votre demande a été enregistrée avec succès. Vous recevrez bientôt un email de confirmation avec tous les détails.
                </p>

                <div class="space-y-3">
                    <a href="../index.php" class="block w-full bg-black hover:bg-locar-orange text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                        RETOUR À L'ACCUEIL
                    </a>
                    <a href="vehicles.php" class="block w-full bg-white border-2 border-gray-100 hover:border-black text-gray-900 font-bold py-4 rounded-xl transition">
                        RÉSERVER UN AUTRE VÉHICULE
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-8 text-center text-gray-400 text-xs font-bold">
        <p>© 2025 MA BAGNOLE. TOUS DROITS RÉSERVÉS</p>
    </footer>

</body>
</html>
