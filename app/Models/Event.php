<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    // Définissez les champs autorisés à être massivement assignés
    protected $fillable = [
        'titre',
        'description',
        'date',
        'localisation',
        'image_url'
    ];
    protected $casts = [
        'date' => 'datetime',
    ];
    // Si vous avez des relations, vous pouvez les ajouter ici
    // Par exemple, si un événement est lié à un utilisateur :

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsor');
    }
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

}
