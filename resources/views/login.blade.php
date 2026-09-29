<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Portail d'Authentification Sécurisé</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-cenadi.jpg') }}">
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
</head>
<body class="h-full bg-slate-100 font-sans text-slate-900 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-xl border border-slate-300 overflow-hidden">
        
        <!-- EN-TÊTE EN VERT -->
        <div class="bg-green-600 text-white p-6 text-center relative">
            <div class="absolute top-3 right-3 text-[10px] bg-slate-900 px-2 py-0.5 rounded font-bold tracking-wider">MINFI</div>
            <div class="inline-flex items-center justify-center mb-2 bg-white rounded-lg p-1">
                <img src="{{ asset('images/logo-cenadi.jpg') }}" alt="Logo CENADI" class="h-10 w-auto object-contain">
            </div>
            <h1 class="text-base font-extrabold tracking-tight">CENADI Douala</h1>
            <p class="text-xs text-white/90 mt-0.5 font-semibold">Système Intégré de Gestion des Projets (SIG-Projet)</p>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-600 text-red-900 text-xs font-bold rounded">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="space-y-4" method="POST" action="{{ secure_url('/login') }}">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1">Email Institutionnel</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-slate-500 text-lg">mail</span>
                        <input class="w-full bg-slate-50 border border-slate-300 rounded-lg pl-10 pr-3 py-2.5 text-xs text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-green-600" id="matricule" name="email" placeholder="ex: agent@cenadi.cm" type="email" required>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider" for="passwordInput">Mot de passe</label>
                        <button type="button" id="openRecoveryModal" class="text-xs text-green-700 hover:underline font-bold">Mot de passe oublié ?</button>
                    </div>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-slate-500 text-lg">lock</span>
                        <input class="w-full bg-slate-50 border border-slate-300 rounded-lg pl-10 pr-10 py-2.5 text-xs text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-green-600" id="passwordInput" name="password" placeholder="••••••••" type="password" required>
                        <button type="button" id="togglePasswordBtn" class="absolute right-3 text-slate-500 hover:text-slate-800">
                            <span class="material-symbols-outlined text-lg" id="pwdEyeIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" checked class="rounded border-slate-300 text-green-600 focus:ring-green-600 w-4 h-4">
                        <span class="text-slate-700 font-semibold">Mémoriser cet équipement</span>
                    </label>
                </div>

                <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg text-xs font-extrabold uppercase tracking-wider flex items-center justify-center gap-2 shadow-sm transition-all mt-2" type="submit">
                    <span class="material-symbols-outlined text-lg">login</span>
                    <span>Se Connecter à l'Espace Projets</span>
                </button>
            </form>
        </div>

        <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 text-center">
            <p class="text-[11px] text-slate-700 font-bold flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-xs text-green-600">shield</span> Chiffré SSL/TLS • Antenne Régionale Douala
            </p>
        </div>
    </div>
</body>
</html>
