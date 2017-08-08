<?php

namespace Drupal\pokemon_block\Plugin\Block;

use GuzzleHttp\Client;
use Drupal\Core\Block\BlockBase;
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
  	$build = array();

  	$response = $this->http_client->get('http://pokeapi.co/api/v2/pokemon/', array('headers' => array('Accept' => 'application/json')));
  	// Nu dus een template loopen foreach result
  	$data = Json::decode($response->getBody());

  	$i = 0;
  	
  	foreach($data['results'] as $pokemon)
  	{
  		$build['children'][$i] = ['#theme' => 'pokemon_block_item'];
  		$i++;
  	}

  	return $build;
  }
}