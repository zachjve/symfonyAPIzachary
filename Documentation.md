## Étape 1 

Mon API s'utilise avec une connection 
#### Créer un utilisateur 

**Toutes les entrées en json ce font dans body puis raw**

_method POST_ : http://localhost:8000/register

```json
{ // remplacer tata par ce que vous voulez
    "name": "tata",
    "password": "tata"
} 
```

Voici le retour attendu : 

```json
{ // code 201 created
	"status": "User created successfully",
	"user": "tata"
}
```

Verifier la connction pour obtenir son token
#### Se connecter

_method POST_ : http://localhost:8000/login_check

**Bien mettre json en text**
**Bien mettre username a la place de name**

```json
{ // remplacer tata votre user et votre mdp
    "username": "tata",
    "password": "tata"
} 
```

Voici le retour attendu : 
_Copier votre token (bien le garder pour la suite)

```json
{ // votre token 
	"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzZ3PAuag[...]"
}
```

#### Faire les requêtes

**Obligatoire pour l'api !**
Aller dans Headers et rentrer :

Dans _"Key"_ : `Authorization`
Dans _"Value"_ : `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1[....]` (votre token)``

Voici toutes les routes : 

GET /api/animals (Avoir tout les animaux)

GET /api/animals/id (Avoir un animal en focntion de son id)

POST /api/animals/ (Créer un nouvel animal) 

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

PUT /api/animals/id (Modifier un animal existant)

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

PATCH /api/animals/id/country (Modifier uniquement le pays)

```json
{ // Dans body raw rentrer ce genre d'input
    "country": {
        "id": 25 // Mettre un id de ville valide
    }
}
```

DELETE /api/animals/
