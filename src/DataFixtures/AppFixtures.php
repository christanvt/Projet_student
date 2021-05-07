<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\SchoolYear;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = \Faker\Factory::create('fr_FR');

        $user = new User();

        $firstname = 'Foo';
        $lastname = 'Foo';
        $email = 'foo.foo@example.com';
        $roles = ["ROLE_ADMIN"];
        $password = $this->encoder->encodePassword($user, '123');
        $phone = null;

        $user->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPhone($phone)
            ->setRoles($roles)
            ->setPassword($password);

        $this->manager->persist($user);
        $this->manager->flush();

        $this->loadUser(60, "ROLE_STUDENT");
        $this->loadUser(5, "ROLE_TEACHER");
        $this->loadUser(15, "ROLE_CLIENT");

        $this->loadProject(20);

        $this->loadSchoolYear(3);

        $this->loadUserSchoolYearRelation(3);
    }

    public function loadUser(int $count, string $role): void
    {
        for ($i = 0; $i < $count; $i++) {
            $user = new User();

            $firstname = $this->faker->firstName();
            $lastname = $this->faker->lastName();
            $email = strtolower($firstname) . '.' . strtolower($lastname) . '-' . $i . '@example.com';
            $roles = [$role];
            $password = $this->encoder->encodePassword($user, '123');

            $phone = $this->faker->phoneNumber();

            $user->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setPhone($phone)
                ->setRoles($roles)
                ->setPassword($password);

            $this->manager->persist($user);
        }

        $this->manager->flush();
    }
    public function loadProject(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $name = $this->faker->realText(10);
            $description = null;

            if (random_int(1, 100) <= 25) {
                $description = $this->faker->realText(200);
            }

            $project = new Project();
            $project->setName($name)
                ->setDescription($description);

            $this->manager->persist($project);
        }

        $this->manager->flush();
    }

    public function loadSchoolYear(int $count): void
    {
        $year = 2020;

        for ($i = 0; $i < $count; $i++) {
            $name = $this->faker->realText(10);
            $dateStart = new DateTime();
            $dateEnd = new DateTime();

            if ($i % 2 == 0) {
                $dateStart->setDate($year, 1, 1);
                $dateEnd->setDate($year, 6, 30);
            } else {
                $dateStart->setDate($year, 7, 1);
                $dateEnd->setDate($year, 12, 31);
            }

            if ($i % 2 != 0) {
                $year++;
            }

            $schoolYear = new SchoolYear();
            $schoolYear->setName($name)
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd);

            $this->manager->persist($schoolYear);
        }

        $this->manager->flush();
    }

    public function loadUserSchoolYearRelation(int $countSchoolYear): void
    {
        $schoolYearRepository = $this->manager->getRepository(SchoolYear::class);
        $userRepository = $this->manager->getRepository(User::class);

        $schoolYears = $schoolYearRepository->findAll();

        $users = $userRepository->findAll();
        $students = array_filter($users, function ($user) {
            return in_array('ROLE_STUDENT', $user->getRoles());
        });

        foreach ($students as $i => $student) {
            $remainder = $i % $countSchoolYear;
            $student->setSchoolYear($schoolYears[$remainder]);

            $this->manager->persist($student);
        }

        $this->manager->flush();
    }
}
