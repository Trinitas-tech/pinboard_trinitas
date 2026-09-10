<?php

namespace App\DataFixtures;

use App\Entity\Pin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['Amina', 'Diallo', 'amina@cfitech.be', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80'],
            ['Lucas', 'Martin', 'lucas@cfitech.be', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80'],
            ['Sarah', 'Bernard', 'sarah@cfitech.be', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80'],
            ['Trinitas', 'Mudeyi', 'trinitas@cfitech.be', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80'],
        ];

        $users = [];
        foreach ($usersData as [$firstname, $lastname, $email, $imageName]) {
            $user = (new User())
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setImageName($imageName)
                ->setIsVerified(true);

            $user->setPassword($this->passwordHasher->hashPassword($user, 'Password123!'));
            $manager->persist($user);
            $users[] = $user;
        }

        $pinsData = [
            ['Salon lumineux', 'Ambiance douce pour un salon moderne et chaleureux.', 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=700&q=80', 3],
            ['Cuisine naturelle', 'Bois clair, plantes et rangements simples.', 'https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=700&q=80', 3],
            ['Coin lecture', 'Un espace calme pour lire et se detendre.', 'https://images.unsplash.com/photo-1519682337058-a94d519337bc?auto=format&fit=crop&w=700&q=80', 3],
            ['Palette graphique', 'Couleurs fortes pour une identite visuelle expressive.', 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=700&q=80', 3],
            ['Bureau minimal', 'Un poste de travail organise et efficace.', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=700&q=80', 3],
            ['Ville au coucher', 'Lumiere urbaine et lignes architecturales.', 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=700&q=80', 3],
            ['Jardin secret', 'Inspiration nature pour un tableau exterieur.', 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=700&q=80', 3],
            ['Moodboard voyage', 'Textures, lumiere et paysages pour preparer une escapade.', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=700&q=80', 3],
            ['Atelier creatif', 'Materiel, croquis et essais de composition.', 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=700&q=80', 3],
            ['Table conviviale', 'Idee de decoration pour recevoir simplement.', 'https://images.unsplash.com/photo-1498654896293-37aacf113fd9?auto=format&fit=crop&w=700&q=80', 3],
            ['Chambre calme', 'Tons apaisants pour une piece reposante.', 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=700&q=80', 3],
            ['Details floraux', 'Une image delicate pour completer un tableau nature.', 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=700&q=80', 3],
        ];

        foreach ($pinsData as [$title, $description, $imageName, $userIndex]) {
            $pin = (new Pin())
                ->setTitle($title)
                ->setDescription($description)
                ->setImageName($imageName)
                ->setUser($users[$userIndex]);

            $manager->persist($pin);
        }

        $manager->flush();
    }
}
