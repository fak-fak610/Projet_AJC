# TODO pour l'ajout des exigences de mot de passe dans l'inscription

- [x] Ajouter un indice visuel dans view/inscription.php sous le champ mot de passe pour informer l'utilisateur des exigences (au moins 8 caractères, un chiffre, un symbole).
- [x] Modifier controller/InscriptionController.php pour ajouter la validation côté serveur du mot de passe dans la méthode register(), en vérifiant les critères et en affichant des erreurs si nécessaire.
- [x] Tester l'inscription pour s'assurer que la validation fonctionne correctement et que les erreurs sont affichées.
