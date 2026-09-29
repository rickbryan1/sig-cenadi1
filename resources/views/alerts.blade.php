<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Centre des Alertes</title>
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
                <span class="text-sm font-bold text-white">Centre des Alertes</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold uppercase hover:bg-red-700 transition-colors">
                    <span class="material-symbols-outlined text-base">logout</span>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</header>

<main class="flex flex-col w-full pt-20 p-6 max-w-5xl mx-auto gap-6">
    <div class="bg-white p-6 rounded-xl border border-slate-300 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-extrabold text-xs">{{ $totalAlertsCount ?? 0 }}</span>
            <h2 class="text-base font-extrabold uppercase tracking-tight text-slate-900">Centre des Alertes (Sécurité &amp; Blocages)</h2>
        </div>
    </div>

    <!-- 1. Réinitialisations -->
    <div class="flex flex-col gap-4">
        <h3 class="text-xs font-extrabold uppercase text-green-700 tracking-wider">1. Demandes de Réinitialisation &amp; Sécurité</h3>
        @forelse($resetRequests ?? [] as $req)
        <article class="bg-white rounded-xl shadow-sm border border-slate-300 p-5 flex flex-col gap-3 border-l-4 border-red-600">
            <div class="flex justify-between items-center text-xs">
                <span class="px-2 py-0.5 bg-red-100 text-red-900 font-bold uppercase rounded">Sécurité • Réinitialisation</span>
                <span class="text-slate-600 font-mono text-[11px] font-semibold">{{ $req->created_at->diffForHumans() }}</span>
            </div>
            <div>
                <h4 class="font-extrabold text-slate-900">Demande d'accès pour : {{ $req->email }}</h4>
                <p class="text-xs text-slate-700 mt-1 font-medium">Motif : <em>{{ $req->reason }}</em></p>
            </div>
            <form action="{{ route('admin.reset.resolve', $req->id) }}" method="POST" class="pt-2">
                @csrf
                <button type="submit" class="w-full py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold uppercase rounded-lg shadow-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">key</span> Valider &amp; Transmettre les Nouveaux Accès
                </button>
            </form>
        </article>
        @empty
        <div class="bg-white p-6 rounded-xl border border-slate-300 text-slate-600 text-xs text-center font-semibold">Aucune demande de réinitialisation en attente.</div>
        @endforelse
    </div>

    <!-- 2. Incidents -->
    <div class="flex flex-col gap-4 mt-4">
        <h3 class="text-xs font-extrabold uppercase text-green-700 tracking-wider">2. Incidents &amp; Blocages Opérationnels</h3>
        @forelse($blockedTasks ?? [] as $task)
        <article class="bg-white rounded-xl shadow-sm border border-slate-300 p-5 flex flex-col gap-3 border-l-4 border-red-600">
            <div class="flex justify-between items-center text-xs">
                <span class="px-2 py-0.5 bg-red-100 text-red-900 font-bold uppercase rounded">Blocage Critique</span>
                <span class="text-slate-600 font-mono text-[11px] font-semibold">{{ $task->updated_at->diffForHumans() }}</span>
            </div>
            <div>
                <h4 class="font-extrabold text-slate-900">{{ $task->title }}</h4>
                <p class="text-xs text-slate-700 mt-1 font-medium">{{ $task->description }}</p>
            </div>
            <div class="p-3 bg-red-50 rounded-lg text-xs text-red-900 border border-red-200 font-semibold">
                <strong>Motif :</strong> "{{ $task->blockage_reason ?? 'Aucune précision' }}"
            </div>
        </article>
        @empty
        <div class="bg-white p-6 rounded-xl border border-slate-300 text-slate-600 text-xs text-center font-semibold">Aucun incident de blocage actif.</div>
        @endforelse
    </div>
</main>
</body>
</html>
