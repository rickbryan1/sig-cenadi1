<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Panneau Administrateur</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Geist', 'sans-serif'] },
                    colors: { corporate: { 600: '#16a34a', 700: '#15803d' } }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-900 flex flex-col min-h-screen">

<!-- HEADER -->
<header class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur border-b border-slate-200">
    <div class="h-16 px-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileMenu()" class="md:hidden w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 rounded-lg">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            <div class="flex flex-col">
                <span class="text-[10px] text-slate-500 uppercase font-semibold tracking-wider">CENADI-Douala | SIG-Projets</span>
                <span class="text-sm font-bold text-slate-900">Administration Système</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" id="global-search" placeholder="Rechercher..." class="hidden sm:block text-xs px-3 py-1.5 bg-slate-100 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-corporate-600" onkeyup="filterAdminContent()">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Se déconnecter">
                    <span class="material-symbols-outlined text-xl">logout</span>
                </button>
            </form>
        </div>
    </div>
</header>

<!-- LAYOUT PRINCIPAL -->
<div class="flex flex-1 pt-16 min-h-screen">
    <!-- SIDEBAR DESKTOP -->
    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col p-4 fixed top-16 bottom-0 z-40">
        <span class="text-[11px] font-bold uppercase text-slate-400 tracking-wider mb-3 px-2">Navigation</span>
        <nav class="flex flex-col gap-1">
            <button onclick="switchTab('admin-home')" id="nav-admin-home" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-corporate-600 font-semibold bg-slate-100 text-xs text-left">
                <span class="material-symbols-outlined text-lg">dashboard</span><span>Vue Globale</span>
            </button>
            <button onclick="switchTab('admin-users')" id="nav-admin-users" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 text-xs text-left">
                <span class="material-symbols-outlined text-lg">manage_accounts</span><span>Utilisateurs &amp; IAM</span>
            </button>
            <button onclick="switchTab('admin-backup')" id="nav-admin-backup" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 text-xs text-left">
                <span class="material-symbols-outlined text-lg">database</span><span>Sauvegarde &amp; SAN</span>
            </button>
            <button onclick="switchTab('admin-logs')" id="nav-admin-logs" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 text-xs text-left">
                <span class="material-symbols-outlined text-lg">history</span><span>Journal d'Activité</span>
            </button>
        </nav>
    </aside>

    <!-- CONTENU -->
    <main class="flex flex-col w-full md:ml-64 p-6 gap-6">
        @if(session('success'))
        <div class="p-3 bg-emerald-50 border-l-4 border-corporate-600 text-emerald-800 rounded text-xs font-semibold">{{ session('success') }}</div>
        @endif

        <!-- SECTION 1 -->
        <section id="section-admin-home" class="admin-section flex flex-col gap-4 searchable-item">
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold mb-2">
                    <span class="w-2 h-2 rounded-full bg-corporate-600 animate-pulse"></span> Sécurité Opérationnelle • v2.4.0
                </div>
                <h2 class="text-xl font-bold text-slate-900">Panneau Administrateur ({{ $user->name }})</h2>
                <p class="text-xs text-slate-500 mt-1">Supervision centrale, gouvernance des identités et intégrité système CENADI-Douala.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-xs text-slate-500 font-bold uppercase">Total Utilisateurs</span>
                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalUsers }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-xs text-slate-500 font-bold uppercase">Actifs</span>
                    <div class="text-2xl font-bold text-corporate-600 mt-1">{{ $activeUsers }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-xs text-slate-500 font-bold uppercase">Projets Enregistrés</span>
                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalProjects }}</div>
                </div>
            </div>
        </section>

        <!-- SECTION 2 : IAM -->
        <section id="section-admin-users" class="admin-section hidden flex flex-col gap-4 searchable-item">
            <h3 class="text-sm font-bold uppercase text-slate-700 tracking-wider">Gestion des Utilisateurs &amp; Rôles</h3>
            <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col gap-3">
                @csrf
                <h4 class="text-xs font-bold uppercase text-corporate-600">Enregistrer un nouvel agent</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input type="text" name="name" placeholder="Nom complet..." required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg">
                    <input type="email" name="email" placeholder="Email professionnel..." required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg">
                    <input type="password" name="password" placeholder="Mot de passe provisoire..." required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg">
                    <select name="role" required class="bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg">
                        <option value="admin">Administrateur</option>
                        <option value="chef_projet">Chef de Projet</option>
                        <option value="member">Membre d'équipe</option>
                        <option value="sponsor">Sponsor / Commanditaire</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-corporate-600 hover:bg-corporate-700 text-white px-4 py-2 text-xs font-bold uppercase rounded-lg shadow-sm">Créer le compte</button>
                </div>
            </form>

            <div class="flex flex-col gap-2">
                @foreach($users as $u)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between gap-2">
                    <div>
                        <strong class="text-xs text-slate-900 block">{{ $u->name }} ({{ $u->email }})</strong>
                        <span class="text-[10px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-bold uppercase">{{ $u->role }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($u->id !== Auth::id())
                        <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 text-[10px] rounded font-bold uppercase {{ $u->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $u->is_active ? 'Actif' : 'Suspendu' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600"><span class="material-symbols-outlined text-lg">delete</span></button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- SECTION 3 : SAN BACKUP -->
        <section id="section-admin-backup" class="admin-section hidden flex flex-col gap-4 searchable-item">
            <h3 class="text-sm font-bold uppercase text-slate-700 tracking-wider">Sauvegarde &amp; Continuité d'Activité</h3>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col gap-3">
                <span class="text-xs font-bold text-slate-500 uppercase">PostgreSQL Cloud CENADI • SAN Bonanjo (18.4 Go chiffré)</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('admin.backup') }}" class="flex items-center justify-center gap-2 bg-corporate-600 hover:bg-corporate-700 text-white py-2.5 px-4 text-xs font-bold rounded-lg shadow-sm">
                        <span class="material-symbols-outlined text-base">download</span> Créer Sauvegarde Immédiate (.sql)
                    </a>
                    <form action="{{ route('admin.restore') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 items-center">
                        @csrf
                        <input type="file" name="backup_file" required class="text-xs text-slate-500 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100">
                        <button type="submit" class="bg-slate-200 hover:bg-slate-300 text-slate-800 py-2.5 px-4 text-xs font-bold rounded-lg">Restaurer</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- SECTION 4 : LOGS -->
        <section id="section-admin-logs" class="admin-section hidden flex flex-col gap-4 searchable-item">
            <h3 class="text-sm font-bold uppercase text-slate-700 tracking-wider">Journal d'Activité &amp; Connexions</h3>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col gap-2 max-h-80 overflow-y-auto divide-y divide-slate-100">
                @forelse($activityLogs ?? [] as $log)
                    <div class="pt-2.5 first:pt-0 flex justify-between items-center text-xs">
                        <div>
                            <strong class="text-slate-900">{{ $log->user->name ?? 'Utilisateur' }}</strong>
                            <p class="text-corporate-600 font-mono text-[11px]">{{ $log->action }}</p>
                        </div>
                        <span class="text-slate-400 font-mono text-[11px]">{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">Aucun journal d'activité enregistré.</p>
                @endforelse
            </div>
        </section>
    </main>
</div>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.admin-section').forEach(el => el.classList.add('hidden'));
    document.getElementById('section-' + tabName).classList.remove('hidden');
    document.querySelectorAll('.nav-tab').forEach(el => {
        el.classList.remove('text-corporate-600', 'font-semibold', 'bg-slate-100');
        el.classList.add('text-slate-600');
    });
    document.getElementById('nav-' + tabName).classList.add('text-corporate-600', 'font-semibold', 'bg-slate-100');
    document.getElementById('nav-' + tabName).classList.remove('text-slate-600');
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