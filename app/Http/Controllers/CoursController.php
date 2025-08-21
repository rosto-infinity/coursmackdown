<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class CoursController extends Controller
{
    public function index()
    {
        $chemin = resource_path("markdown/cours");
        $fichiers = collect(File::files($chemin))
            ->filter(fn($f) => $f->getExtension() === 'md')
            ->map(fn($f) => [
                'slug' => pathinfo($f->getFilename(), PATHINFO_FILENAME),
                'titre' => ucfirst(pathinfo($f->getFilename(), PATHINFO_FILENAME))
            ])
            ->values();

        return Inertia::render('Cours/Index', [
            'cours' => $fichiers
        ]);
    }

    public function show($nomCours)
    {
        $chemin = resource_path("markdown/cours/{$nomCours}.md");
        if (!file_exists($chemin)) {
            abort(404);
        }
        $contenu = file_get_contents($chemin);
        $titre = ucfirst($nomCours);

        // Récupérer la liste des cours pour le sommaire
        $cheminListe = resource_path("markdown/cours");
        $cours = collect(File::files($cheminListe))
            ->filter(fn($f) => $f->getExtension() === 'md')
            ->map(fn($f) => [
                'slug' => pathinfo($f->getFilename(), PATHINFO_FILENAME),
                'titre' => ucfirst(pathinfo($f->getFilename(), PATHINFO_FILENAME))
            ])
            ->values();

        return Inertia::render('Cours/Show', [
            'titre' => $titre,
            'contenu' => $contenu,
            'cours' => $cours
        ]);
    }
}
