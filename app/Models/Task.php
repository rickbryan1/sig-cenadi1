<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'estimated_days',
        'start_date',
        'due_date',
        'progress',                    // Pourcentage d'avancement (0 à 100)
        'status',                      // en_cours, bloque, en_validation, termine
        'blockage_reason',
        'expected_deliverables_count', // Nombre total de livrables attendus (ex: 3)
        'uploaded_deliverables_count', // Nombre de livrables déjà déposés (ex: 1)
        'deliverable_file',            // Chemin du dernier fichier ou stocké via relation
        'project_id',
        'user_id',                     // Membre assigné (ex: BTS)
    ];

    // Relation avec le projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relation avec le membre assigné
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}