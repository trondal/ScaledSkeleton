<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="album")
 */
class Album {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=250, nullable=false)
     */
    private $title;

    public function __construct($name) {
        $this->title = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }
}