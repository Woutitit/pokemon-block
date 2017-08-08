<?php

namespace Drupal\pokemon_block\Plugin\Block;

use GuzzleHttp\Client;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "pokemon_block",
 *   admin_label = @Translation("Pokemon block"),
 *   category = @Translation("Pokemon"),
 * )
 */
class PokemonBlock extends BlockBase implements ContainerFactoryPluginInterface
{
	/**
   	* @var \GuzzleHttp\Client
   	*/
	private $http_client;


  public function __construct(array $configuration, $plugin_id, $plugin_definition, Client $http_client) 
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->http_client = $http_client;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) 
  {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('http_client'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() 
  {
  	// Foreach pokemon returned return a template?
  	return array(
  		'#markup' => var_dump("lol"),
  		);
  }
}