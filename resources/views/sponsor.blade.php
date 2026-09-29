<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Portail Sponsor</title>
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
                    colors: { corporate: { 600: '#16a34a', 700: '#15803d' } }
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
<body class="bg-black/30 font-sans text-black font-semibold flex flex-col min-h-screen">

<header class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur border-b border-slate-200">
    <div class="h-16 px-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileMenu()" class="md:hidden w-9 h-9 flex items-center justify-center text-black hover:bg-slate-100 rounded-lg">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            <div class="flex flex-col">
                <span class="text-[10px] text-black font-extrabold uppercase tracking-wider">CENADI-Douala | SIG-Projets</span>
                <span class="text-sm font-extrabold text-black">Sponsor ({{ $user->name }})</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" id="global-search" placeholder="Rechercher..." class="hidden sm:block text-xs px-3 py-1.5 bg-slate-100 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-corporate-600 font-bold text-black" onkeyup="filterSponsorContent()">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Se déconnecter">
                    <span class="material-symbols-outlined text-xl">logout</span>
                </button>
            </form>
        </div>
    </div>
</header>

<div class="flex flex-1 pt-16 min-h-screen">
    <!-- TIROIR DE NAVIGATION EN VERT FONCÉ -->
    <aside class="w-64 border-r border-slate-200 hidden md:flex flex-col p-4 fixed top-16 bottom-0 z-40" style="background-color: #0d5c2e;">
        <span class="text-[11px] font-extrabold uppercase text-white tracking-wider mb-3 px-2">Navigation</span>
        <nav class="flex flex-col gap-1">
            <button class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white font-extrabold bg-[#114b24] text-xs text-left shadow">
                <span class="material-symbols-outlined text-lg">fact_check</span><span>Projets &amp; Validations</span>
            </button>
        </nav>
    </aside>

    <main class="flex flex-col w-full md:ml-64 p-6 gap-6">
        @if(session('success'))
        <div class="p-3 bg-emerald-100 border-l-4 border-corporate-600 text-emerald-900 rounded text-xs font-extrabold">{{ session('success') }}</div>
        @endif

        <div class="bg-white/95 p-6 rounded-xl border border-slate-300 shadow-sm">
            <span class="text-xs text-black font-extrabold uppercase">MINFI / DGI • Maîtrise d'Ouvrage</span>
            <h2 class="text-xl font-extrabold text-black mt-1">Portail Commanditaire &amp; Tutelle</h2>
            <p class="text-xs text-black font-semibold mt-0.5">Validation des Projets Soumis par le Comité de Pilotage</p>
        </div>

        <div class="flex flex-col gap-4 searchable-container">
            @forelse($projects ?? [] as $proj)
            <div class="bg-white/95 p-5 rounded-xl border border-slate-300 shadow-sm border-l-4 border-corporate-600 searchable-item flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-1 bg-amber-100 text-amber-900 text-[11px] font-extrabold uppercase rounded-md">
                        Statut : {{ str_replace('_', ' ', strtoupper($proj->status)) }}
                    </span>
                    <span class="text-xs text-black font-bold">Chef de projet : <strong>{{ $proj->user->name ?? 'N/A' }}</strong></span>
                </div>

                <div>
                    <h3 class="text-base font-extrabold text-black">{{ $proj->name }}</h3>
                    <p class="text-xs text-black font-medium mt-1">{{ $proj->description }}</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-slate-100 p-3 rounded-lg border border-slate-300 text-xs text-black font-semibold">
                    <div><span class="text-black font-bold block">Budget Alloué</span><strong class="text-black">{{ number_format($proj->budget_allocated, 0, ',', ' ') }} FCFA</strong></div>
                    <div><span class="text-black font-bold block">Période</span><strong>{{ $proj->start_date }} ➜ {{ $proj->end_date }}</strong></div>
                    <div><span class="text-black font-bold block">Équipe</span><strong>{{ $proj->members->count() }} assignés</strong></div>
                </div>

                @if($proj->status == 'en_attente_validation')
                <div class="flex gap-3 pt-3 border-t border-slate-300">
                    <form action="{{ route('sponsor.validate', $proj->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2.5 bg-corporate-600 hover:bg-corporate-700 text-white text-xs font-extrabold uppercase rounded-lg shadow-sm">Valider la Planification</button>
                    </form>
                    <form action="{{ route('sponsor.reject', $proj->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2.5 px-4 bg-red-700 hover:bg-red-800 text-white text-xs font-extrabold uppercase rounded-lg shadow-sm">Rejeter</button>
                    </form>
                </div>
                @elseif($proj->status == 'en_attente_evaluation')
                <div class="flex flex-col gap-3 pt-3 border-t border-slate-300">
                    <a href="{{ route('projects.downloadEvaluation', $proj->id) }}" class="inline-flex items-center justify-center gap-2 bg-slate-200 hover:bg-slate-300 text-black text-xs py-2 px-4 rounded-lg font-extrabold">
                        <span class="material-symbols-outlined text-base">download</span> Télécharger le rapport d'évaluation final
                    </a>
                    <div class="flex gap-3">
                        <form action="{{ route('sponsor.rejectEval', $proj->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-red-700 text-white text-xs font-extrabold uppercase rounded-lg">Rejeter le Rapport</button>
                        </form>
                        <form action="{{ route('sponsor.close', $proj->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-corporate-600 text-white text-xs font-extrabold uppercase rounded-lg shadow-sm">Valider &amp; Clôturer</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white/95 p-8 text-center text-black font-bold rounded-xl border border-slate-300">Aucun projet en attente de validation.</div>
            @endforelse
        </div>
    </main>
</div>

<script>
function filterSponsorContent() {
    const query = document.getElementById('global-search').value.toLowerCase();
    document.querySelectorAll('.searchable-item').forEach(item => {
        item.style.display = item.innerText.toLowerCase().includes(query) ? 'flex' : 'none';
    });
}
</script>
</body>
</html>
