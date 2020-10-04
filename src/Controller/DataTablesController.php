<?php declare(strict_types=1);


namespace Igornast\DataTables\Controller;

use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Igornast\DataTables\Fetcher\DataTablesItemsFetcher;
use Igornast\DataTables\Model\Context\DataTablesContext;
use Igornast\DataTables\Service\DataTablesCryptoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\RouterInterface;

class DataTablesController extends AbstractController
{
    /**
     * @var DataTablesContext
     */
    protected $dataTablesContext;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var DataTablesItemsFetcher
     */
    private $fetcher;
    /**
     * @var DataTablesCryptoManager
     */
    private $cryptoManager;

    public function __construct(DataTablesContext $dataTablesContext, RouterInterface $router, DataTablesItemsFetcher $fetcher, DataTablesCryptoManager $cryptoManager)
    {
        $this->dataTablesContext = $dataTablesContext;
        $this->router = $router;
        $this->fetcher = $fetcher;
        $this->cryptoManager = $cryptoManager;
    }

    /**
     * @return JsonResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     */
    public function __invoke()
    {
        $searchField = $this->dataTablesContext->getMainSearchField();
        $entity = $this->cryptoManager->decrypt($this->dataTablesContext->getEncryptedEntity());

        $items = $this->fetcher->findByContext($entity, $this->dataTablesContext, $searchField);
        $filtered = $this->fetcher->countByContext($entity, $this->dataTablesContext, $searchField);
        $total = $this->fetcher->countTotalEntityItems($entity);

        return new JsonResponse([
            'draw' => $this->dataTablesContext->getDraw(),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $items
        ]);
    }
}