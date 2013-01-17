<?php

namespace Kunstmaan\AdminListBundle\Helper;

use Doctrine\DBAL\Query\QueryBuilder;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Exception\LogicException;

/**
 * DoctrineDBALAdapter.
 *
 * @author Michael Williams <michael@whizdevelopment.com>
 *
 * @api
 */
class DoctrineDBALAdapter implements AdapterInterface
{
    private $queryBuilder;

    private $countField;

    /**
     * Constructor.
     *
     * @param QueryBuilder $queryBuilder A DBAL query builder.
     * @param string $countField Primary key for the table in query. Used in count expression. Must include table alias
     *
     * @api
     */
    public function __construct(QueryBuilder $queryBuilder, $countField)
    {
        if (strpos($countField, '.') === false) {
            throw new LogicException('The $countField must contain a table alias in the string.');
        }

        if (QueryBuilder::SELECT !== $queryBuilder->getType()) {
            throw new LogicException('Only SELECT queries can be paginated.');
        }

        $this->queryBuilder = $queryBuilder;
        $this->countField = $countField;
    }

    /**
     * Returns the query builder.
     *
     * @return QueryBuilder The query builder.
     *
     * @api
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        $query = clone $this->queryBuilder;
        $statement = $query->select('COUNT(DISTINCT '.$this->countField.') AS total_results')
          ->setMaxResults(1)
          ->execute()
        ;

        return ($results = $statement->fetchColumn(0)) ? $results : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        $query = clone $this->queryBuilder;

        $result = $query->setMaxResults($length)
          ->setFirstResult($offset)
          ->execute()
        ;

        return $result->fetchAll();
    }
}