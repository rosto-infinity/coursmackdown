# Fonctions en PHP

Les fonctions permettent de regrouper du code réutilisable et d’organiser un programme.

## Déclaration d’une fonction

```php
<?php
function direBonjour($nom) {
    return "Bonjour, $nom !";
}

echo direBonjour("Alice"); // Affiche Bonjour, Alice !
?>
```

## Fonction avec valeur par défaut

```php
<?php
function saluer($nom = "inconnu") {
    return "Salut, $nom !";
}

echo saluer(); // Affiche Salut, inconnu !
?>
```

## Fonction anonyme

```php
<?php
$addition = function($a, $b) {
    return $a + $b;
};

echo $addition(2, 3); // Affiche 5
?>
```

## Passage par référence

```php
<?php
function ajouterPointExclamation(&$texte) {
    $texte .= "!";
}

$message = "Bravo";
ajouterPointExclamation($message);
echo $message; // Affiche Bravo!
?>
```
