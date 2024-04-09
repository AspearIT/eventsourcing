<?php


use Symfony\Component\Uid\Uuid;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Veldsink\EventSourcing\Controller\OfferteController;
use Veldsink\EventSourcing\EventStorage;
use Veldsink\EventSourcing\Offerte\Repository\EventSourcedOfferteRepository;

require __DIR__ . '/../vendor/autoload.php';

$twig = new Environment(new FilesystemLoader(__DIR__ . '/../view'));

$controller = new OfferteController(
    $twig,
    new EventSourcedOfferteRepository(
        new EventStorage(),
    ),
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
