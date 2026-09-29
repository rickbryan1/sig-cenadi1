<!DOCTYPE html><html lang="fr"><head><meta charset="utf-8"><meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" name="viewport"><meta content="mobile_tab" name="shell-type">
<!-- Icône du logo -->
<link rel="icon" type="image/jpeg" href="{{ asset('logo-cenadi.jpg') }}">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&amp;family=Space+Grotesk:wght@100..900&amp;display=swap" rel="stylesheet">
<style>
@layer base {
    html, body { width: 100vw; margin: 0; padding: 0; }
    body {
        overscroll-behavior: none;
        background-image: url('{{ asset('logo-cenadi.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    .pb-safe{padding-bottom:env(safe-area-inset-bottom,0px);}
    .pt-safe{padding-top:env(safe-area-inset-top,0px);}
    main>:first-child{margin-top:0!important;}
    main>:last-child{margin-bottom:0!important;}
}
::-webkit-scrollbar{display:none;}
</style>
<script src="https://cdn.tailwindcss.com"></script>
<script id="tailwind-config">tailwind.config = { darkMode: "class", theme: { extend: { colors: { "surface-bright": "#f8fafc", "surface-container-lowest": "#ffffff", "on-surface": "#000000", "on-surface-variant": "#111827", "secondary": "#111827", "outline": "#94a3b8", "outline-variant": "#cbd5e1", "surface": "#f8fafc", "surface-container": "#f1f5f9", "surface-container-low": "#f8fafc", "surface-container-high": "#e2e8f0", "primary": "#0f172a", "on-primary": "#ffffff", "error": "#991b1b", "on-error": "#ffffff" }, borderRadius: { "DEFAULT": "0.375rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" }, spacing: { "space-lg": "1.5rem", "space-md": "1rem", "space-sm": "0.5rem", "space-2xl": "3rem", "gutter": "1rem", "margin": "1rem" }, fontFamily: { "code-budget": ["Geist"], "body-md": ["Geist"], "label-sm": ["Geist"], "headline-lg": ["Space Grotesk"], "headline-sm": ["Space Grotesk"], "body-lg": ["Geist"], "headline-md": ["Space Grotesk"], "body-sm": ["Geist"], "display": ["Space Grotesk"], "label-md": ["Geist"], "headline-lg-mobile": ["Space Grotesk"] } } } }</script>
</head><body class="bg-black/30 text-black font-bold flex flex-col min-h-screen">

<!-- HEADER -->
<header class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-xl border-b border-slate-300 pt-safe">
<div class="h-16 px-margin flex items-center justify-between gap-space-sm">
    <div class="flex items-center gap-space-sm min-w-0">
        <button onclick="toggleMobileMenu()" aria-label="Menu" class="md:hidden w-10 h-10 flex items-center justify-center text-black hover:bg-slate-100 rounded-full transition-colors flex-shrink-0">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>

        <img alt="CENADI Logo" class="h-10 w-auto max-w-[120px] object-contain flex-shrink-0 bg-white rounded p-0.5 border border-slate-300" src="{{ asset('logo-cenadi.jpg') }}">
        <div class="flex flex-col min-w-0">
            <span class="text-[11px] font-extrabold text-black truncate tracking-tight uppercase">CENADI-Douala | Sig-Projets</span>
            <span class="text-sm font-extrabold text-black truncate">Chef de Projet</span>
        </div>
    </div>

    <div class="flex items-center gap-space-xs flex-shrink-0">
        <div class="relative hidden sm:block">
            <input type="text" id="global-search" placeholder="Rechercher..." class="text-xs px-3 py-2 bg-slate-100 border border-slate-300 rounded-md focus:outline-none focus:ring-1 focus:ring-black w-40 text-black font-bold" onkeyup="filterDashboardContent()">
        </div>

        <div class="relative">
            <button onclick="toggleNotificationsMenu()" aria-label="Notifications" class="relative w-10 h-10 flex items-center justify-center text-black hover:bg-slate-100 transition-colors rounded-full">
                <span class="material-symbols-outlined text-[20px]">notifications</span>
                @php 
                    $blockageAlerts = \App\Models\Task::where('status', 'bloque')->get(); 
                @endphp
                @if($blockageAlerts->count() > 0)
                    <span class="absolute top-1 right-1 w-4 h-4 bg-error text-on-error text-[10px] leading-none flex items-center justify-center rounded-full font-extrabold">{{ $blockageAlerts->count() }}</span>
                @endif
            </button>
            <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-md p-3 z-50 border border-slate-300">
                <div class="flex justify-between items-center pb-2 border-b border-slate-300 mb-2">
                    <span class="text-xs font-extrabold uppercase text-black">Demandes de Blocage Équipe</span>
                    <span class="text-[10px] bg-slate-100 text-black px-2 py-0.5 rounded font-extrabold">{{ $blockageAlerts->count() }}</span>
                </div>
                <div class="flex flex-col gap-2 max-h-60 overflow-y-auto">
                    @forelse($blockageAlerts as $alert)
                        <div class="p-2 bg-slate-50 rounded text-xs border border-slate-200">
                            <strong class="text-black block font-extrabold">Tâche : {{ $alert->title }}</strong>
                            <span class="text-black block font-bold">Signalé par : {{ $alert->user->name ?? 'Membre' }}</span>
                            <p class="text-black font-semibold mt-1 italic">"{{ $alert->blockage_reason ?? 'Aucune précision' }}"</p>
                        </div>
                    @empty
                        <p class="text-xs text-black font-bold text-center py-4">Aucune demande de blocage active.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="relative">
            <button onclick="toggleProfileMenu()" class="flex items-center gap-2 pl-2 py-1 pr-1 hover:bg-slate-100 transition-colors rounded-full border border-slate-300">
                <img alt="Profile" class="w-7 h-7 rounded-full object-cover" src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('logo-cenadi.jpg') }}">
                <span class="font-extrabold text-xs hidden sm:inline text-black">{{ auth()->user()->name }}</span>
                <span class="material-symbols-outlined text-[16px] text-black">expand_more</span>
            </button>
            <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-md p-3 z-50 border border-slate-300">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-1.5 px-3 bg-slate-100 text-black hover:bg-slate-200 rounded text-xs font-extrabold flex items-center justify-center gap-1 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">logout</span> Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</header>

