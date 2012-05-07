<?php

namespace Kunstmaan\AdminListBundle\AdminList\FilterDefinitions;

class NumberFilterType
{

    protected $columnname = null;

    function __construct($columnname)
    {
        $this->columnname = $columnname;
    }

    function bindRequest($request, &$data, $uniqueid)
    {
        $data['comparator'] = $request->query->get("filter_comparator_" . $uniqueid);
        $data['value'] = $request->query->get("filter_value_" . $uniqueid);
        $value2 = $request->query->get("filter_value2_" . $uniqueid);
        if (isset($value2))
            $data['value2'] = $request->query->get("filter_value2_" . $uniqueid);
    }

    function adaptQueryBuilder($querybuilder, &$expressions, $data, $uniqueid)
    {
        $prefix = '';
        if (!strpos($this->columnname, '.')) {
            $prefix = 'b.';
        }
        if (isset($data['value']) && isset($data['comparator'])) {
            switch ($data['comparator']) {
            case "eq":
                $expressions[] = $querybuilder->expr()->eq($prefix . $this->columnname, "?" . $uniqueid);
                break;
            case "neq":
                $expressions[] = $querybuilder->expr()->neq($prefix . $this->columnname, "?" . $uniqueid);
                break;
            case "lt":
                $expressions[] = $querybuilder->expr()->lt($prefix . $this->columnname, "?" . $uniqueid);
                break;
            case "lte":
                $expressions[] = $querybuilder->expr()->lte($prefix . $this->columnname, "?" . $uniqueid);
                break;
            case "gt":
                $expressions[] = $querybuilder->expr()->gt($prefix . $this->columnname, "?" . $uniqueid);
                break;
            case "gte":
                $expressions[] = $querybuilder->expr()->gte($prefix . $this->columnname, "?" . $uniqueid);
                break;
            case "isnull":
                $expressions[] = $querybuilder->expr()->isNull($prefix . $this->columnname);
                return;
            case "isnotnull":
                $expressions[] = $querybuilder->expr()->isNotNull($prefix . $this->columnname);
                return;
            }

            $querybuilder->setParameter($uniqueid, $data['value']);
        }
    }

    function getTemplate()
    {
        return "KunstmaanAdminListBundle:Filters:numberfilter.html.twig";
    }
}