# Objectifs

Créer un module Biens (biens immobilier) pour le rendre sous forme d'une annonce

- Créer la table properties (entité qui représente les biens)
- Remplir biens de fasses données (librairie 'fzaninotto/faker')
- Lister les annonces (une annonce = un bien simplifié en terme de caractèristiques) sur la page de garde
- Créer une pagination pour les annonces (réutilisable pour l'ensemble du site)
- Page présentation d'une annonce (bouton voir +) qui affiche le détail complet de l'annonce (avec classes energétiques, surface...)
- Créer une url Administration (accessible via '/admin' uniquement);
- Administration d'une annonce (création, modification, et suppression d'une annonce)

- Module categories (En cours...)


# Pour lancer le projet :

php -S localhost:8000 -t public

# Outils installés :

- prod : altorouter = librairie router

- dev : fzaninotto/faker = librairie de fausses données
- dev : var_dumper = librairie qui permet un affichage propre des tableaux, objets...
- dev : whoops = librairie d'aide à l'affichage et au débug des erreurs