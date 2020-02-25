<?php declare(strict_types=1);


namespace Igornast\DataTables\Controller;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Igornast\DataTables\Annotation\DataTables;
use Igornast\DataTables\Exception\DataTablesAnnotationException;
use Igornast\DataTables\Model\Context\DataTablesContext;
use Igornast\DataTables\Model\ControllerDetail;
use Igornast\DataTables\Fetcher\DataTablesItemsFetcher;
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
    protected $dataTablesContext;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var DataTablesItemsFetcher
     */
    private $fetcher;

    public function __construct(DataTablesContext $dataTablesContext, RouterInterface $router, DataTablesItemsFetcher $fetcher)
    {
        $this->dataTablesContext = $dataTablesContext;
        $this->router = $router;
        $this->fetcher = $fetcher;
    }

    /**
     * @return JsonResponse
     * @throws AnnotationException
     * @throws DataTablesAnnotationException
     * @throws ReflectionException
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function __invoke()
    {
        /** @var DataTables|null $dataTableAnnotation */
        $dataTableAnnotation = null;
        $route = $this->router->getRouteCollection()->get($this->dataTablesContext->getPathName());

        if($route === null) {
            throw DataTablesAnnotationException::routeNotFoundException($this->dataTablesContext->getPathName());
        }

        $detail = ControllerDetail::createFromArray(explode('::', $route->getDefault('_controller')));

        $object = new ReflectionClass($detail->getClassName());
        $dataTableAnnotation = $this->getAnnotationFromReflectedMethod($object->getMethod($detail->getMethodName()));

        if ($dataTableAnnotation === null) {
            throw DataTablesAnnotationException::annotationNotFoundException($detail->getClassName());
        }

        if($dataTableAnnotation->entity === null || $dataTableAnnotation->searchField === null) {
            throw DataTablesAnnotationException::badConfigurationException($detail->getClassName());
        }

        $items = $this->fetcher->findByContext($dataTableAnnotation->entity, $this->dataTablesContext, $dataTableAnnotation->searchField);
        $filtered = $this->fetcher->countByContext($dataTableAnnotation->entity, $this->dataTablesContext, $dataTableAnnotation->searchField);
        $total = $this->fetcher->countTotalEntityItems($dataTableAnnotation->entity);

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