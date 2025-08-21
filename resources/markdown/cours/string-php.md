# Fonctions de manipulation de chaînes en PHP

PHP propose de nombreuses fonctions pour travailler avec les chaînes de caractères.

## Exemple : strlen

```php
<?php
$texte = "Bonjour";
echo strlen($texte); // Affiche 7
?>
```

## Exemple : strtoupper

```php
<?php
$texte = "bonjour";
echo strtoupper($texte); // Affiche BONJOUR
?>
```

## Exemple : substr

```php
<?php
$texte = "Bonjour";
echo substr($texte, 0, 3); // Affiche Bon
?>
```

## Exemple : str_replace

```php
<?php
$texte = "Bonjour le monde";
echo str_replace("monde", "PHP", $texte); // Affiche Bonjour le PHP
?>
```
