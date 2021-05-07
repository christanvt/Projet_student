# ECF - Part 1 - Projet student - BDD

## Install

### Clone and install required packages :

    git clone https://github.com/christanvt/Projet_student.git
    cd Projet_student
    composer install

### Configure database access (change db_user and db_password to your needs) :

    echo "APP_ENV=dev" > .env.local
    echo "# APP_DEBUG=0" > .env.local
    echo "APP_SECRET=secret" >> .env.local
    echo "DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/Projet_student" >> .env.local

### Create database :

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

### Load required fixtures :

    php bin/console doctrine:fixtures:load required

## Test fixtures

### Load test fixtures :

    php bin/console doctrine:fixtures:load
