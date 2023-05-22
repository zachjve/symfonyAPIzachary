## Étape 1 : : Connexion à l'API

#### Créer un utilisateur 


Note : Toutes les entrées JSON se font dans le corps de la requête (Body > Raw dans Postman).

Pour créer un utilisateur, utilisez la méthode POST à l'adresse suivante : http://localhost:8000/register

Exemple de requête :

```json
{ // remplacer tata par ce que vous voulez
    "name": "tata",
    "password": "tata"
} 
```

Réponse attendue :

```json
{ // code HTTP 201 created
	"status": "User created successfully",
	"user": "tata"
}
```

#### Se connecter

Pour vous connecter et obtenir un token, utilisez la méthode POST à l'adresse suivante : http://localhost:8000/login_check

Notez que vous devez remplacer "name" par "username" dans le corps de la requête et préciser JSON et non text.

Exemple de requête :

```json
{ // remplacer tata votre user et votre mdp
    "username": "tata",
    "password": "tata"
} 
```

Réponse attendue : 

```json
{ // votre token 
	"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzZ3PAuag[...]"
}
```

Copiez le token pour l'utiliser dans vos requêtes ultérieures.

## Étape 2 : Utilisation de l'API

#### Faire les requêtes

Important : Pour chaque requête, vous devez ajouter un en-tête avec la clé "Authorization" et la valeur "Bearer {votre-token}".

Voici les routes disponibles :

GET /api/animals : Récupérer tous les animaux.
GET /api/animals/{id} : Récupérer un animal spécifique en fonction de son identifiant.
GET /api/animals/{id}/country : Récuperer tout les animaux en fonction de leur pays.

POST /api/animals/ : Créer un nouvel animal.
```json 
{ // Dans body raw rentrer ce genre d'input 
    "name": "Crocodile",
    "averageSize": 5,
    "country": {
        "id": 24 // Mettre un id de ville valide
    },
    "averageLifespan": 1000,
    "martialArt": "Karate",
    "phoneNumber": "+33 (0)2 22 22 22 22"
}
```

PUT /api/animals/{id} : Modifier un animal existant.
```json
{ // Dans body raw rentrer ce genre d'input
    "name": "Zach",
    "averageSize": 5,
    "country": {
        "id": 24 // Mettre un id de ville valide
    },
    "averageLifespan": 999,
    "martialArt": "Boxe",
    "phoneNumber": "+33 (0)6 41 80 20 46"
}
```

PATCH /api/animals/{id}/country : Modifier uniquement le pays d'un animal.
Exemple de requête :
```json
{ // Dans body raw rentrer ce genre d'input
    "country": {
        "id": 25 // Mettre un id de ville valide
    }
}
```

DELETE /api/animals/{id} : Supprimer un animal en fonction de son identifiant.

Note : pour toutes ces requêtes, remplacez {id} par l'identifiant de l'animal et utilisez un identifiant de pays valide pour les requêtes impliquant un pays.