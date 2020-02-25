<?php declare(strict_types=1);


namespace Igornast\DataTables\Model\Context;


use Igornast\DataTables\Model\DataTablesColumn;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class DataTablesContext implements DataTablesContextInterface
{
    /**
     * @var int
     */
    private $draw;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var DataTablesColumn[]
     */
    private $columns;
    /**
     * @var int[]
     */
    private $columnsSortOrder;
    /**
     * @var string
     */
    private $search;

    /**
     * @var string
     */
    private $pathName;

    public function __construct(RequestStack $request)
    {
        $this->initialize($request->getCurrentRequest());
    }

    private function initialize(Request $request): void
    {
        $this->columns = [];
        $this->draw = $request->request->getInt('draw', 0);
        $this->offset = $request->request->getInt('start', 0);
        $this->limit = $request->request->getInt('length', 0);
        $this->pathName = $request->request->get('path_name', null);

        $columns = $request->request->get('columns', []);
        $order = $request->request->get('order', []);

        if (is_array($columns)) {
            $this->columns = $this->handleColumns($columns, $order);
        }

        $search = $request->request->get('search', []);
        $this->search = $search['value'] ?? '';
    }

    private function handleColumns(array $columns, array $order): array
    {
        $result = [];
        $sort = [];
        foreach ($order as $item) {
            $this->columnsSortOrder[] = (int)$item['column'];
            $sort[(int)$item['column']] = $item['dir'];
        }


        foreach ($columns as $idx => $column) {
            $data = $column['data'] ?? null;

            if (!is_string($data)) {
                continue;
            }

            $name = $column['name'] ?? '';
            $search = $column['search']['value'] ?? '';
            $columnSort = $sort[$idx] ?? null;

            $result[] = DataTablesColumn::create($idx, $data, $name, $search, $columnSort);
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getDraw(): int
    {
        return $this->draw;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @return string
     */
    public function getPathName(): string
    {
        return $this->pathName;
    }

    /**
     * @return DataTablesColumn[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getSortArray(): array
    {
        $columnsSort = [];
        $items = [];

        foreach ($this->columns as $column) {
            if ($column->getSort() === null) {
                continue;
            }

            $columnsSort[$column->getId()] = [$column->getField() => $column->getSort()];
        }

        foreach ($this->columnsSortOrder as $pos => $columnIdx) {
            $items = array_merge($items, $columnsSort[$columnIdx]);
        }

        return $items;
    }
}