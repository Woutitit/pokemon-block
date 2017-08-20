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
class Resource extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /* @var $node \Drupal\node\NodeInterface */
    $node = $this->entity();
    $title = $node->getTitle();

    $client = \Drupal::httpClient();

    if($this->isPokemon($client, $title))
    {
      return ['#markup' => '<b>Type: </b>Pokemon.'];
    } 
    else if ($this->isItem($client, $title))
    {
      return ['#markup' => '<b>Type: </b>Item.'];
    } 
    else if ($this->isBerry($client, $title)) 
    {
      return ['#markup' => '<b>Type: </b>Berry.'];
    }
    else 
    {
      return ['#markup' => '<b>Type: </b>This is not a pokemon, not an item and not a berry.'];
    }

    
  }

  private function isPokemon($client, $title) 
  {
    $response = $client->get("http://pokeapi.co/api/v2/pokemon/?limit=721", ['headers' => ['Accept' => 'application/json']]);
    $data = Json::decode($response->getBody());

    foreach ($data["results"] as $pokemon)
      if($pokemon["name"] === strtolower($title)) 
        return true;

      return false;  
    }
    
   private function isItem($client, $title) 
  {
      $response = $client->get("http://pokeapi.co/api/v2/item/?limit=748", ['headers' => ['Accept' => 'application/json']]);
      $data = Json::decode($response->getBody());

      foreach ($data["results"] as $item)
        if($item["name"] === strtolower(str_replace(' ', '-', $title))) 
          return true;

        return false;
      }

    private function isBerry($client, $title) 
    {
        $response = $client->get("http://pokeapi.co/api/v2/berry/?limit=63", ['headers' => ['Accept' => 'application/json']]);
        $data = Json::decode($response->getBody());

        foreach ($data["results"] as $berry)
          if($berry["name"] === strtolower($title)) 
            return true;

          return false;
    }
}