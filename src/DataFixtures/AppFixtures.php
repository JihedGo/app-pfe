<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Department;
use App\Entity\Salle;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder ;
    const GENDER  = ['male','female'];
    const NIVEAU  = ['Mastere Recherche','Mastere PRO', 'Licence'];
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        
    }
    public function load(ObjectManager $manager)
    {
       
        $this->loadAdmin($manager);
        $this->loadDepts($manager);
        $this->loadClasse($manager);
        $this->loadSalles($manager);
        $manager->flush();
    }

    public function loadAdmin(ObjectManager $manager){
        $admin = new User();
        $faker = Factory::create();
        $admin->setRole("ROLE_AGENT")
              ->setEmail("11111111")
              ->setTel($faker->phoneNumber)
              ->setFirstName($faker->firstName)
              ->setLastName($faker->lastName)
              ->setGender(self::GENDER[rand(0,1)])
              ->setCin("00000000")
              ->setEmailAddress($faker->email)
              ->setPassword($this->encoder->encodePassword($admin, "secret#123"))
              ->setAddress($faker->address)
              ;
        $manager->persist($admin);
    }

    public function loadDepts(ObjectManager $manager){
        for ($i=1; $i <= 12 ; $i++) {
            $dept = new Department();
            $this->setReference("dept_$i", $dept); 
            $dept->setLabel("Departement $i");
            $manager->persist($dept);
        }
    }

    public function loadClasse(ObjectManager $manager){
        for ($i=1; $i <= 20 ; $i++) { 
            $classe = new Classe();
            $classe->setDepartment($this->getReference("dept_".rand(1,12)));
            $classe->setLabel("Classe $i");
            $classe->setNiveau(self::NIVEAU[rand(0,2)]);
            $manager->persist($classe);
        }
    }

    public function loadSalles(ObjectManager $manager){
        for ($i=1; $i <= 20 ; $i++) { 
            $salle = new Salle();
            $salle->setLabel("SALLE $i");
            $salle->setIsDispo(true);
            $manager->persist($salle);
        }
    }
}
