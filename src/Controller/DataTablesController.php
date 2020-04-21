<?php declare(strict_types=1);


namespace Igornast\DataTables\Controller;

use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Igornast\DataTables\Annotation\DataTables;
use Igornast\DataTables\Exception\DataTablesAnnotationException;
use Igornast\DataTables\Fetcher\DataTablesItemsFetcher;
use Igornast\DataTables\Model\Context\DataTablesContext;
use Igornast\DataTables\Model\ControllerDetail;
use Igornast\DataTables\Service\DataTablesCryptoManager;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\RouterInterface;

class DataTablesController extends AbstractController
{
    /**
     * @var DataTablesContext
     */
    protected DataTablesContext $dataTablesContext;
    /**
     * @var RouterInterface
     */
    private RouterInterface $router;
    /**
     * @var DataTablesItemsFetcher
     */
    private DataTablesItemsFetcher $fetcher;
    /**
     * @var DataTablesCryptoManager
     */
    private DataTablesCryptoManager $cryptoManager;

    public function __construct(DataTablesContext $dataTablesContext, RouterInterface $router, DataTablesItemsFetcher $fetcher, DataTablesCryptoManager $cryptoManager)
    {
        $this->dataTablesContext = $dataTablesContext;
        $this->router = $router;
        $this->fetcher = $fetcher;
        $this->cryptoManager = $cryptoManager;
    }

    /**
     * @return JsonResponse
     * @throws AnnotationException
     * @throws DataTablesAnnotationException
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws ReflectionException
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     */
    public function __invoke()
    {
        if ($this->dataTablesContext->getPathName() !== null) {
            return $this->handleWithAnnotation();
        }

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

    /**
     * @return JsonResponse
     * @throws AnnotationException
     * @throws DataTablesAnnotationException
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws ReflectionException
     */
    private function handleWithAnnotation(): JsonResponse
    {
        /** @var DataTables|null $dataTableAnnotation */
        $dataTableAnnotation = null;
        $route = $this->router->getRouteCollection()->get($this->dataTablesContext->getPathName());

        if ($route === null) {
            throw DataTablesAnnotationException::routeNotFoundException($this->dataTablesContext->getPathName());
        }

        $detail = ControllerDetail::createFromArray(explode('::', $route->getDefault('_controller')));

        $object = new ReflectionClass($detail->getClassName());
        $dataTableAnnotation = $this->getAnnotationFromReflectedMethod($object->getMethod($detail->getMethodName()));

        if ($dataTableAnnotation === null) {
            throw DataTablesAnnotationException::annotationNotFoundException($detail->getClassName());
        }

        if ($dataTableAnnotation->entity === null || $dataTableAnnotation->searchField === null) {
            throw DataTablesAnnotationException::badConfigurationException($detail->getClassName());
        }

        $entity = $dataTableAnnotation->entity;
        $searchField = $dataTableAnnotation->searchField;


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

    /**
     * @param ReflectionMethod $controllerMethod
     * @return DataTables|null
     * @throws AnnotationException
     */
    private function getAnnotationFromReflectedMethod(ReflectionMethod $controllerMethod): ?DataTables
    {
        $annotations = (new AnnotationReader())->getMethodAnnotations($controllerMethod);
        foreach ($annotations as $annotation) {
            if (!$annotation instanceof DataTables) {
                continue;
            }

            return $annotation;
        }

        return null;
    }
}