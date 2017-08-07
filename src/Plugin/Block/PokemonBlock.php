<?php

namespace Drupal\pokemon_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "pokemon_block",
 *   admin_label = @Translation("Pokemon block"),
 *   category = @Translation("Pokemon"),
 * )
 */
class PokemonBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => $this->t('Hello, World!'),
    );
  }
}