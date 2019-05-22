<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ProduceItem {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;
    /**
     * @ORM\Column(type="datetime")
     */
    private $expirationDate;
    /**
     * One ProduceItem has One Icon.
     * @ORM\OneToOne(targetEntity="Icon")
     * @ORM\JoinColumn(name="image", referencedColumnName="image")
     */
    private $image;
    /**
     * @ORM\Column(type="boolean")
     */
    private $in_shopping_list;

    function __construct($name, $expirationDate, $image, $in_shopping_list) {
        $this->name = $name;
        $this->expirationDate = $expirationDate;
        $this->image = $image;
        $this->in_shopping_list = $in_shopping_list;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getExpirationDate() {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate) {
        $this->expirationDate = $expirationDate;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getInShoppingList() {
        return $this->in_shopping_list;
    }

    public function setInShoppingList($in_shopping_list) {
        $this->in_shopping_list = $in_shopping_list;
    }

}
