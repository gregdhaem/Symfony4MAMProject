<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class PaginationService {
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this -> manager = $manager;
        
    }

    public function getPages() {
        // nombre d'enregistrement
        $repo = $this -> manager -> getRepository($this -> entityClass);
        $total = count($repo -> findAll());

        // diviser, arrondir et renvoyer
        $pages = ceil($total / $this -> limit);

        return $pages;
    }

    public function getData() {
        // offset
        $offset = $this -> currentPage * $this -> limit - $this -> limit;

        // demander au repository les éléments
        $repo = $this -> manager -> getRepository($this -> entityClass);
        $data = $repo -> findBy([], [], $this -> limit, $offset);

        // renvoyer les éléments
        return $data;
    }

    public function setPage($page) {
        $this -> currentPage = $page;

        return $this;
    }

    public function getPage() {
        return $this -> currentPage;
    }

    public function setLimit($limit) {
        $this -> limit = $limit;

        return $this;
    }

    public function getLimit() {
        return $this -> limit;
    }

    public function setEntityClass($entityClass) {
        $this -> entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass() {
        return $this -> entityClass;
    }
}

