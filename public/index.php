<?php


use Symfony\Component\Uid\Uuid;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Veldsink\EventSourcing\Controller\OfferteController;
use Veldsink\EventSourcing\Eventbus;
use Veldsink\EventSourcing\EventStorage;
use Veldsink\EventSourcing\Offerte\Repository\EventSourcedOfferteRepository;
use Veldsink\EventSourcing\Resource\ProductRapportage\Listener\ProductRapportageListener;
use Veldsink\EventSourcing\Resource\ProductRapportage\Repository\ProductRepository;

require __DIR__ . '/../vendor/autoload.php';

$twig = new Environment(new FilesystemLoader(__DIR__ . '/../view'));

$controller = new OfferteController(
    $twig,
    new EventSourcedOfferteRepository(
        new EventStorage(),
        new Eventbus(
            new ProductRapportageListener(),
        ),
    ),
    new ProductRepository(),
);

try {
    $path = $_SERVER['REQUEST_URI'];
    switch ($path) {
        case '/':
            echo 'Hello, world!';
            break;
        case '/offerte/init':
            $response = $controller->createOfferte();
            break;
        case '/product/rapportage':
            $response = $controller->getProductRapportage();
            break;
        default:
            if (preg_match('#offerte/([a-f0-9-]+)#', $path, $matches)) {
                $response = $controller->getOfferte(Uuid::fromString($matches[1]));
            } else {
                http_response_code(404);
                $response = 'Not found';
            }
            break;
    }

    die($response);
} catch (Throwable $e) {
    die(nl2br((string) $e));
}
