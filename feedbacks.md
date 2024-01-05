# Review mini projet

## Global

* 🟧 Penser aux typage de retour (`PHPStan`)

  * AuthController::[doLogin](app/Http/Controllers/AuthController.php#L21)

  * RoleController::[destroy](app/Http/Controllers/RoleController.php#L114)

  * UserController::[viewPDF](app/Http/Controllers/UserController.php#L115)

  * Movie::[celebrities](app/Models/Movie.php#L12)

## Celebrity

### Migration

* 🟦 Tu peux utiliser `foreignId` ou `foreignIdFor` pour te simplifié la vie (Mais en vrai, c'est niquel comme ça)

### Controller

* 🟧 Évite les middleware dans les Controller, il est préférable de les avoir dans les routes

### Service

* 🟧 Le service doit être dissocié de toute contexte : Pas de notion de `Request`, `Format retour` (ex: Json), `Code HTTP` ou `Permission`. Le service peut être appelé depuis un controller web, un controller api ou une commande. Il ne doit donc jamais utiliser de notions de contexte mais simplement utiliser les informations en entrée et sortir des infos quasi "brut" (Généralement des objects) ou throw des `Exceptions`.

### Factory

* 🟦 Pourquoi utiliser `??=` au lieu de `??` ici :

    ```php
    [
        /** ... */
        'password' => static::$password ??= Hash::make('password'),
    ]
    ```

## Gestion de permission

* 🟩 Globalement très bien géré, ça vient d'un tuto/une doc spatie ?
