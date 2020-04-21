<?php declare(strict_types=1);


namespace Igornast\DataTables\Model\Context;


use Igornast\DataTables\Model\DataTablesColumn;
use Igornast\DataTables\Model\DataTablesColumnSort;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class DataTablesContext implements DataTablesContextInterface
{
    /**
     * @var int
     */
    private int $draw;
    /**
     * @var int
     */
    private int $offset;
    /**
     * @var int
     */
    private int $limit;
    /**
     * @var DataTablesColumn[]
     */
    private array $columns;
    /**
     * @var int[]
     */
    private array $columnsSortOrder;
    /**
     * @var null|string
     */
    private ?string $search;

    /**
     * @var null|string
     */
    private ?string $pathName;

    /**
     * @var string|null
     */
    private ?string  $encryptedEntity;

    /**
     * @var string|null
     */
    private ?string  $mainSearchField;

    public function __construct(RequestStack $request)
    {
        $this->initialize($request->getCurrentRequest());
    }

    private function initialize(Request $request): void
    {
        $this->columns = [];
        $this->columnsSortOrder = [];

        $this->draw = $request->request->getInt('draw', 0);
        $this->offset = $request->request->getInt('start', 0);
        $this->limit = $request->request->getInt('length', 0);
        $this->pathName = $request->request->get('path_name', null);
        $this->encryptedEntity = $request->request->get('entity', null);
        $this->mainSearchField = $request->request->get('main_search_field', null);

        $columns = $request->request->get('columns', []);
        $order = $request->request->get('order', []);

        if (sizeof($columns) > 0) {
            $this->handleSortOrder($order);
            $this->handleColumns($columns);
        }

        $search = $request->request->get('search', []);
        $this->search = $search['value'] ?? null;
    }

    private function handleSortOrder(array $order): void
    {
        foreach ($order as $item) {
            $this->columnsSortOrder[(int)$item['column']] = $item['dir'];
        }
    }

    private function handleColumns(array $columns): void
    {
        foreach ($columns as $idx => $column) {
            $propertyName = $column['data'] ?? null;

            if (!is_string($propertyName)) {
                continue;
            }

            $name = $column['name'] ?? '';
            $search = $column['search']['value'] ?? '';
            $columnOrder = $this->columnsSortOrder[$idx] ?? null;

            $this->columns[$idx] = DataTablesColumn::create($idx, $propertyName, $name, $search, $columnOrder);
        }
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
     * @return null|string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @return null|string
     */
    public function getPathName(): ?string
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

    /**
     * @return string|null
     */
    public function getEncryptedEntity(): ?string
    {
        return $this->encryptedEntity;
    }

    /**
     * @return string|null
     */
    public function getMainSearchField(): ?string
    {
        return $this->mainSearchField;
    }

    /**
     * @return DataTablesColumnSort[]
     */
    public function getSortArray(): array
    {
        $items = [];

        foreach ($this->columnsSortOrder as $pos => $columnIdx) {
            $columnDef = $this->columns[$pos] ?? null;

            if($columnDef === null) {
                continue;
            }

            $items[] = DataTablesColumnSort::create($columnDef->getPropertyName(), $columnDef->getOrder());
        }

        return $items;
    }
}