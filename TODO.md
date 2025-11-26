# Optimisation de la vitesse du site PHP

## Tâches à effectuer

### 1. Optimisation du .htaccess

- [x] Ajouter la compression gzip/deflate pour les fichiers texte
- [x] Ajouter des headers de cache pour les assets statiques (CSS, JS, images)
- [x] S'assurer que les règles ne cassent pas le développement local (WAMP)

### 2. Optimisation des requêtes SQL

- [x] Remplacer SELECT \* par des colonnes spécifiques dans les modèles
- [x] Ajouter LIMIT aux requêtes de listes où approprié
- [x] Vérifier que les prepared statements sont utilisés partout

### 3. Tests et validation

- [x] Tester le site en local après modifications
- [x] Vérifier que toutes les pages fonctionnent normalement
- [ ] Mesurer les améliorations de performance si possible
