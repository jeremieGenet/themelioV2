<?php
namespace App;

use PDO;
use App\URL;
use App\Connection;

class PaginatedQuery{

    private $query;
    private $queryCount;
    private $pdo;
    private $perPage;
    private $count; 
    private $items; 

    public function __construct(
        string $query,
        string $queryCount,
        ?\PDO $pdo = null, 
        int $perPage = 8
    )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO(); 
        $this->perPage = $perPage;
    }

    public function getItems(string $classMapping)
    {
        if($this->items === null){
            $currentPage = $this->getCurrentPage(); 
            $pages = $this->getPages();
            if($currentPage > $pages){
                throw new \Exception('Cette page n\'existe pas ! Votre base de donnée est peut-être vide, dans ce cas il faut la remplir.');
            }

            $offset = $this->perPage * ($currentPage - 1);

            return $this->items = $this->pdo->query(
                $this->query .
                " LIMIT {$this->perPage} OFFSET $offset"
            )->fetchAll(PDO::FETCH_CLASS, $classMapping);
        }
    }

    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        
        if($currentPage <= 1) return null;

        if($currentPage > 2) $l = $link .= '?page=' . ($currentPage - 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-info">&laquo; Page précédente</a>
HTML;
    }

    public function nextLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage(); 
        $pages = $this->getPages();
        if($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-info ml-auto">Page suivante &raquo;</a>
HTML;
    }

    public function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    public function getPages()
    {
        if($this->count === null){
            $this->count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->perPage);
    }


}