<?php declare(strict_types=1);


namespace Igornast\DataTables;


use Igornast\DataTables\DependencyInjection\IgornastDataTablesExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IgornastDataTablesBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new IgornastDataTablesExtension();
    }
}