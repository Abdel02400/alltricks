# alltricks

- cree un dossier migrations a la racine du projet 
- modifier sur le fichier .env.local votre DATABASE_URL (correspond a la BDD sur laquel on veut se connecter pour recuperer les articles)
- composer install
- npm install
- php bin/console doctrine:database:create
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate
- php bin/console app:create-source-category
- php bin/console app:create-source => (les informations de la BDD doivent etre iso a la bdd sur le fichier .env.local)
- php bin/console app:create-article-category
- php bin/console app:create-article
- php bin/console app:create-stock
- symfony server:start
- npm run dev

allez sur l'url http://localhost:8000