<?php declare(strict_types=1);


namespace Igornast\DataTables\Twig\Renderer;


use Igornast\DataTables\Listing\Listing;
use Twig\Environment;

class ListingRenderer
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $template, Listing $listing): string
    {
        return $this->twig->render($template, ['listing' => $listing]);
    }
}