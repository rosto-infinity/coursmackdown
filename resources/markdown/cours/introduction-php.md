# Introduction à PHP

- PHP est un langage de script côté serveur principalement utilisé pour le développement web.

```html
<template>
  <div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Liste des cours</h1>
    <ul class="space-y-2">
      <li v-for="c in cours" :key="c.slug">
        <Link
          :href="route('cours.show', c.slug)" prefetch
          class="block px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded"
        >
          {{ c.titre }}
        </Link>
      </li>
    </ul>
  </div>
</template>
```

```📁 public
├── 📁 brand
│   ├── 🖼️ logo.svg
│   ├── 🖼️ favicon.svg
│   ├── 🖼️ background.jpg
│   └── 📼 trailer.mp4
├── 📁 css
```
## Controllers
```php
const __sfc__ = {
  __name: 'App',
  setup(__props) {

  const msg = ref('hello')

  return (_ctx, _cache) => {
    return (_openBlock(), _createElementBlock(_Fragment, null, [
      _createElementVNode("h1", null, _toDisplayString(msg.value), 1 /* TEXT */),
      _withDirectives(_createElementVNode("input", {
        "onUpdate:modelValue": _cache[0] || (_cache[0] = $event => ((msg).value = $event))
      }, null, 512 /* NEED_PATCH */), [
        [_vModelText, msg.value]
      ])
    ], 64 /* STABLE_FRAGMENT */))
  }
}
}
```

## Controllers

```php
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
        return Inertia::render('Cours/Show', [
            'titre' => $titre,
            'contenu' => $contenu
        ]);
    }
}
?>
```
## Exemple de code

```php
<?php
echo "Hello, world!";
?>
```

```php
<?php
echo "Hello, world!";
?>
```
## Exemple de code

```php
<?php
const DB_INFOS = [
	'host'     => '127.0.0.1',
	'port'     => '3306',
	'dbname'   => 'nom_bdd',
	'username' => 'root',
	'password' => ''
];

?>
```
## VUE
```vue
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>
```

## Variables

```php
<?php
// Fichier : connexion_db.php
class Database {
    private $host = 'localhost';
    private $dbname = 'devinsto';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function getConnection() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}

// Utilisation
$db = new Database();
$pdo = $db->getConnection();
?>
```
