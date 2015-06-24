<?php

namespace Trinix\Pagination;

use \PDO;
use Pagerfanta\Exception\InvalidArgumentException;
use Pagerfanta\Adapter\AdapterInterface;

/**
 * @author Werik Leandro <erick.leandro.lima@hotmail>
 * @author Eduardo Borges <eduardomrb@gmail.com>
 */

class PDOAdapter implements AdapterInterface
{
    private $query;
    private $pdo;

    /**
     * Constructor.
     *
     * @param query $query              Query SQL.
     * @param pdo     PDO instance
     */
    public function __construct($query, PDO $pdo)
    {
        $this->query = $query;
        $this->pdo = $pdo;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        $stm = $this->pdo->prepare($this->query);
        $stm->execute() or die(var_dump($stm->errorInfo()));
        $result = count($stm->fetchAll());
        $stm->closeCursor();
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        $qb = $this->query;
        $stm = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        $stm->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stm->bindValue(':length', $length, PDO::PARAM_INT);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        $stm->closeCursor();
        return $data;
    }
}
