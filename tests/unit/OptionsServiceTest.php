<?php

namespace App\Tests\unit;

use App\Entity\Topping;
use App\Service\OptionsService;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class OptionsServiceTest extends TestCase
{

    public function testGetToppings()
    {
        $topping1 = new Topping();

        $topping1
            ->setId(1)
            ->setName('Supersize')
            ->setType('main');

        $toppingRepository = Mockery::mock(ObjectRepository::class);
        $toppingRepository = $toppingRepository->expects('findAll')->atLeast()->once()->andReturn([$topping1])->getMock(
        );

        $objectManager = Mockery::mock(EntityManagerInterface::class);
        $objectManager = $objectManager->expects('getRepository')
            ->atLeast()
            ->once()
            ->andReturn($toppingRepository)
            ->getMock();

        $optionsService = new OptionsService($objectManager);

        self::assertInternalType('array', $optionsService->getToppings());
    }
}
