<?php

namespace App\DTO;
use App\Entity\Client;
use App\Entity\Produit;

class PanierDTO
{
    public Produit $produit;
    public int $nombre;
    public Client $client;
}