<!-- TIROIR DE NAVIGATION MOBILE EN VERT FONCÉ -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-xs z-50 hidden md:hidden" onclick="toggleMobileMenu()"></div>
<aside id="mobile-sidebar" class="fixed top-0 bottom-0 left-0 w-64 border-r border-slate-300 z-50 flex flex-col p-4 transform -translate-x-full transition-transform duration-300 md:hidden shadow-xl" style="background-color: #0d5c2e;">
    <div class="flex items-center justify-between mb-4 pb-2 border-b border-white/20">
        <span class="text-xs font-extrabold uppercase text-white tracking-wider">Navigation</span>
        <button onclick="toggleMobileMenu()" class="p-1 text-white hover:bg-white/10 rounded-full">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>
    <nav class="flex flex-col gap-1">
        <button onclick="switchTab('dashboard'); toggleMobileMenu();" id="mobile-nav-dashboard" class="mobile-nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-white font-extrabold bg-[#114b24] text-xs transition-colors shadow">
            <span class="material-symbols-outlined text-[18px]">dashboard</span>
            <span>Dashboard</span>
        </button>
        <button onclick="switchTab('projects-ongoing'); toggleMobileMenu();" id="mobile-nav-projects-ongoing" class="mobile-nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors">
            <span class="material-symbols-outlined text-[18px]">folder</span>
            <span>Projets En Cours</span>
        </button>
        <button onclick="switchTab('tasks-ongoing'); toggleMobileMenu();" id="mobile-nav-tasks-ongoing" class="mobile-nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors">
            <span class="material-symbols-outlined text-[18px]">task_alt</span>
            <span>Tâches En Cours</span>
        </button>
        <button onclick="switchTab('projects-closed'); toggleMobileMenu();" id="mobile-nav-projects-closed" class="mobile-nav-tab flex items-center gap-3 px-3 py-2 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors">
            <span class="material-symbols-outlined text-[18px]">verified</span>
            <span>Projets Clôturés</span>
        </button>
        <button onclick="switchTab('alerts'); toggleMobileMenu();" id="mobile-nav-alerts" class="mobile-nav-tab flex items-center justify-between px-3 py-2 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors relative">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-[18px]">warning</span>
                <span>Alertes</span>
            </div>
            @if($blockageAlerts->count() > 0)
                <span class="w-4 h-4 bg-red-700 text-white rounded-full text-[10px] flex items-center justify-center font-extrabold">{{ $blockageAlerts->count() }}</span>
            @endif
        </button>
    </nav>
</aside>

