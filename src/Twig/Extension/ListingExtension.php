<?php declare(strict_types=1);


namespace Igornast\DataTables\Twig\Extension;


use Igornast\DataTables\Listing\Listing;
use Igornast\DataTables\Twig\Renderer\ListingRenderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ListingExtension extends AbstractExtension
{
    /**
     * @var ListingRenderer
     */
    private $renderer;

    public function __construct(ListingRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('igornast_listing', function (Listing $listing) {
                return $this->renderer->render($listing->getTemplate(), $listing);
            },  ['is_safe' => ['html']]),
        ];
    }
}