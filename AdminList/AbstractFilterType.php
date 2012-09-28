<?php

namespace Kunstmaan\AdminListBundle\AdminList;

use Symfony\Component\HttpFoundation\Request;

use Kunstmaan\AdminListBundle\AdminList\FilterTypeInterface;

/**
 * AbstractFilterType
 *
 * Abstract base class for all admin list filters
 */
abstract class AbstractFilterType implements FilterTypeInterface
{
    protected $columnName = null;
    protected $alias = null;

    /**
     * @param string $columnName The column name
     * @param string $alias      The alias
     */
    public function __construct($columnName, $alias = 'b')
    {
        $this->columnName = $columnName;
        $this->alias      = $alias;
    }

    /**
     * @param Request $request  The request
     * @param array   &$data    The data
     * @param string  $uniqueId The unique identifier
     */
    abstract public function bindRequest(Request $request, array &$data, $uniqueId);

    /**
     * @param array  $data     Data
     * @param string $uniqueId The identifier
     */
    abstract public function apply($data, $uniqueId);

    /**
     * @return string
     */
    abstract public function getTemplate();
}