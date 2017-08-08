<?php

namespace Drupal\pokemon_block\Plugin\Block;

use GuzzleHttp\Client;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Serialization\Json;

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

  /**
   * @var \Drupal\Core\Config\ConfigFactory
   */
  private $config_factory;


  public function __construct(array $configuration, $plugin_id, $plugin_definition, Client $http_client, ConfigFactory $config_factory) 
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->http_client = $http_client;
    $this->config_factory = $config_factory;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) 
  {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('http_client'), $container->get('config.factory'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() 
  {

    $build = array();

    $resource = $this->config_factory->get('pokemon_block.settings')->get('resource');
    
    // When in config we change the resource setting. It doesn't update, only after disabling and enabling the block, or after clearing the caches.
    // But maybe this is normal?
    // Or maybe if we would have had this in the block form it would change for the block immediatly?
    // But often you need general settings NOT in the block form, so I guess then you'd also need to clear the caches. So I guess it's normal?
    $response = $this->http_client->get("http://pokeapi.co/api/v2/{$resource}/", array('headers' => array('Accept' => 'application/json')));
    
    $data = Json::decode($response->getBody());

    $i = 0;

    foreach($data['results'] as $resource)
    {
      // Also depending on resource return different template?
      $build['children'][$i] = ['#theme' => 'pokemon_block_item', '#data' => $resource ];
      $i++;
    }

    return $build;
  }
}