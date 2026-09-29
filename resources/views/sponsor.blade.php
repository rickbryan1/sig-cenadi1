<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Portail Sponsor</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-cenadi.jpg') }}">
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
<body class="bg-slate-100 font-sans text-slate-900 flex flex-col min-h-screen">

<!-- HEADER EN VERT -->
<header class="fixed top-0 w-full z-50 bg-green-600 text-white shadow-md">
    <div class="h-16 px-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileMenu()" class="md:hidden w-9 h-9 flex items-center justify-center text-white hover:bg-green-700 rounded-lg">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            <img src="{{ asset('images/logo-cenadi.jpg') }}" alt="Logo CENADI" class="h-10 w-auto object-contain rounded bg-white p-0.5">
            <div class="flex flex-col">
                <span class="text-[10px] text-white uppercase font-bold tracking-wider">CENADI-Douala | SIG-Projets</span>
                <span class="text-sm font-bold text-white">Sponsor ({{ $user->name }})</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" id="global-search" placeholder="Rechercher..." class="hidden sm:block text-xs px-3 py-1.5 bg-white text-slate-900 border border-slate-300 rounded-lg focus:outline-none" onkeyup="filterSponsorContent()">
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
        <span class="text-[11px] font-bold uppercase text-slate-700 tracking-wider mb-3 px-2">Navigation</span>
        <nav class="flex flex-col gap-1">
            <button class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-green-700 font-bold bg-green-50 text-xs text-left border border-green-200">
                <span class="material-symbols-outlined text-lg">fact_check</span><span>Projets &amp; Validations</span>
            </button>
        </nav>
    </aside>

    <main class="flex flex-col w-full md:ml-64 p-6 gap-6">
        @if(session('success'))
        <div class="p-3 bg-emerald-100 border-l-4 border-green-600 text-emerald-900 rounded text-xs font-bold">{{ session('success') }}</div>
        @endif

        <div class="bg-white p-6 rounded-xl border border-slate-300 shadow-sm">
            <span class="text-xs text-slate-700 uppercase font-extrabold">MINFI / DGI • Maîtrise d'Ouvrage</span>
            <h2 class="text-xl font-extrabold text-slate-900 mt-1">Portail Commanditaire &amp; Tutelle</h2>
            <p class="text-xs text-slate-700 mt-0.5 font-semibold">Validation des Projets Soumis par le Comité de Pilotage</p>
        </div>

        <div class="flex flex-col gap-4 searchable-container">
            @forelse($projects ?? [] as $proj)
            <div class="bg-white p-5 rounded-xl border border-slate-300 shadow-sm border-l-4 border-green-600 searchable-item flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-1 bg-amber-100 text-amber-900 text-[11px] font-bold uppercase rounded-md border border-amber-300">
                        Statut : {{ str_replace('_', ' ', strtoupper($proj->status)) }}
                    </span>
                    <span class="text-xs text-slate-800 font-semibold">Chef de projet : <strong class="text-slate-900">{{ $proj->user->name ?? 'N/A' }}</strong></span>
                </div>

                <div>
                    <h3 class="text-base font-extrabold text-slate-900">{{ $proj->name }}</h3>
                    <p class="text-xs text-slate-700 mt-1 font-medium">{{ $proj->description }}</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-slate-50 p-3 rounded-lg border border-slate-200 text-xs font-semibold">
                    <div><span class="text-slate-600 block">Budget Alloué</span><strong class="text-green-700">{{ number_format($proj->budget_allocated, 0, ',', ' ') }} FCFA</strong></div>
                    <div><span class="text-slate-600 block">Période</span><strong class="text-slate-900">{{ $proj->start_date }} ➜ {{ $proj->end_date }}</strong></div>
                    <div><span class="text-slate-600 block">Équipe</span><strong class="text-slate-900">{{ $proj->members->count() }} assignés</strong></div>
                </div>

                @if($proj->status == 'en_attente_validation')
                <div class="flex gap-3 pt-3 border-t border-slate-200">
                    <form action="{{ route('sponsor.validate', $proj->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold uppercase rounded-lg shadow-sm">Valider la Planification</button>
                    </form>
                    <form action="{{ route('sponsor.reject', $proj->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase rounded-lg shadow-sm">Rejeter</button>
                    </form>
                </div>
                @elseif($proj->status == 'en_attente_evaluation')
                <div class="flex flex-col gap-3 pt-3 border-t border-slate-200">
                    <a href="{{ route('projects.downloadEvaluation', $proj->id) }}" class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-900 text-xs py-2 px-4 rounded-lg font-bold border border-slate-300">
                        <span class="material-symbols-outlined text-base">download</span> Télécharger le rapport d'évaluation final
                    </a>
                    <div class="flex gap-3">
                        <form action="{{ route('sponsor.rejectEval', $proj->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-red-600 text-white text-xs font-bold uppercase rounded-lg">Rejeter le Rapport</button>
                        </form>
                        <form action="{{ route('sponsor.close', $proj->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-green-600 text-white text-xs font-bold uppercase rounded-lg shadow-sm">Valider &amp; Clôturer</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white p-8 text-center text-slate-600 rounded-xl border border-slate-300 font-semibold">Aucun projet en attente de validation.</div>
            @endforelse
        </div>
    </main>
</div>
</body>
</html>
