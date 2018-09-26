<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     *
     */
    protected $id;

    /**
     * One Order has One main Topping.
     * @ORM\OneToOne(targetEntity="Topping")
     * @ORM\JoinColumn(name="main_topping_id", referencedColumnName="id")
     */
    protected $mainTopping;

    /**
     * One Order has One secondary Topping.
     * @ORM\OneToOne(targetEntity="Topping")
     * @ORM\JoinColumn(name="secondary_topping_id", referencedColumnName="id")
     */
    protected $secondaryTopping;

    /**
     * One Order has One Size.
     * @ORM\OneToOne(targetEntity="Size")
     * @ORM\JoinColumn(name="size_id", referencedColumnName="id")
     */
    protected $size;

    /**
     * One Order has One Drink.
     * @ORM\OneToOne(targetEntity="Drink")
     * @ORM\JoinColumn(name="drink_id", referencedColumnName="id")
     */
    protected $drink;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=11)
     */
    protected $total = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Topping
     */
    public function getMainTopping(): ?Topping
    {
        return $this->mainTopping;
    }

    /**
     * @param Topping $mainTopping
     *
     * @return $this
     */
    public function setMainTopping(Topping $mainTopping): self
    {
        $this->mainTopping = $mainTopping;

        return $this;
    }

    /**
     * @return Topping
     */
    public function getSecondaryTopping(): ?Topping
    {
      return $this->secondaryTopping;
    }

    /**
     * @param Topping $secondaryTopping
     *
     * @return $this
     */
    public function setSecondaryTopping(Topping $secondaryTopping): self
    {
      $this->secondaryTopping = $secondaryTopping;

      return $this;
    }

    /**
     * @return Size
     */
    public function getSize(): ?Size
    {
      return $this->size;
    }

    /**
     * @param Size $size
     *
     * @return $this
     */
    public function setSize(Size $size): self
    {
      $this->size = $size;

      return $this;
    }

    /**
     * @return Drink
     */
    public function getDrink(): ?Drink
    {
      return $this->drink;
    }

    /**
     * @param Drink $drink
     *
     * @return $this
     */
    public function setDrink(Drink $drink): self
    {
      $this->drink = $drink;

      return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Calculate and set order total using it's products.
     */
    public function calculateTotal() {
      $mainTopping = $this->getMainTopping();
      $secondaryTopping = $this->getSecondaryTopping();
      $size = $this->getSize();
      $drink = $this->getDrink();

      $total =
        $mainTopping->getPrice() +
        $secondaryTopping->getPrice() +
        $size->getPrice() +
        $drink->getPrice();

      $this->setTotal($total);
    }

}