<div class="flex flex-1 pt-16 min-h-screen">
    
    <!-- SIDEBAR GAUCHE (Desktop) EN VERT FONCÉ -->
    <aside class="w-64 border-r border-slate-300 hidden md:flex flex-col p-4 fixed top-16 bottom-0 z-40 shadow-md" style="background-color: #0d5c2e;">
        <span class="text-[11px] font-extrabold uppercase text-white tracking-wider mb-3 px-2">Navigation</span>
        <nav class="flex flex-col gap-1">
            <button onclick="switchTab('dashboard')" id="nav-dashboard" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-md text-white font-extrabold bg-[#114b24] text-xs transition-colors shadow">
                <span class="material-symbols-outlined text-[18px]">dashboard</span>
                <span>Dashboard</span>
            </button>
            <button onclick="switchTab('projects-ongoing')" id="nav-projects-ongoing" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors">
                <span class="material-symbols-outlined text-[18px]">folder</span>
                <span>Projets En Cours</span>
            </button>
            <button onclick="switchTab('tasks-ongoing')" id="nav-tasks-ongoing" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors">
                <span class="material-symbols-outlined text-[18px]">task_alt</span>
                <span>Tâches En Cours</span>
            </button>
            <button onclick="switchTab('projects-closed')" id="nav-projects-closed" class="nav-tab flex items-center gap-3 px-3 py-2.5 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors">
                <span class="material-symbols-outlined text-[18px]">verified</span>
                <span>Projets Clôturés</span>
            </button>
            <button onclick="switchTab('alerts')" id="nav-alerts" class="nav-tab flex items-center justify-between px-3 py-2.5 rounded-md text-white/90 hover:bg-white/10 hover:text-white text-xs font-bold transition-colors relative">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[18px]">warning</span>
                    <span>Alertes</span>
                </div>
                @if($blockageAlerts->count() > 0)
                    <span class="w-4 h-4 bg-red-700 text-white rounded-full text-[10px] flex items-center justify-center font-extrabold">{{ $blockageAlerts->count() }}</span>
                @endif
            </button>
        </nav>
    </aside>

    <main class="flex flex-col relative w-full md:ml-64 pb-20 min-h-screen">
    <div class="flex flex-col w-full pb-12 p-4 md:p-6">

    @if(session('success'))
    <div class="mb-4 p-3 bg-emerald-100 text-emerald-900 border border-emerald-300 rounded-md text-xs font-extrabold shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-900 border border-red-300 rounded-md text-xs font-extrabold shadow-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- ================= SECTION 1 : DASHBOARD ================= -->
    <section id="section-dashboard" class="dashboard-section flex flex-col gap-space-md">
        
        <div class="bg-white/95 shadow-sm border border-slate-300 p-space-md rounded-lg flex flex-col gap-space-sm">
            <div class="flex items-start justify-between gap-space-sm">
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-space-xs">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-slate-200 text-black font-extrabold text-[10px] tracking-wider uppercase rounded">
                            CENADI-Douala
                        </span>
                        <span class="text-xs text-black font-bold">Exercice 2026</span>
                    </div>
                    <span class="text-base font-extrabold text-black truncate mt-1">{{ auth()->user()->name }}</span>
                    <p class="text-xs text-black font-semibold">Chef de Projet Senior • Supervision Portefeuille</p>
                </div>
                <button onclick="toggleWizard()" class="flex-shrink-0 flex items-center gap-1.5 px-3 py-2 bg-black text-white text-xs font-extrabold rounded-md shadow-xs hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    <span>Nouveau Projet</span>
                </button>
            </div>
            <div class="flex items-center gap-space-xs overflow-x-auto no-scrollbar py-1">
                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-black font-bold text-[11px] flex-shrink-0 rounded-md border border-slate-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-corporate-600"></span> Système Opérationnel
                </div>
                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-black font-bold text-[11px] flex-shrink-0 rounded-md border border-slate-300">
                    <span class="material-symbols-outlined text-black text-[14px]">shield</span> Gouvernance MINFI
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm">
            <div class="bg-white/95 p-space-md flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <div class="flex items-start justify-between">
                    <span class="text-xs text-black font-extrabold">Projets Actifs</span>
                    <span class="material-symbols-outlined text-black text-[18px]">folder</span>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-black tracking-tight">{{ $projects->where('status', 'en_cours')->count() }}</div>
                    <p class="text-[11px] text-black font-bold mt-0.5">Sur {{ $projects->count() }} totaux</p>
                </div>
            </div>

            <div class="bg-white/95 p-space-md flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <div class="flex items-start justify-between">
                    <span class="text-xs text-black font-extrabold">Validations</span>
                    <span class="material-symbols-outlined text-black text-[18px]">pending_actions</span>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-black tracking-tight">{{ $projects->where('status', 'en_attente_validation')->count() }}</div>
                    <p class="text-[11px] text-black font-bold mt-0.5">En attente sponsor</p>
                </div>
            </div>

            <div class="bg-white/95 p-space-md flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <div class="flex items-start justify-between">
                    <span class="text-xs text-black font-extrabold">Tâches Clôturées</span>
                    <span class="material-symbols-outlined text-black text-[18px]">task_alt</span>
                </div>
                <div>
                    @php $closedTasksCount = \App\Models\Task::where('status', 'termine')->count(); @endphp
                    <div class="text-2xl font-extrabold text-black tracking-tight">{{ $closedTasksCount }}</div>
                    <p class="text-[11px] text-black font-bold mt-0.5">Terminées avec succès</p>
                </div>
            </div>

            <div class="bg-white/95 p-space-md flex flex-col justify-between shadow-xs border border-slate-300 rounded-lg min-h-[100px]">
                <div class="flex items-start justify-between">
                    <span class="text-xs text-black font-extrabold">Alertes Blocage</span>
                    <span class="material-symbols-outlined text-black text-[18px]">warning</span>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-black tracking-tight">{{ $blockageAlerts->count() }}</div>
                    <p class="text-[11px] text-black font-bold mt-0.5">Signalées par l'équipe</p>
                </div>
            </div>
        </div>

        <div class="bg-white/95 p-space-md shadow-xs border border-slate-300 rounded-lg flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-black text-[18px]">account_balance</span>
                    <span class="text-xs font-extrabold text-black uppercase tracking-wide">Budget Global Alloué (Portefeuille CENADI)</span>
                </div>
                <span class="text-[11px] bg-slate-200 text-black px-2 py-0.5 rounded font-mono border border-slate-300 font-extrabold">Temps Réel</span>
            </div>
            <div class="text-xl font-extrabold text-black">
                {{ number_format($projects->sum('budget_allocated'), 0, ',', ' ') }} <span class="text-xs text-black font-bold">FCFA TTC</span>
            </div>
            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden border border-slate-300">
                <div class="h-full bg-corporate-600" style="width: 100%;"></div>
            </div>
        </div>

        <!-- WIZARD -->
        <div id="wizard-container" class="hidden bg-white/95 shadow-lg rounded-lg border border-slate-300 overflow-hidden mt-3 transition-all duration-300">
            <div class="bg-black text-white px-4 py-3 flex items-center justify-between">
                <span class="font-extrabold text-xs uppercase tracking-wider flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">post_add</span>Initialisation du Projet &amp; Équipe
                </span>
                <button onclick="toggleWizard()" class="text-slate-300 hover:text-white p-1 rounded">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>

            <form action="{{ route('projects.store') }}" method="POST" class="p-4 flex flex-col gap-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-black font-extrabold uppercase">Nom Officiel du Projet</label>
                        <input type="text" name="name" placeholder="Ex: Modernisation Datacenter Régional" required class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-black font-extrabold uppercase">Commanditaire (Sponsor)</label>
                        <select name="sponsor_id" required class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black">
                            <option value="">Sélectionner le commanditaire...</option>
                            @foreach($sponsors ?? [] as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }} ({{ $sponsor->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs text-black font-extrabold uppercase">Description du Projet</label>
                    <textarea name="description" rows="2" placeholder="Résumé descriptif..." required class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs text-black font-extrabold uppercase">Objectifs Institutionnels &amp; Portée</label>
                    <textarea name="objectives" rows="2" placeholder="Décrivez les objectifs..." class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-black font-extrabold uppercase">Budget Global (FCFA)</label>
                        <input type="number" name="budget_allocated" placeholder="185000000" required class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-black font-extrabold uppercase">Date Début Prévue</label>
                        <input type="date" name="start_date" id="start_date" required class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-black font-extrabold uppercase">Date Fin Prévue</label>
                        <input type="date" name="end_date" id="end_date" required class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs text-black font-extrabold uppercase">Ressources Nécessaires</label>
                    <input type="text" name="resources" placeholder="Ex: Serveurs rack, Licences Cisco..." class="px-3 py-2 bg-slate-100 text-black font-bold border border-slate-300 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-black">
                </div>

                <div class="flex flex-col gap-1 bg-slate-100 p-3 rounded-md border border-slate-300">
                    <label class="text-xs text-black font-extrabold uppercase mb-1">Membres de l'équipe à intégrer au projet :</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-36 overflow-y-auto">
                        @forelse($members ?? [] as $member)
                            <label class="flex items-center gap-2 text-xs bg-white p-2 rounded border border-slate-300 cursor-pointer font-bold text-black">
                                <input type="checkbox" name="members[]" value="{{ $member->id }}" class="rounded border-slate-300 text-corporate-600">
                                <span class="font-extrabold text-black">{{ $member->name }}</span>
                                <span class="text-black font-medium">({{ $member->email }})</span>
                            </label>
                        @empty
                            <p class="text-xs text-black font-bold italic">Aucun membre disponible.</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="reset" class="px-3 py-2 bg-slate-200 text-black text-xs font-extrabold rounded-md border border-slate-300">Réinitialiser</button>
                    <button type="submit" class="bg-black text-white px-4 py-2 text-xs uppercase font-extrabold rounded-md shadow-xs hover:bg-slate-800 transition-colors">
                        Enregistrer le Projet &amp; l'Équipe
                    </button>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-3 searchable-container mt-4">
            <h3 class="text-sm font-extrabold uppercase text-white tracking-wider drop-shadow">Portefeuille Détaillé des Projets (CENADI-Douala)</h3>
            
            @forelse($projects ?? [] as $proj)
            <div class="bg-white/95 p-4 rounded-lg shadow-xs border border-slate-300 searchable-item flex flex-col gap-3">
                <div class="flex flex-wrap items-start justify-between gap-2 border-b pb-3 border-slate-300">
                    <div>
                        <span class="text-[11px] uppercase tracking-wider text-black font-extrabold">Projet #{{ $proj->id }}</span>
                        <h4 class="text-base font-extrabold text-black">{{ $proj->name }}</h4>
                        <p class="text-xs text-black font-semibold mt-1">{{ $proj->description }}</p>
                    </div>
                    <div>
                        <span class="px-2.5 py-1 text-[11px] uppercase font-extrabold rounded border border-slate-300 bg-slate-200 text-black">
                            {{ str_replace('_', ' ', $proj->status) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs bg-slate-100 p-3 rounded-md border border-slate-300 text-black font-bold">
                    <div>
                        <span class="text-black uppercase font-extrabold block text-[10px]">Objectifs :</span>
                        <span class="text-black font-semibold">{{ $proj->objectives ?? 'Non définis' }}</span>
                    </div>
                    <div>
                        <span class="text-black uppercase font-extrabold block text-[10px]">Période :</span>
                        <span class="font-mono text-black font-extrabold">{{ $proj->start_date }} ➜ {{ $proj->end_date }}</span>
                    </div>
                    <div>
                        <span class="text-black uppercase font-extrabold block text-[10px]">Budget Alloué :</span>
                        <span class="font-mono font-extrabold text-black">{{ number_format($proj->budget_allocated, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div>
                        <span class="text-black uppercase font-extrabold block text-[10px]">Sponsor :</span>
                        <span class="text-black font-extrabold">{{ $proj->sponsor->name ?? 'Aucun' }}</span>
                    </div>
                </div>

                @if($proj->resources)
                <div class="text-xs text-black font-bold">
                    <strong class="text-black font-extrabold uppercase text-[10px]">Ressources :</strong> <span class="text-black font-semibold">{{ $proj->resources }}</span>
                </div>
                @endif

                <div class="flex flex-col gap-1">
                    <span class="text-[11px] uppercase font-extrabold text-black">Membres de l'équipe :</span>
                    <div class="flex flex-wrap gap-1.5">
                        @forelse($proj->members ?? [] as $member)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-slate-100 border border-slate-300 text-black text-xs rounded-md font-extrabold">
                                <span class="material-symbols-outlined text-[14px] text-black">person</span> {{ $member->name }}
                            </span>
                        @empty
                            <span class="text-xs text-black font-bold italic">Aucun membre rattaché.</span>
                        @endforelse
                    </div>
                </div>

                <div class="flex flex-col gap-1 border-t pt-2 border-slate-300">
                    <span class="text-[11px] uppercase font-extrabold text-black">Tâches du projet &amp; Avancement :</span>
                    @forelse($proj->tasks ?? [] as $task)
                        <div class="flex items-center justify-between bg-slate-100 p-2 rounded-md border border-slate-300 text-xs text-black font-bold">
                            <div>
                                <strong class="text-black font-extrabold">{{ $task->title }}</strong> 
                                <span class="text-black font-semibold">(Membre : {{ $task->user->name ?? 'N/A' }})</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-extrabold text-black">{{ $task->progress ?? 0 }}%</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase border border-slate-300 bg-white text-black">
                                    {{ $task->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-black font-bold italic">Aucune tâche créée pour ce projet.</p>
                    @endforelse
                </div>

                @if($proj->status == 'brouillon')
                <div class="pt-2 flex justify-end">
                    <form action="{{ route('projects.sendToSponsor', $proj->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-black text-white px-3 py-2 text-xs uppercase font-extrabold rounded-md shadow-xs hover:bg-slate-800 flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">send</span> Envoyer au Commanditaire (Sponsor) pour Validation
                        </button>
                    </form>
                </div>
                @elseif($proj->status == 'en_cours')
                <div class="pt-3 border-t border-slate-300 flex flex-col gap-2">
                    <span class="text-xs font-extrabold text-black uppercase">Rapport d'Évaluation Final :</span>
                    <form action="{{ route('projects.submitEvaluation', $proj->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                        @csrf
                        <input type="file" name="evaluation_report" required class="text-xs text-black font-bold file:py-1.5 file:px-3 file:rounded-md file:border file:border-slate-300 file:bg-slate-100 file:text-black">
                        <button type="submit" class="bg-black text-white px-3 py-2 text-xs uppercase font-extrabold rounded-md shadow-xs hover:bg-slate-800 flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">rocket_launch</span> Transmettre l'Évaluation au Sponsor
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white/95 p-6 text-center text-black font-extrabold shadow-xs border border-slate-300 rounded-lg">
                <p class="text-sm">Aucun projet dans votre portefeuille. Cliquez sur <strong>+ Nouveau Projet</strong> pour commencer.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- ================= SECTION 2 : PROJETS EN COURS ================= -->
    <section id="section-projects-ongoing" class="dashboard-section hidden flex flex-col gap-space-md">
        <h2 class="text-sm font-extrabold uppercase text-white tracking-wider drop-shadow">Liste des Projets en Cours</h2>
        <div class="flex flex-col gap-3 searchable-container">
            @forelse($projects->where('status', 'en_cours') as $proj)
            <div class="bg-white/95 p-4 rounded-lg shadow-xs border border-slate-300 searchable-item flex flex-col gap-2">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-extrabold text-black text-sm">{{ $proj->name }}</h3>
                        <p class="text-xs text-black font-semibold mt-0.5">{{ $proj->description }}</p>
                    </div>
                    <span class="px-2.5 py-0.5 bg-slate-200 text-black text-[11px] rounded font-extrabold uppercase border border-slate-300">En cours</span>
                </div>
                <div class="text-xs text-black font-bold flex gap-4 mt-2">
                    <span>Période : {{ $proj->start_date }} ➜ {{ $proj->end_date }}</span>
                    <span>Budget : <strong class="text-black font-extrabold">{{ number_format($proj->budget_allocated, 0, ',', ' ') }} FCFA</strong></span>
                </div>
            </div>
            @empty
            <div class="bg-white/95 p-6 text-center text-black font-extrabold border border-slate-300 rounded-lg">Aucun projet en cours.</div>
            @endforelse
        </div>
    </section>

    <!-- ================= SECTION 3 : TÂCHES EN COURS ================= -->
    <section id="section-tasks-ongoing" class="dashboard-section hidden flex flex-col gap-space-md">
        <h2 class="text-sm font-extrabold uppercase text-white tracking-wider drop-shadow">Gestion &amp; Assignation des Tâches</h2>

        <div class="bg-white/95 p-4 rounded-lg shadow-xs border border-slate-300">
            <h3 class="text-xs font-extrabold text-black uppercase mb-3 flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">add_task</span> Assigner une nouvelle tâche à un membre</h3>
            <form action="{{ route('tasks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @csrf
                <select name="project_id" required class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md text-black font-bold focus:outline-none">
                    <option value="">Sélectionner un projet...</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <select name="user_id" required class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md text-black font-bold focus:outline-none">
                    <option value="">Sélectionner le membre de l'équipe...</option>
                    @foreach($members ?? [] as $m)
                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                    @endforeach
                </select>
                <input type="text" name="title" placeholder="Intitulé de la tâche..." required class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md md:col-span-2 text-black font-bold">
                <textarea name="description" placeholder="Instructions détaillées..." rows="2" class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md md:col-span-2 text-black font-bold"></textarea>
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] text-black font-extrabold uppercase">Durée estimée (jours)</label>
                    <input type="number" name="estimated_days" placeholder="5" min="1" required class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md text-black font-bold">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] text-black font-extrabold uppercase">Livrables attendus (nombre)</label>
                    <input type="number" name="expected_deliverables_count" placeholder="2" min="1" required class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md text-black font-bold">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] text-black font-extrabold uppercase">Date début</label>
                    <input type="date" name="start_date" required class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md text-black font-bold">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] text-black font-extrabold uppercase">Date d'échéance</label>
                    <input type="date" name="due_date" required class="bg-slate-100 px-3 py-2 text-xs border border-slate-300 rounded-md text-black font-bold">
                </div>
                <div class="md:col-span-2 flex justify-end mt-1">
                    <button type="submit" class="bg-black text-white px-4 py-2 text-xs uppercase font-extrabold rounded-md shadow-xs hover:bg-slate-800 flex items-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">assignment_add</span> Assigner la tâche
                    </button>
                </div>
            </form>
        </div>

        <h3 class="text-sm font-extrabold uppercase text-white tracking-wider mt-2 drop-shadow">Liste &amp; Examen des Livrables de Tâches</h3>
        <div class="flex flex-col gap-3 searchable-container">
            @php $allTasks = \App\Models\Task::with(['project', 'user'])->get(); @endphp
            @forelse($allTasks as $task)
            <div class="bg-white/95 p-4 rounded-lg shadow-xs border border-slate-300 searchable-item flex flex-col gap-2">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[10px] text-black font-extrabold uppercase">Projet : {{ $task->project->name ?? 'N/A' }}</span>
                        <h4 class="font-extrabold text-black text-sm mt-0.5">{{ $task->title }}</h4>
                        <p class="text-xs text-black font-semibold mt-0.5">Assigné à : <strong class="text-black font-extrabold">{{ $task->user->name ?? 'Membre' }}</strong></p>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded font-extrabold uppercase border border-slate-300 bg-slate-200 text-black">
                        {{ $task->status }} ({{ $task->progress }}%)
                    </span>
                </div>

                <div class="flex items-center justify-between bg-slate-100 p-2.5 rounded-md border border-slate-300 text-xs mt-1 text-black font-bold">
                    <div>
                        <strong class="text-black font-extrabold uppercase text-[10px]">Livrable soumis :</strong>
                        @if($task->deliverable_file)
                            <a href="{{ route('tasks.download', $task->id) }}" class="inline-flex items-center gap-1 text-black font-extrabold underline ml-2">
                                <span class="material-symbols-outlined text-[14px]">download</span> Télécharger le livrable
                            </a>
                        @else
                            <span class="text-black font-semibold italic ml-2">En attente de livrable</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="text-xs text-black font-extrabold text-center py-4">Aucune tâche enregistrée.</p>
            @endforelse
        </div>
    </section>

    <!-- ================= SECTION 4 : PROJETS CLÔTURÉS ================= -->
    <section id="section-projects-closed" class="dashboard-section hidden flex flex-col gap-space-md">
        <h2 class="text-sm font-extrabold uppercase text-white tracking-wider drop-shadow">Projets avec Tâches Clôturées &amp; Archivés</h2>
        <div class="grid grid-cols-1 gap-3 searchable-container">
            @forelse($projects->where('status', 'cloture') as $proj)
            <div class="bg-white/95 p-4 rounded-lg shadow-xs border border-slate-300 searchable-item flex flex-col gap-2">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-extrabold text-black text-sm">{{ $proj->name }}</h3>
                        <p class="text-xs text-black font-semibold mt-0.5">{{ $proj->description }}</p>
                    </div>
                    <span class="px-2 py-0.5 bg-black text-white text-[11px] rounded font-extrabold uppercase border border-slate-300">Clôturé &amp; Archivé</span>
                </div>
                @if($proj->evaluation_report)
                <div class="mt-2 pt-2 border-t border-slate-300">
                    <a href="{{ asset('storage/' . $proj->evaluation_report) }}" target="_blank" class="text-xs text-black underline font-extrabold inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">description</span> Consulter le rapport d'évaluation final validé
                    </a>
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white/95 p-6 text-center text-black font-extrabold border border-slate-300 rounded-lg">Aucun projet clôturé pour le moment.</div>
            @endforelse
        </div>
    </section>

    <!-- ================= SECTION 5 : ALERTS ================= -->
    <section id="section-alerts" class="dashboard-section hidden flex flex-col gap-space-md">
        <h2 class="text-sm font-extrabold uppercase text-white tracking-wider drop-shadow">Alertes &amp; Demandes de Blocage</h2>
        <p class="text-xs text-black font-bold bg-white/80 p-2 rounded">Messages de demande de blocage liés aux projets envoyés par les membres de l'équipe.</p>

        <div class="flex flex-col gap-3 searchable-container">
            @forelse($blockageAlerts as $alert)
            <div class="bg-white/95 p-4 rounded-lg shadow-xs border border-red-300 searchable-item flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-extrabold text-red-900 uppercase">Projet : {{ $alert->project->name ?? 'N/A' }}</span>
                    <span class="text-[10px] bg-red-100 text-red-900 px-2 py-0.5 rounded font-extrabold uppercase">Signalé bloqué</span>
                </div>
                <h4 class="font-extrabold text-black text-sm">Tâche : {{ $alert->title }}</h4>
                <p class="text-xs text-black font-bold">Membre concerné : <strong class="text-black font-extrabold">{{ $alert->user->name ?? 'Inconnu' }}</strong></p>
                <div class="bg-red-50 p-2.5 rounded-md text-xs text-red-900 font-semibold mt-1 border border-red-200">
                    <strong>Motif du blocage :</strong> "{{ $alert->blockage_reason ?? 'Aucune précision' }}"
                </div>
            </div>
            @empty
            <div class="bg-white/95 p-6 text-center text-black font-extrabold border border-slate-300 rounded-lg">Aucune alerte de blocage active signalée par les équipes.</div>
            @endforelse
        </div>
    </section>

    </div>
    </main>

</div>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.dashboard-section').forEach(el => el.classList.add('hidden'));
    document.getElementById('section-' + tabName).classList.remove('hidden');

    document.querySelectorAll('.nav-tab').forEach(el => {
        el.classList.remove('text-white', 'font-extrabold', 'bg-[#114b24]', 'shadow');
        el.classList.add('text-white/90', 'font-bold');
    });
    const activeNav = document.getElementById('nav-' + tabName);
    if(activeNav) {
        activeNav.classList.add('text-white', 'font-extrabold', 'bg-[#114b24]', 'shadow');
        activeNav.classList.remove('text-white/90', 'font-bold');
    }

    document.querySelectorAll('.mobile-nav-tab').forEach(el => {
        el.classList.remove('text-white', 'font-extrabold', 'bg-[#114b24]', 'shadow');
        el.classList.add('text-white/90', 'font-bold');
    });
    const activeMobileNav = document.getElementById('mobile-nav-' + tabName);
    if(activeMobileNav) {
        activeMobileNav.classList.add('text-white', 'font-extrabold', 'bg-[#114b24]', 'shadow');
        activeMobileNav.classList.remove('text-white/90', 'font-bold');
    }
}

function toggleMobileMenu() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-menu-overlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}

function toggleWizard() {
    const wizard = document.getElementById('wizard-container');
    wizard.classList.toggle('hidden');
    if(!wizard.classList.contains('hidden')) {
        wizard.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleProfileMenu() {
    const menu = document.getElementById('profile-dropdown');
    menu.classList.toggle('hidden');
    document.getElementById('notifications-dropdown').classList.add('hidden');
}

function toggleNotificationsMenu() {
    const menu = document.getElementById('notifications-dropdown');
    menu.classList.toggle('hidden');
    document.getElementById('profile-dropdown').classList.add('hidden');
}

function filterDashboardContent() {
    const query = document.getElementById('global-search').value.toLowerCase();
    const activeSection = document.querySelector('.dashboard-section:not(.hidden)');
    if(!activeSection) return;

    const items = activeSection.querySelectorAll('.searchable-item');
    items.forEach(item => {
        const text = item.innerText.toLowerCase();
        if(text.includes(query)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = startDateInput.value;
            if (endDateInput.value && endDateInput.value < startDateInput.value) {
                endDateInput.value = startDateInput.value;
            }
        });
    }
});
</script>
</body></html>
