<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * Many Orders has One main Topping.
     * @ORM\ManyToOne(targetEntity="Topping")
     * @ORM\JoinColumn(name="main_topping_id", referencedColumnName="id")
     */
    protected $mainTopping;

    /**
     * Many Orders has One secondary Topping.
     * @ORM\ManyToOne(targetEntity="Topping")
     * @ORM\JoinColumn(name="secondary_topping_id", referencedColumnName="id")
     */
    protected $secondaryTopping;

    /**
     * Many Orders has One Size.
     * @ORM\ManyToOne(targetEntity="Size")
     * @ORM\JoinColumn(name="size_id", referencedColumnName="id")
     */
    protected $size;

    /**
     * Many Orders have Many Drinks.
     * @ORM\ManyToMany(targetEntity="Drink")
     * @ORM\JoinTable(name="order_drinks",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="drink_id", referencedColumnName="id")}
     *      )
     */
    protected $drinks;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=11)
     */
    protected $total = 0;

    public function __construct() {
        $this->drinks = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return ArrayCollection
     */
    public function getDrinks(): ?ArrayCollection
    {
      return $this->drinks;
    }

    /**
     * @param Drink $drink
     *
     * @return $this
     */
    public function addDrink(Drink $drink): self
    {
      $this->drinks[] = $drink;

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
      $drinks = $this->getDrinks();
      $drinkPrices = 0;
      foreach ($drinks as $drink) {
          $drinkPrices += $drink->getPrice();
      }

      $total =
        $mainTopping->getPrice() +
        $secondaryTopping->getPrice() +
        $size->getPrice() +
        $drinkPrices;

      $this->setTotal($total);
    }

}
