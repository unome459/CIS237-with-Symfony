<?php

namespace App\Entity;

class Task {

    private $description;
    private $dueDate;

    function __construct($description, $dueDate) {
        $this->description = $description;
        $this->dueDate = $dueDate;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDueDate() {
        return $this->dueDate;
    }

    public function setDueDate($dueDate) {
        $this->dueDate = $dueDate;
    }
}