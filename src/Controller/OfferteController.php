<?php

namespace Veldsink\EventSourcing\Controller;

use Symfony\Component\Uid\Uuid;
use Twig\Environment;
use Veldsink\EventSourcing\Offerte\Model\Offerte;
use Veldsink\EventSourcing\Offerte\Model\ProductType;
use Veldsink\EventSourcing\Offerte\Repository\EventSourcedOfferteRepository;

class OfferteController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly EventSourcedOfferteRepository $offerteRepository,
    ) {}

    public function getOfferte(Uuid $offerteUuid)
    {
        $offerte = $this->offerteRepository->getOfferte($offerteUuid);
        return $this->twig->render('offerte.twig', [
            'offerte' => $offerte,
        ]);
    }

    public function createOfferte()
    {
        $relatieUuid = Uuid::v4();
        $offerte = Offerte::create($relatieUuid);
        $inboedelProductUuid = $offerte->addProduct(
            ProductType::INBOEDEL,
            100,
        );
        $motorVoertuigProductUuid = $offerte->addProduct(
            ProductType::MOTORVOERTUIG,
            50,
        );
        $offerte->removeProduct($inboedelProductUuid);
        $offerte->changeProduct($motorVoertuigProductUuid, 200);

        $this->offerteRepository->save($offerte);

        return $this->twig->render('offerte_created.twig', [
            'uuid' => $offerte->domainUuid,
        ]);
    }
}