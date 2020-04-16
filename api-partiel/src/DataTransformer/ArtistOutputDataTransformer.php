<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\ArtistOutput;
use App\Entity\Artist;
use DateTime;

final class ArtistOutputDataTransformer implements DataTransformerInterface
{
  public function supportsTransformation($data, string $to, array $context = []): bool
  {
    return $data instanceof Artist && $to === ArtistOutput::class;
  }

  public function transform($object, string $to, array $context = [])
  {
    if (!$object instanceof Artist) {
      return;
    }

    $output = new ArtistOutput();
    $numberFans  = $object->getUsers()->toArray();
    $numberAlbums[] = $object->getAlbum();


    $output->id = $object->getId();
    $output->name = $object->getName();
    $output->albumNumber = count($numberAlbums);
    $output->fansNumbers = count($numberFans);
    $output->startedYear = $object->getStartYear();
    $output->styles = $object->getStyles();
    return $output;




  }
}
