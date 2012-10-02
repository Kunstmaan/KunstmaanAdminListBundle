<?php

namespace Kunstmaan\AdminListBundle\AdminList\Action;

use Kunstmaan\AdminListBundle\AdminList\Action\ListActionInterface;

/**
 * CsvExportAction
 */
class CsvExportAction implements ListActionInterface
{

    /**
     * @return array
     */
    public function getUrl()
    {
        return array(
            'path'      => 'KunstmaanAdminListBundle_admin_export',
            'params'    => array(
                '_format'   => 'csv'
            )
        );
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Export as CSV';
    }

    /**
     * @return null
     */
    public function getIcon()
    {
        return null;
    }

    /**
     * @return null
     */
    public function getTemplate()
    {
        return null;
    }
}