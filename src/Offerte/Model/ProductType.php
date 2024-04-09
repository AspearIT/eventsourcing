<?php

namespace Veldsink\EventSourcing\Offerte\Model;

enum ProductType: string
{
    case INBOEDEL = 'inboedel';
    case MOTORVOERTUIG = 'motorvoertuig';
}