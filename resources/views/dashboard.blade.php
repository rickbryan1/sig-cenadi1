<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Chef de Projet</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-cenadi.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900 flex flex-col min-h-screen">

<!-- HEADER EN VERT -->
<header class="fixed top-0 w-full z-50 bg-green-600 text-white shadow-md">
<div class="h-16 px-6 flex items-center justify-between gap-4">
    <div class="flex items-center gap-3 min-w-0">
        <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 flex items-center justify-center text-white hover:bg-green-700 rounded-full">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>
        <img src="{{ asset('images/logo-cenadi.jpg') }}" alt="CENADI Logo" class="h-10 w-auto max-w-[120px] object-contain rounded bg-white p-0.5">
        <div class="flex flex-col min-w-0">
            <span class="text-[11px] font-bold text-white uppercase tracking-tight">CENADI-Douala | Sig-Projets</span>
            <span class="text-sm font-extrabold text-white truncate">Chef de Projet</span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <input type="text" id="global-search" placeholder="Rechercher..." class="text-xs px-3 py-2 bg-white text-slate-900 border border-slate-300 rounded-md focus:outline-none w-40 font-medium" onkeyup="filterDashboardContent()">
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="py-1.5 px-3 bg-red-600 text-white hover:bg-red-700 rounded text-xs font-bold flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-[16px]">logout</span> Se déconnecter
            </button>
        </form>
    </div>
</div>
</header>

