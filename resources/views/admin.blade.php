<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Panneau Administrateur</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-cenadi.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans text-slate-900 flex flex-col min-h-screen">

<!-- HEADER EN VERT -->
<header class="fixed top-0 w-full z-50 bg-green-600 text-white shadow-md">
    <div class="h-16 px-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-cenadi.jpg') }}" alt="Logo CENADI" class="h-10 w-auto object-contain rounded bg-white p-0.5">
            <div class="flex flex-col">
                <span class="text-[10px] text-white uppercase font-bold tracking-wider">CENADI-Douala | SIG-Projets</span>
                <span class="text-sm font-bold text-white">Administration Système</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" id="global-search" placeholder="Rechercher..." class="hidden sm:block text-xs px-3 py-1.5 bg-white text-slate-900 border border-slate-300 rounded-lg focus:outline-none font-medium" onkeyup="filterAdminContent()">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="w-9 h-9 flex items-center justify-center text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors" title="Se déconnecter">
                    <span class="material-symbols-outlined text-xl">logout</span>
                </button>
            </form>
        </div>
    </div>
</header>

<div class="flex flex-1 pt-16 min-h-screen">
    <aside class="w-64 bg-white border-r border-slate-300 hidden md:flex flex-col p-4 fixed top-16 bottom-0 z-40">
        <span class="text-[11px] font-extrabold uppercase text-slate-800 tracking-wider mb-3 px-2">Navigation</span>
        <nav class="flex flex-col gap-1">
            <button onclick="switchTab('admin-home')" id="nav-admin-home" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-green-700 font-extrabold bg-green-50 text-xs text-left border border-green-200">
                <span class="material-symbols-outlined text-lg">dashboard</span><span>Vue Globale</span>
            </button>
            <button onclick="switchTab('admin-users')" id="nav-admin-users" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-800 hover:bg-slate-100 text-xs text-left font-semibold">
                <span class="material-symbols-outlined text-lg">manage_accounts</span><span>Utilisateurs &amp; IAM</span>
            </button>
            <button onclick="switchTab('admin-backup')" id="nav-admin-backup" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-800 hover:bg-slate-100 text-xs text-left font-semibold">
                <span class="material-symbols-outlined text-lg">database</span><span>Sauvegarde &amp; SAN</span>
            </button>
            <button onclick="switchTab('admin-logs')" id="nav-admin-logs" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-800 hover:bg-slate-100 text-xs text-left font-semibold">
                <span class="material-symbols-outlined text-lg">history</span><span>Journal d'Activité</span>
            </button>
        </nav>
    </aside>

    <main class="flex flex-col w-full md:ml-64 p-6 gap-6">
        @if(session('success'))
        <div class="p-3 bg-emerald-100 border-l-4 border-green-600 text-emerald-900 rounded text-xs font-bold">{{ session('success') }}</div>
        @endif

        <!-- SECTION 1 -->
        <section id="section-admin-home" class="admin-section flex flex-col gap-4 searchable-item">
            <div class="bg-white p-6 rounded-xl border border-slate-300 shadow-sm">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-emerald-100 text-emerald-900 rounded-full text-xs font-bold mb-2">
                    <span class="w-2 h-2 rounded-full bg-green-600 animate-pulse"></span> Sécurité Opérationnelle • v2.4.0
                </div>
                <h2 class="text-xl font-extrabold text-slate-900">Panneau Administrateur ({{ $user->name }})</h2>
                <p class="text-xs text-slate-700 mt-1 font-medium">Supervision centrale, gouvernance des identités et intégrité système CENADI-Douala.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl border border-slate-300 shadow-sm">
                    <span class="text-xs text-slate-700 font-extrabold uppercase">Total Utilisateurs</span>
                    <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalUsers }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-300 shadow-sm">
                    <span class="text-xs text-slate-700 font-extrabold uppercase">Actifs</span>
                    <div class="text-2xl font-extrabold text-green-700 mt-1">{{ $activeUsers }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-300 shadow-sm">
                    <span class="text-xs text-slate-700 font-extrabold uppercase">Projets Enregistrés</span>
                    <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalProjects }}</div>
                </div>
            </div>
        </section>

        <!-- SECTION 2 : IAM -->
        <section id="section-admin-users" class="admin-section hidden flex flex-col gap-4 searchable-item">
            <h3 class="text-sm font-extrabold uppercase text-slate-900 tracking-wider">Gestion des Utilisateurs &amp; Rôles</h3>
            <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-5 rounded-xl border border-slate-300 shadow-sm flex flex-col gap-3">
                @csrf
                <h4 class="text-xs font-extrabold uppercase text-green-700">Enregistrer un nouvel agent</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input type="text" name="name" placeholder="Nom complet..." required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg text-slate-900 font-medium">
                    <input type="email" name="email" placeholder="Email professionnel..." required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg text-slate-900 font-medium">
                    <input type="password" name="password" placeholder="Mot de passe provisoire..." required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg text-slate-900 font-medium">
                    <select name="role" required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg text-slate-900 font-semibold">
                        <option value="admin">Administrateur</option>
                        <option value="chef_projet">Chef de Projet</option>
                        <option value="member">Membre d'équipe</option>
                        <option value="sponsor">Sponsor / Commanditaire</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-xs font-bold uppercase rounded-lg shadow-sm">Créer le compte</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.admin-section').forEach(el => el.classList.add('hidden'));
    document.getElementById('section-' + tabName).classList.remove('hidden');
}
function filterAdminContent() {
    const query = document.getElementById('global-search').value.toLowerCase();
    document.querySelectorAll('.searchable-item').forEach(item => {
        item.style.display = item.innerText.toLowerCase().includes(query) ? 'flex' : 'none';
    });
}
</script>
</body>
</html>
