<?php

namespace HeavenlyTours;


class HeavenlyToursCredentials
{
    private mixed $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('heavenlyTours.base_url');
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

}