<div class="flex flex-1 pt-16 min-h-screen">
    <aside class="w-64 bg-white border-r border-slate-300 hidden md:flex flex-col p-4 fixed top-16 bottom-0 z-40">
        <span class="text-[11px] font-extrabold uppercase text-slate-800 tracking-wider mb-3 px-2">Navigation</span>
        <nav class="flex flex-col gap-1">
            <button onclick="switchTab('dashboard')" id="nav-dashboard" class="nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-green-700 font-extrabold bg-green-50 text-xs border border-green-200">
                <span class="material-symbols-outlined text-[18px]">dashboard</span>
                <span>Dashboard</span>
            </button>
            <button onclick="switchTab('projects-ongoing')" id="nav-projects-ongoing" class="nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-slate-800 hover:bg-slate-100 text-xs font-semibold">
                <span class="material-symbols-outlined text-[18px]">folder</span>
                <span>Projets En Cours</span>
            </button>
            <button onclick="switchTab('tasks-ongoing')" id="nav-tasks-ongoing" class="nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-slate-800 hover:bg-slate-100 text-xs font-semibold">
                <span class="material-symbols-outlined text-[18px]">task_alt</span>
                <span>Tâches En Cours</span>
            </button>
            <button onclick="switchTab('projects-closed')" id="nav-projects-closed" class="nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-slate-800 hover:bg-slate-100 text-xs font-semibold">
                <span class="material-symbols-outlined text-[18px]">verified</span>
                <span>Projets Clôturés</span>
            </button>
            <button onclick="switchTab('alerts')" id="nav-alerts" class="nav-tab flex items-center justify-between px-3 py-2 rounded-md text-slate-800 hover:bg-slate-100 text-xs font-semibold">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[18px]">warning</span>
                    <span>Alertes</span>
                </div>
            </button>
        </nav>
    </aside>

    <main class="flex flex-col relative w-full md:ml-64 pb-20 bg-slate-100 min-h-screen">
    <div class="flex flex-col w-full pb-12 p-4 md:p-6">

    @if(session('success'))
    <div class="mb-4 p-3 bg-emerald-100 border-l-4 border-green-600 text-emerald-900 rounded-md text-xs font-bold shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- SECTION 1 : DASHBOARD -->
    <section id="section-dashboard" class="dashboard-section flex flex-col gap-4">
        <div class="bg-white shadow-xs border border-slate-300 p-4 rounded-lg flex flex-col gap-3">
            <div class="flex items-start justify-between gap-3">
                <div class="flex flex-col min-w-0">
                    <span class="text-xs text-green-700 font-extrabold uppercase">CENADI-Douala • Exercice 2026</span>
                    <span class="text-base font-extrabold text-slate-900 truncate mt-1">{{ auth()->user()->name }}</span>
                    <p class="text-xs text-slate-700 font-medium">Chef de Projet Senior • Supervision Portefeuille</p>
                </div>
                <button onclick="toggleWizard()" class="flex-shrink-0 flex items-center gap-1.5 px-3 py-2 bg-green-600 text-white text-xs font-bold rounded-md shadow-xs hover:bg-green-700 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    <span>Nouveau Projet</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white p-4 flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <span class="text-xs text-slate-700 font-bold uppercase">Projets Actifs</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $projects->where('status', 'en_cours')->count() }}</div>
            </div>
            <div class="bg-white p-4 flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <span class="text-xs text-slate-700 font-bold uppercase">Validations</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $projects->where('status', 'en_attente_validation')->count() }}</div>
            </div>
            <div class="bg-white p-4 flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <span class="text-xs text-slate-700 font-bold uppercase">Tâches Clôturées</span>
                @php $closedTasksCount = \App\Models\Task::where('status', 'termine')->count(); @endphp
                <div class="text-2xl font-extrabold text-slate-900">{{ $closedTasksCount }}</div>
            </div>
            <div class="bg-white p-4 flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <span class="text-xs text-slate-700 font-bold uppercase">Alertes Blocage</span>
                <div class="text-2xl font-extrabold text-red-700">{{ $blockageAlerts->count() }}</div>
            </div>
        </div>

        <!-- WIZARD D'INITIALISATION DE PROJET -->
        <div id="wizard-container" class="hidden bg-white shadow-lg rounded-lg border border-slate-300 overflow-hidden mt-3">
            <div class="bg-green-600 text-white px-4 py-3 flex items-center justify-between">
                <span class="font-extrabold text-xs uppercase tracking-wider">Initialisation du Projet &amp; Équipe</span>
                <button onclick="toggleWizard()" class="text-white p-1 rounded font-bold">✕</button>
            </div>

            <form action="{{ route('projects.store') }}" method="POST" class="p-4 flex flex-col gap-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-slate-800 font-bold uppercase">Nom Officiel du Projet</label>
                        <input type="text" name="name" placeholder="Ex: Modernisation Datacenter Régional" required class="px-3 py-2 bg-slate-50 text-slate-900 border border-slate-300 rounded-md text-xs font-semibold">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-slate-800 font-bold uppercase">Commanditaire (Sponsor)</label>
                        <select name="sponsor_id" required class="px-3 py-2 bg-slate-50 text-slate-900 border border-slate-300 rounded-md text-xs font-semibold">
                            <option value="">Sélectionner le commanditaire...</option>
                            @foreach($sponsors ?? [] as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }} ({{ $sponsor->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs text-slate-800 font-bold uppercase">Description du Projet</label>
                    <textarea name="description" rows="2" placeholder="Résumé descriptif..." required class="px-3 py-2 bg-slate-50 text-slate-900 border border-slate-300 rounded-md text-xs font-semibold"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-slate-800 font-bold uppercase">Budget Global (FCFA)</label>
                        <input type="number" name="budget_allocated" placeholder="185000000" required class="px-3 py-2 bg-slate-50 text-slate-900 border border-slate-300 rounded-md text-xs font-semibold">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-slate-800 font-bold uppercase">Date Début Prévue</label>
                        <input type="date" name="start_date" id="start_date" required class="px-3 py-2 bg-slate-50 text-slate-900 border border-slate-300 rounded-md text-xs font-semibold">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-slate-800 font-bold uppercase">Date Fin Prévue</label>
                        <input type="date" name="end_date" id="end_date" required class="px-3 py-2 bg-slate-50 text-slate-900 border border-slate-300 rounded-md text-xs font-semibold">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 text-xs uppercase font-extrabold rounded-md shadow-xs hover:bg-green-700 transition-colors">
                        Enregistrer le Projet &amp; l'Équipe
                    </button>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-3 searchable-container mt-4">
            <h3 class="text-sm font-extrabold uppercase text-slate-900 tracking-wider">Portefeuille Détaillé des Projets (CENADI-Douala)</h3>
            
            @forelse($projects ?? [] as $proj)
            <div class="bg-white p-4 rounded-lg shadow-xs border border-slate-300 searchable-item flex flex-col gap-3">
                <div class="flex flex-wrap items-start justify-between gap-2 border-b pb-3 border-slate-200">
                    <div>
                        <span class="text-[11px] uppercase tracking-wider text-green-700 font-bold">Projet #{{ $proj->id }}</span>
                        <h4 class="text-base font-extrabold text-slate-900">{{ $proj->name }}</h4>
                        <p class="text-xs text-slate-700 mt-1 font-medium">{{ $proj->description }}</p>
                    </div>
                    <span class="px-2.5 py-1 text-[11px] uppercase font-bold rounded border border-slate-300 bg-slate-100 text-slate-900">
                        {{ str_replace('_', ' ', $proj->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="bg-white p-6 text-center text-slate-600 shadow-xs border border-slate-300 rounded-lg font-semibold">
                Aucun projet dans votre portefeuille.
            </div>
            @endforelse
        </div>
    </section>

    </section>
    </div>
    </main>
</div>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.dashboard-section').forEach(el => el.classList.add('hidden'));
    document.getElementById('section-' + tabName).classList.remove('hidden');
}
function toggleWizard() {
    const wizard = document.getElementById('wizard-container');
    wizard.classList.toggle('hidden');
}
function filterDashboardContent() {
    const query = document.getElementById('global-search').value.toLowerCase();
    document.querySelectorAll('.searchable-item').forEach(item => {
        item.style.display = item.innerText.toLowerCase().includes(query) ? 'flex' : 'none';
    });
}
</script>
</body>
</html>
