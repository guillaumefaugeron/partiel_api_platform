<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\UserOutput;
use App\Entity\User;
use DateTime;

final class UserOutputDataTransformer implements DataTransformerInterface
{
  public function supportsTransformation($data, string $to, array $context = []): bool
  {
    return $data instanceof User && $to === UserOutput::class;
  }

  public function transform($object, string $to, array $context = [])
  {
    if (!$object instanceof User) {
      return;
    }

    $output = new UserOutput();
    $artistsfav  = $object->getArtists()->toArray();
    $output->id = $object->getId();
    $output->email = $object->getEmail();
    $output->artists = $object->getArtists();


    $output->favoriteArtists = count($artistsfav);

    return $output;




  }
}
