<?php

namespace App\Dto;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * DTO : Data Transfer Object
 */
final class ArtistOutput
{
    /**
     * @Groups("artist_read")
     */
    public $id;

    /**
     * @Groups("artist_read")
     */
    public $name;


    /**
     * @Groups("artist_read")
     */
    public $albumNumber;

    /**
     * @Groups("artist_read")
     */
    public $fansNumbers;

    /**
     * @Groups("artist_read")
     */
    public $startedYear;


    /**
     * @Groups("artist_read")
     */
    public $styles;

}

