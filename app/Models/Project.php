<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'objectives',
        'start_date',
        'end_date',
        'budget_allocated',
        'resources',
        'status',          // brouillon, en_attente_validation, en_cours, rejete, cloture
        'user_id',         // Chef de projet (KIM HYUNG)
        'sponsor_id',
        'evaluation_report',      // Commanditaire (BANGTAN)
    ];

    // Relation avec l'utilisateur (Chef de projet)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec le Sponsor (Commanditaire)
    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    // Relation avec les membres de l'équipe affectés au projet (Table pivot project_user)
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    // Relation avec les tâches du projet
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}