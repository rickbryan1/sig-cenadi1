<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Portail d'Authentification Sécurisé</title>
    <!-- Icône du logo -->
    <link rel="icon" type="image/jpeg" href="{{ asset('logo-cenadi.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Geist', 'sans-serif'] },
                    colors: {
                        corporate: { 600: '#16a34a', 700: '#15803d' },
                        surface: { 50: '#f8fafc', 100: '#f1f5f9' }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-image: url('{{ asset('logo-cenadi.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="h-full bg-black/40 font-sans text-black font-semibold flex items-center justify-center p-4">

    <!-- Conteneur centré et compact -->
    <div class="w-full max-w-md bg-white/95 rounded-xl shadow-xl border border-slate-300 overflow-hidden">
        
        <!-- En-tête Institutionnel -->
        <div class="bg-slate-900 text-white p-6 text-center relative">
            <div class="absolute top-3 right-3 text-[10px] bg-corporate-600 px-2 py-0.5 rounded font-extrabold tracking-wider">MINFI</div>
            <div class="inline-flex items-center justify-center w-12 h-12 bg-slate-800 rounded-lg mb-2 text-corporate-600 shadow">
                <img src="{{ asset('logo-cenadi.jpg') }}" alt="Logo" class="w-full h-full object-cover rounded-lg">
            </div>
            <h1 class="text-base font-extrabold tracking-tight">CENADI Douala</h1>
            <p class="text-xs text-slate-300 font-semibold mt-0.5">Système de Gestion des Projets (SIG-Projet)</p>
        </div>

        <!-- Formulaire de Connexion -->
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-600 text-red-900 text-xs rounded font-extrabold">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="space-y-4" method="POST" action="{{ secure_url('/login') }}">
                @csrf
                <div>
                    <label class="block text-xs font-extrabold text-black uppercase tracking-wider mb-1">Email</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-black font-bold text-lg">mail</span>
                        <input class="w-full bg-slate-100 border border-slate-300 rounded-lg pl-10 pr-3 py-2.5 text-xs text-black font-bold focus:outline-none focus:ring-2 focus:ring-corporate-600" id="matricule" name="email" placeholder="ex: agent@cenadi.cm" type="email" required>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-extrabold text-black uppercase tracking-wider" for="passwordInput">Mot de passe</label>
                        <button type="button" id="openRecoveryModal" class="text-xs text-corporate-600 hover:underline font-extrabold">Mot de passe oublié ?</button>
                    </div>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-black font-bold text-lg">lock</span>
                        <input class="w-full bg-slate-100 border border-slate-300 rounded-lg pl-10 pr-10 py-2.5 text-xs text-black font-bold focus:outline-none focus:ring-2 focus:ring-corporate-600" id="passwordInput" name="password" placeholder="••••••••" type="password" required>
                        <button type="button" id="togglePasswordBtn" class="absolute right-3 text-black hover:text-black">
                            <span class="material-symbols-outlined text-lg" id="pwdEyeIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" checked class="rounded border-slate-300 text-corporate-600 focus:ring-corporate-600 w-4 h-4">
                        <span class="text-black font-bold">Mémoriser cet équipement</span>
                    </label>
                </div>

                <button class="w-full bg-corporate-600 hover:bg-corporate-700 text-white py-3 px-4 rounded-lg text-xs font-extrabold uppercase tracking-wider flex items-center justify-center gap-2 shadow-sm transition-all mt-2" type="submit">
                    <span class="material-symbols-outlined text-lg">login</span>
                    <span>Se Connecter à l'Espace Projets</span>
                </button>
            </form>
        </div>

        <!-- Pied de page sécurisé -->
        <div class="bg-slate-100 px-6 py-3 border-t border-slate-300 text-center">
            <p class="text-[11px] text-black font-extrabold flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-xs text-corporate-600">shield</span> Antenne Régionale Douala
            </p>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('passwordInput');
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('pwdEyeIcon');
        if (toggleBtn && passwordInput && eyeIcon) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
            });
        }
    </script>
</body>
</html>
