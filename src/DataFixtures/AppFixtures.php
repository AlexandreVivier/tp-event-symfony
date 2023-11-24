<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Category;
use App\Entity\Event;
use App\Entity\User;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $this->loadCategories($manager);
        $users = $this->loadUsers($manager);

        for ($i = 1; $i <= 10; $i++) {
            $event = $this->createEvent();

            // On donne une catégorie au hasard dans la liste des catégories à l'article
            $event->setCategory($categories[array_rand($categories)])
                ->setUser($users[array_rand($users)]);

            $manager->persist($event);
        }

        $manager->flush();
    }

    
    /**
     * @param ObjectManager $manager
     * @return Category[]
     */
    public function loadCategories(ObjectManager $manager): array
    {
        // Liste des titres de catégories
        $categories = [
            'Cinéma',
            'Musique',
            'Festif',
            'Théatre',
            'Jeux',
            'Sport',
            'Livre/Mangas',
            'Autres'
        ];

        // Tableau qui contient des instances de catégories
        return array_map(function ($categoryName) use ($manager) {
            $category = $this->createCategory($categoryName);
            $manager->persist($category);
            return $category;
        }, $categories);
    }

    public function createCategory(string $categoryName): Category
    {
        $category = new Category();
        $category->setName($categoryName);
        return $category;
    }

    /**
     * @param ObjectManager $manager
     * @return User[]
     */
    public function loadUsers(ObjectManager $manager): array
    {
        $userEmail = [
            [
                'email' => 'user1@gmail.com',
                'name' => 'user1',
                'password' => 'user1',                
            ],
            [
                'email' => 'user2@gmail.com',
                'name' => 'user2',
                'password' => 'user2',
            ],
            [
                'email' => 'user3@gmail.com',
                'name' => 'user3',
                'password' => 'user3',
            ]
        ];

        return array_map(function ($userEmail) use ($manager) {
            $user = $this->createUser($userEmail);
            $manager->persist($user);
            return $user;
        }, $userEmail);

    }

    public function createUser(array $userEmail): User
    {
        $user = new User();
        $user->setEmail($userEmail['email']);
        $user->setName($userEmail['name']);
        $user->setPassword($userEmail['password'])
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ;
        return $user;
    }

public function createEvent(): Event
{
    $event = new Event();
    $event->setTitle($this->faker->sentence(3))
        ->setDescription($this->faker->paragraph(3))
        ->setStartAt($this->faker->dateTimeBetween('now', '+1 year'))
        ->setCreatedAt(new \DateTimeImmutable())
        ->setUpdatedAt(new \DateTimeImmutable())
        ->setCategory($this->getReference(Category::class . '_' . $this->faker->numberBetween(0, 6)))
        ->setUser($this->getReference(User::class . '_' . $this->faker->numberBetween(0, 2)))
        ;
    return $event;
}

}
