<?php

namespace Drupal\pokemon_block\Controller;

use Drupal\Core\Controller\ControllerBase;

class PokemonController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    );
  }

}