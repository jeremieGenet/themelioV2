<?php
/*
    REMPLISSAGE BDD
*/

use App\Connection;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialisation de la librairie Faker (en français)
$faker = Faker\Factory::create('fr_FR');

$pdo = Connection::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0'); 
$pdo->exec('TRUNCATE TABLE property');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1'); 


$propertiesId = [];

for($i=0; $i<50; $i++){
    $pdo->exec("INSERT INTO property SET 

        title = '{$faker->sentence()}',
        slug = '{$faker->slug}',
        address = '{$faker->streetAddress}',
        postalCode = '{$faker->numberBetween(01, 99999)}',
        city = '{$faker->city}',
        description = '{$faker->paragraphs(rand(3, 15), true)}',
        surface='{$faker->numberBetween(12, 500)}',
        nbRoom = '{$faker->numberBetween(2, 10)}',
        energeticClass = '{$faker->randomElement($array = array ('A','B','C','D','E','F','G'))}',
        price = '{$faker->numberBetween(120, 590)}',
        createdAt='{$faker->date} {$faker->time}',
        picture='{$faker->imageUrl(400, 300)}'

    ");
    $propertiesId[] = $pdo->lastInsertId();
}


