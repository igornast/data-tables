<?php declare(strict_types=1);


namespace Igornast\DataTables\Fetcher;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Igornast\DataTables\Model\Context\DataTablesContext;
use PDO;

/**
 * Class DataTablesItemsFetcher
 * @package Igornast\DataTables\Fetcher
 */
class DataTablesItemsFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DataTablesItemsFetcher constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $entity
     * @param DataTablesContext $context
     * @param string|null $mainSearchField
     * @return array
     */
    public function findByContext(string $entity, DataTablesContext $context, ?string $mainSearchField = null): array
    {
        $qb = $this->em->createQueryBuilder()
            ->select($this->generateSelect($context, 'i'))
            ->from($entity, 'i')
            ->setMaxResults($context->getLimit())
            ->setFirstResult($context->getOffset());

        foreach ($context->getSortArray() as $columnSort) {
            $qb->addOrderBy(sprintf('i.%s', $columnSort->getField()), $columnSort->getOrder());
        }

        $this->addLike($qb, $context, $mainSearchField);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $entity
     * @param DataTablesContext $context
     * @param string|null $mainSearchField
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByContext(string $entity, DataTablesContext $context, ?string $mainSearchField = null): int
    {
        $qb = $this->em->createQueryBuilder()->from($entity, 'i');

        $qb->select($qb->expr()->count('i'));
        $this->addLike($qb, $context, $mainSearchField);

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param string $entity
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countTotalEntityItems(string $entity): int
    {
        $qb = $this->em->createQueryBuilder()->from($entity, 'i');
        $qb->select($qb->expr()->count('i'));

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    private function generateSelect(DataTablesContext $context, string $alias): string
    {
        $select = '';

        foreach ($context->getColumns() as $idx => $column) {
            if ($idx === 0) {
                $select = sprintf('%s.%s', $alias, $column->getPropertyName());
                continue;
            }

            $select = sprintf('%s, %s.%s', $select, $alias, $column->getPropertyName());
        }

        return $select;
    }

    /**
     * @param QueryBuilder $qb
     * @param DataTablesContext $context
     * @param string|null $mainSearchField
     */
    private function addLike(QueryBuilder $qb, DataTablesContext $context, ?string $mainSearchField): void
    {
        if ($context->getSearch() !== null && $mainSearchField !== null) {
            $qb->where(sprintf('i.%s LIKE :txt', $mainSearchField))
                ->setParameter('txt', sprintf('%%%s%%', $context->getSearch()), PDO::PARAM_STR);
        }
    }
}