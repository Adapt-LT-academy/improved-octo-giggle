<?php

namespace App\DataFixtures;

use App\Entity\Size;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SizeFixtures extends Fixture{

  public function load(ObjectManager $manager)
  {
    $sizes = [
      [
        'name' => 'S',
        'price' => 200,
      ],
      [
        'name' => 'M',
        'price' => 400,
      ],
      [
        'name' => 'L',
        'price' => 800,
      ],
      [
        'name' => 'XL',
        'price' => 100,
      ],
    ];

    foreach ($sizes as $item) {
      $size = new Size();
      $size->setName($item['name']);
      $size->setPrice($item['price']);
      $manager->persist($size);
    }

    $manager->flush();
  }

}
