<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Espace Membre</title>
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
                <span class="text-sm font-bold text-white">Espace Membre ({{ $user->name }})</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" id="global-search" placeholder="Filtrer les tâches..." class="hidden sm:block text-xs px-3 py-1.5 bg-white text-slate-900 border border-slate-300 rounded-lg focus:outline-none" onkeyup="filterMemberTasks()">
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
                <span class="material-symbols-outlined text-lg">task_alt</span><span>Mes Tâches &amp; Livrables</span>
            </button>
        </nav>
    </aside>

    <main class="flex flex-col w-full md:ml-64 p-6 gap-6">
        <div class="bg-white p-6 rounded-xl border border-slate-300 shadow-sm flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-green-700 border border-slate-300">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <span class="text-xs text-slate-700 uppercase font-bold">Développeur / Analyste Systèmes</span>
                        <h2 class="text-base font-extrabold text-slate-900">{{ $user->name }}</h2>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-extrabold rounded-full">Actif</span>
            </div>
            
            <div class="grid grid-cols-3 gap-3 pt-2">
                <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                    <span class="text-xs text-slate-700 font-semibold">En cours</span>
                    <div class="text-lg font-extrabold text-green-700 mt-0.5">{{ $tasks->where('status', 'en_cours')->count() }}</div>
                </div>
                <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                    <span class="text-xs text-slate-700 font-semibold">Terminées</span>
                    <div class="text-lg font-extrabold text-slate-900 mt-0.5">{{ $tasks->where('status', 'termine')->count() }}</div>
                </div>
                <div class="p-3 bg-red-50 rounded-lg border border-red-200">
                    <span class="text-xs text-red-900 font-bold">Bloquée</span>
                    <div class="text-lg font-extrabold text-red-700 mt-0.5">{{ $tasks->where('status', 'bloque')->count() }}</div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="p-3 bg-emerald-100 border-l-4 border-green-600 text-emerald-900 rounded text-xs font-bold">{{ session('success') }}</div>
        @endif

        <div class="flex flex-col gap-4 searchable-container">
            <h3 class="text-sm font-extrabold uppercase text-slate-900 tracking-wider">Matrice Opérationnelle &amp; Livrables</h3>
            
            @forelse($tasks as $task)
            <div class="bg-white p-5 rounded-xl border border-slate-300 shadow-sm searchable-item flex flex-col gap-4 border-l-4 border-green-600">
                <div class="flex justify-between items-center">
                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-900 text-[11px] font-bold uppercase rounded border border-slate-200">{{ $task->project->name ?? 'Projet CENADI' }}</span>
                    <span class="text-xs text-slate-800 font-semibold">Échéance : {{ $task->due_date ?? 'Non défini' }}</span>
                </div>
                <div>
                    <h4 class="text-base font-extrabold text-slate-900">{{ $task->title }}</h4>
                    <p class="text-xs text-slate-700 mt-1 font-medium">{{ $task->description }}</p>
                </div>
                
                <div class="grid grid-cols-3 gap-2 bg-slate-50 p-3 rounded-lg border border-slate-200 text-xs font-semibold">
                    <div><span class="text-slate-600 block">Durée</span><strong class="text-slate-900">{{ $task->estimated_days ?? 1 }} jours</strong></div>
                    <div><span class="text-slate-600 block">Livrables</span><strong class="text-green-700">{{ $task->uploaded_deliverables_count }} / {{ $task->expected_deliverables_count }}</strong></div>
                    <div><span class="text-slate-600 block">Statut</span><span class="font-bold uppercase text-slate-900">{{ $task->status }}</span></div>
                </div>

                <div class="flex flex-col gap-1">
                    <div class="flex justify-between text-xs text-slate-800 font-bold">
                        <span>Progression technique</span>
                        <span class="text-green-700">{{ $task->progress }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div class="bg-green-600 h-2 transition-all" style="width: {{ $task->progress }}%;"></div>
                    </div>
                </div>

                @if($task->status != 'termine')
                <div class="flex flex-col gap-3 pt-3 border-t border-slate-200">
                    <form action="{{ route('tasks.upload', $task->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                        @csrf
                        <input type="file" name="deliverable_file" required class="text-xs text-slate-800 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-slate-200 file:font-bold">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 font-bold uppercase rounded-lg shadow-sm">Téléverser le Livrable</button>
                    </form>
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="flex gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="blockage_reason" placeholder="Motif du blocage..." class="flex-1 bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-lg text-slate-900 font-medium">
                        <button type="submit" class="bg-red-50 text-red-700 hover:bg-red-100 text-xs px-3 py-2 font-bold uppercase rounded-lg border border-red-300">Signaler un Blocage</button>
                    </form>
                </div>
                @else
                <div class="p-3 bg-emerald-100 text-emerald-900 text-xs font-bold rounded-lg text-center">Tâche clôturée avec succès.</div>
                @endif
            </div>
            @empty
            <div class="bg-white p-8 text-center text-slate-600 rounded-xl border border-slate-300 font-semibold">Aucune tâche assignée.</div>
            @endforelse
        </div>
    </main>
</div>

<script>
function filterMemberTasks() {
    const query = document.getElementById('global-search').value.toLowerCase();
    document.querySelectorAll('.searchable-item').forEach(item => {
        item.style.display = item.innerText.toLowerCase().includes(query) ? 'flex' : 'none';
    });
}
</script>
</body>
</html>
