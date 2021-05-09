# ECF - Part 1 à Part 3 - Projet student

## ECF - Part 1 - Projet student - BDD

### Install

#### Clone and install required packages :

    git clone https://github.com/christanvt/Projet_student.git
    cd Projet_student
    composer install

#### Configure database access (change db_user and db_password to your needs) :

    echo "APP_ENV=dev" > .env.local
    echo "# APP_DEBUG=0" > .env.local
    echo "APP_SECRET=secret" >> .env.local
    echo "DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/Projet_student" >> .env.local

#### Create database :

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

#### Load required fixtures :

    php bin/console doctrine:fixtures:load required

### Test fixtures

#### Load test fixtures :

    php bin/console doctrine:fixtures:load

## ECF - Part 2 - Projet student - Composants d'accès aux données

### start the web server :

    cd Projet_student
    symfony server:start

### Url for data access :

#### Users :

[user index](http://127.0.0.1:8000/user/)

[user Id=1](http://127.0.0.1:8000/user/1)

[user index for roles 'ROLE_ADMIN'](http://127.0.0.1:8000/user/admin)

#### School years :

[School year index](http://127.0.0.1:8000/school_year/)

[School year Id=1](http://127.0.0.1:8000/school_year/1)

#### Projects :

[Project index](http://127.0.0.1:8000/project/)

[Project Id=1](http://127.0.0.1:8000/project/1)

## ECF - Part 3 - Projet student - Back-end

### Url for data access :

[Login Page](http://127.0.0.1:8000/login/)
