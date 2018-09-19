<?php


namespace App\Service;


use App\Entity\Topping;
use Doctrine\ORM\EntityManagerInterface;

class OptionsService
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @return Topping[]|array
     */
    public function getToppings()
    {
        $topping1 = new Topping();

        $topping1
            ->setId(1)
            ->setName('Supersize')
            ->setType('main');

        $topping2 = new Topping();

        $topping2
            ->setId(2)
            ->setName('Large')
            ->setType('main');

        return [
            $topping1,
            $topping2
        ];


        return $this->em->getRepository(Topping::class)->findAll();
    }

}
