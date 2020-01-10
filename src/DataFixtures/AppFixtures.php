<?php

namespace App\DataFixtures;

use App\Entity\Agglomeration;
use App\Entity\Building;
use App\Entity\Map;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $mapNameList;
    private $biomeList;
    private $universeTypes;
    private $interestPoints;
    private $agglomerationNameList;
    private $leaderNames;
    private $buildingFunction;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->mapNameList = [
            'Oldmallow', 'Mallowmere', 'Silverspell', 'Lakeholt', 'Morham', 'Marbleland', 'Dorburn', 'Wildedell', 'Marshhedge', 'Lightbourne',
            'Deepwynne', 'Norcrest', 'Bushmoor', 'Falconhurst', 'Greencoast', 'Bushston', 'Westbeech', 'Oldmarsh', 'Strongwynne', 'Starryness'
        ];
        $this->biomeList = ['Forêt', 'Plaine', 'Montagne', 'Prairie', 'Désert'];
        //Universe Types: 
        //1 = 'Fantasy', 2 = 'PostApo', 3 = 'Contemporain'
        $this->universeTypes = [1, 2, 3];
        $this->interestPoints = [
            'Draguizon', 'Bergelogne', 'Rouçon', 'Frénoît', 'Frénesse', 'Besanluçon', 'Panoît', 'Aurilès', 'Gremasse', 'Monttou',
            'Béçon', 'Soimont', 'Antollon', 'Bounnet', 'Mausir', 'Marmomble', 'Levaluçon', 'Beaucourt', 'Champiluire', 'Aurizon'
        ];
        $this->agglomerationNameList = [
            'Shimmervault', 'Stillhorn', 'Heartbay', 'Sandmond', 'Castlechill', 'Dimhallow', 'Autumnbell', 'Demonlight', 'Demonside', 'Ravenvalley',
            'Shadowcairn', 'Northbourne', 'Starhall', 'Embergrove', 'Shadevale', 'Coldfalls', 'Snowvault', 'Chillbreach', 'Quickfort', 'Eaglecairn'
        ];
        $this->leaderNames = [
            'Goreu Gaynor', 'Hywel Lewis', 'Baglen Mattocks', 'Gwent Pride', 'Cadog Esau', 'Morgan Stant', 'Mal Brys', 'Maldwyn Days', 'Dai Wynn', 'Mal Arthur',
            'Ffraid Hanmer', 'Buddug Floyd', 'Lynne Bethell', 'Derwen Baughan', 'Eiluned Glasco', 'Iona Crowder', 'Buddug Cornog', 'Olwen Tudor', 'Eirian Cadogan', 'Elwyn Morgan'
        ];
        $this->buildingFunction = [
            'Mairie', 'Bibliothèque', 'Caserne', 'Boutique Alchimie', 'Boutique Armes', 'Boutique Armure', 'Boutique Tissus', 'Hopital'
        ];
    }

    public function load(ObjectManager $manager)
    {

        $user = new User();
        // ...
        $user->setUsername('kuro');
        $user->setEmail('kuromail@kuro-testmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'mdp'
        ));
        $manager->persist($user);


        foreach ($this->buildingFunction as $function) {

            $building = new Building();
            $building->setName($function);
            $building->setFunction($function);
            $building->setSize(random_int(1,5));
            $building->setLeader(array_rand($this->leaderNames, 1));

        }
        $manager->persist($building);

        foreach ($this->agglomerationNameList as $aggloname) {
            $agglomeration = new Agglomeration();
            $agglomeration->setName($aggloname);
            $agglomeration->setSize(random_int(1, 5));
            $agglomeration->setLeader(array_rand($this->leaderNames, 1));
            $agglomeration->addBuilding($building);
        }

        $manager->persist($agglomeration);



        foreach ($this->mapNameList as $name) {
            $map = new Map();
            $map->setName($name);
            $map->setBiomes([array_rand($this->biomeList, 2)]);
            $map->setUniverseType(array_rand($this->universeTypes, 1));
            $map->setInterestPoints([array_rand($this->interestPoints, 3)]);
            $map->setUser($user);
            $map->addAgglomeration($agglomeration);


            $manager->persist($map);

            $manager->flush();
        }

    }
}
