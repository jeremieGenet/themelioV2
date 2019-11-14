<?php
use App\Connection;

require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = Connection::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE property_category');
$pdo->exec('TRUNCATE TABLE property');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$propertiesId = [];
$categories = [];
for($i=0; $i<50; $i++){
    $pdo->exec("INSERT INTO property SET 

        title = '{$faker->sentence(rand(2, 5), true)}',
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

$rentingsType = ["Location-meublee", "Location-saisonniere", "Location-non-meublee"]; 
for($i=0; $i<count($rentingsType); $i++){
    $pdo->exec("INSERT INTO category SET 
        name =  '{$rentingsType[$i]}',
        slug = 'slug-{$rentingsType[$i]}'
    ");
    $categories[] = $pdo->lastInsertId(); 
}
foreach($propertiesId as $propertyId){
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories))); 
    foreach($randomCategories as $category){
        $pdo->exec("INSERT INTO property_category SET property_id = '$propertyId', category_id = '$category' ");
    }
}
  

