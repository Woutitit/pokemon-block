<?php

namespace Drupal\pokemon_block\Plugin\DsField;
use GuzzleHttp\Client;
use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\Component\Serialization\Json;
/**
 * Plugin that renders the price.
 *
 * @DsField(
 *   id = "type",
 *   title = @Translation("Type"),
 *   entity_type = "node",
 *   provider = "node"
 * )
 */
class Resource extends DsFieldBase 
{
  private $client;

  private $title;


  /**
   * {@inheritdoc}
   */
  public function build() 
  {
    $this->title = $this->entity()->getTitle();
    $this->client = \Drupal::httpClient();

    if($this->isPokemon())
    {
      return ['#markup' => '<b>Type: </b>Pokemon'];
    } 
    else if ($this->isItem())
    {
      return ['#markup' => '<b>Type: </b>Item'];
    } 
    else if ($this->isBerry()) 
    {
      return ['#markup' => '<b>Type: </b>Berry'];
    }
    else 
    {
      return ['#markup' => '<b>Type: </b>This is not a pokemon, not an item and not a berry.'];
    } 
  }


  private function isPokemon() 
  {
    return $this->matchTitle($this->client->get("http://pokeapi.co/api/v2/pokemon/?limit=721", ['headers' => ['Accept' => 'application/json']])); 
  }
 

  private function isItem() 
  {
    return $this->matchTitle($this->client->get("http://pokeapi.co/api/v2/item/?limit=748", ['headers' => ['Accept' => 'application/json']]));
   }


  private function isBerry($client, $title) 
  {
      return $this->matchTitle($this->client->get("http://pokeapi.co/api/v2/berry/?limit=63", ['headers' => ['Accept' => 'application/json']]));
  }


  private function matchTitle($response) 
  {
    $data = Json::decode($response->getBody());

    foreach ($data["results"] as $item)
        if($item["name"] === strtolower(str_replace(' ', '-', $this->title))) 
          return true;

        return false;
  }
}