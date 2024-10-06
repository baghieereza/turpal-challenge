<?php

namespace HeavenlyTours\Contracts;

interface HeavenlyToursApiInterface
{
    public function getTours();
    public function getTourDetails(string $id);
    public function getPricePerDate($date);
    public function getAvailability(int $id ,$date);
}
