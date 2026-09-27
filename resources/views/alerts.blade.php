<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Centre des Alertes</title>
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

<header class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur border-b border-slate-200">
    <div class="h-16 px-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="flex flex-col">
                <span class="text-[10px] text-slate-500 uppercase font-semibold tracking-wider">CENADI-Douala | SIG-Projets</span>
                <span class="text-sm font-bold text-slate-900">Centre des Alertes</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-bold uppercase hover:bg-red-100 transition-colors">
                    <span class="material-symbols-outlined text-base">logout</span>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</header>

<main class="flex flex-col w-full pt-20 p-6 max-w-5xl mx-auto gap-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs">{{ $totalAlertsCount ?? 0 }}</span>
            <h2 class="text-base font-bold uppercase tracking-tight text-slate-900">Centre des Alertes (Sécurité &amp; Blocages)</h2>
        </div>
    </div>

    <!-- 1. Réinitialisations -->
    <div class="flex flex-col gap-4">
        <h3 class="text-xs font-bold uppercase text-corporate-600 tracking-wider">1. Demandes de Réinitialisation &amp; Sécurité</h3>
        @forelse($resetRequests ?? [] as $req)
        <article class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col gap-3 border-l-4 border-red-500">
            <div class="flex justify-between items-center text-xs">
                <span class="px-2 py-0.5 bg-red-100 text-red-800 font-bold uppercase rounded">Sécurité • Réinitialisation</span>
                <span class="text-slate-400 font-mono text-[11px]">{{ $req->created_at->diffForHumans() }}</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-900">Demande d'accès pour : {{ $req->email }}</h4>
                <p class="text-xs text-slate-600 mt-1">Motif : <em>{{ $req->reason }}</em></p>
            </div>
            @if($req->document_path)
            <div class="p-3 bg-slate-50 rounded-lg flex items-center justify-between border border-slate-100">
                <span class="text-xs font-semibold text-slate-700">Justificatif d'identité fourni</span>
                <a href="{{ asset('storage/' . $req->document_path) }}" target="_blank" class="px-3 py-1 bg-white text-corporate-600 text-xs font-semibold rounded border border-slate-200 hover:bg-slate-50">Consulter</a>
            </div>
            @endif
            <form action="{{ route('admin.reset.resolve', $req->id) }}" method="POST" class="pt-2">
                @csrf
                <button type="submit" class="w-full py-2.5 bg-corporate-600 hover:bg-corporate-700 text-white text-xs font-bold uppercase rounded-lg shadow-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">key</span> Valider &amp; Transmettre les Nouveaux Accès
                </button>
            </form>
        </article>
        @empty
        <div class="bg-white p-6 rounded-xl border border-slate-200 text-slate-400 text-xs text-center">Aucune demande de réinitialisation en attente.</div>
        @endforelse
    </div>

    <!-- 2. Incidents -->
    <div class="flex flex-col gap-4 mt-4">
        <h3 class="text-xs font-bold uppercase text-corporate-600 tracking-wider">2. Incidents &amp; Blocages Opérationnels</h3>
        @forelse($blockedTasks ?? [] as $task)
        <article class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col gap-3 border-l-4 border-red-500">
            <div class="flex justify-between items-center text-xs">
                <span class="px-2 py-0.5 bg-red-100 text-red-800 font-bold uppercase rounded">Blocage Critique</span>
                <span class="text-slate-400 font-mono text-[11px]">{{ $task->updated_at->diffForHumans() }}</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-900">{{ $task->title }}</h4>
                <p class="text-xs text-slate-600 mt-1">{{ $task->description }}</p>
            </div>
            <div class="p-3 bg-red-50 rounded-lg text-xs text-red-900 border border-red-100">
                <strong>Motif :</strong> "{{ $task->blockage_reason ?? 'Aucune précision' }}"
            </div>
            <div class="flex justify-between text-xs text-slate-500 pt-1">
                <span>Assigné à : <strong>{{ $task->user->name ?? 'Agent' }}</strong></span>
                <span>Projet : <strong>{{ $task->project->name ?? 'Général' }}</strong></span>
            </div>
        </article>
        @empty
        <div class="bg-white p-6 rounded-xl border border-slate-200 text-slate-400 text-xs text-center">Aucun incident de blocage actif.</div>
        @endforelse
    </div>
</main>
</body>
</html>