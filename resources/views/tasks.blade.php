<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CENADI-Douala | Espace Membre</title>
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
                <span class="text-sm font-extrabold text-black">Espace Membre ({{ $user->name }})</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" id="global-search" placeholder="Filtrer les tâches..." class="hidden sm:block text-xs px-3 py-1.5 bg-slate-100 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-corporate-600 font-bold text-black" onkeyup="filterMemberTasks()">
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
                <span class="material-symbols-outlined text-lg">task_alt</span><span>Mes Tâches &amp; Livrables</span>
            </button>
        </nav>
    </aside>

    <main class="flex flex-col w-full md:ml-64 p-6 gap-6">
        <div class="bg-white/95 p-6 rounded-xl border border-slate-300 shadow-sm flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-black border border-slate-300">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <span class="text-xs text-black font-extrabold uppercase">Développeur / Analyste Systèmes</span>
                        <h2 class="text-base font-extrabold text-black">{{ $user->name }}</h2>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-900 text-xs font-extrabold rounded-full">Actif</span>
            </div>
            
            <div class="grid grid-cols-3 gap-3 pt-2">
                <div class="p-3 bg-slate-100 rounded-lg border border-slate-300">
                    <span class="text-xs text-black font-bold">En cours</span>
                    <div class="text-lg font-extrabold text-black mt-0.5">{{ $tasks->where('status', 'en_cours')->count() }}</div>
                </div>
                <div class="p-3 bg-slate-100 rounded-lg border border-slate-300">
                    <span class="text-xs text-black font-bold">Terminées</span>
                    <div class="text-lg font-extrabold text-black mt-0.5">{{ $tasks->where('status', 'termine')->count() }}</div>
                </div>
                <div class="p-3 bg-red-100 rounded-lg border border-red-300">
                    <span class="text-xs text-red-900 font-extrabold">Bloquée</span>
                    <div class="text-lg font-extrabold text-red-800 mt-0.5">{{ $tasks->where('status', 'bloque')->count() }}</div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="p-3 bg-emerald-100 border-l-4 border-corporate-600 text-emerald-900 rounded text-xs font-extrabold">{{ session('success') }}</div>
        @endif

        <div class="flex flex-col gap-4 searchable-container">
            <h3 class="text-sm font-extrabold uppercase text-white tracking-wider drop-shadow">Matrice Opérationnelle &amp; Livrables</h3>
            
            @forelse($tasks as $task)
            <div class="bg-white/95 p-5 rounded-xl border border-slate-300 shadow-sm searchable-item flex flex-col gap-4 border-l-4 border-corporate-600">
                <div class="flex justify-between items-center">
                    <span class="px-2.5 py-0.5 bg-slate-200 text-black text-[11px] font-extrabold uppercase rounded">{{ $task->project->name ?? 'Projet CENADI' }}</span>
                    <span class="text-xs text-black font-bold">Échéance : {{ $task->due_date ?? 'Non défini' }}</span>
                </div>
                <div>
                    <h4 class="text-base font-extrabold text-black">{{ $task->title }}</h4>
                    <p class="text-xs text-black font-medium mt-1">{{ $task->description }}</p>
                </div>
                
                <div class="grid grid-cols-3 gap-2 bg-slate-100 p-3 rounded-lg border border-slate-300 text-xs text-black font-semibold">
                    <div><span class="text-black font-bold block">Durée</span><strong class="text-black">{{ $task->estimated_days ?? 1 }} jours</strong></div>
                    <div><span class="text-black font-bold block">Livrables</span><strong class="text-black">{{ $task->uploaded_deliverables_count }} / {{ $task->expected_deliverables_count }}</strong></div>
                    <div><span class="text-black font-bold block">Statut</span><span class="font-extrabold uppercase text-black">{{ $task->status }}</span></div>
                </div>

                <div class="flex flex-col gap-1">
                    <div class="flex justify-between text-xs text-black font-bold">
                        <span>Progression technique</span>
                        <span class="font-extrabold text-black">{{ $task->progress }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden border border-slate-300">
                        <div class="bg-corporate-600 h-2 transition-all" style="width: {{ $task->progress }}%;"></div>
                    </div>
                </div>

                @if($task->status != 'termine')
                <div class="flex flex-col gap-3 pt-3 border-t border-slate-300">
                    <form action="{{ route('tasks.upload', $task->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                        @csrf
                        <input type="file" name="deliverable_file" required class="text-xs text-black font-bold file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-slate-200">
                        <button type="submit" class="bg-corporate-600 hover:bg-corporate-700 text-white text-xs px-4 py-2 font-extrabold uppercase rounded-lg shadow-sm">Téléverser le Livrable</button>
                    </form>
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="flex gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="blockage_reason" placeholder="Motif du blocage..." class="flex-1 bg-slate-100 border border-slate-300 px-3 py-2 text-xs rounded-lg text-black font-semibold">
                        <button type="submit" class="bg-red-100 text-red-900 hover:bg-red-200 text-xs px-3 py-2 font-extrabold uppercase rounded-lg border border-red-300">Signaler un Blocage</button>
                    </form>
                </div>
                @else
                <div class="p-3 bg-emerald-100 text-emerald-900 text-xs font-extrabold rounded-lg text-center">Tâche clôturée avec succès.</div>
                @endif
            </div>
            @empty
            <div class="bg-white/95 p-8 text-center text-black font-bold rounded-xl border border-slate-300">Aucune tâche assignée.</div>
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
