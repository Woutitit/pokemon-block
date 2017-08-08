<?php

namespace Drupal\pokemon_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class PokemonConfigForm extends ConfigFormBase 
{

  /**
   * {@inheritdoc}
   */
  public function getFormId() 
  {
    return 'pokemon_block_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() 
  {
    return [
      'pokemon_block.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) 
  {
    $config = $this->config('pokemon_block.settings');

    $form['resource'] = [
      '#type' => 'radios',
      '#title' => $this->t('What to show?'),
      '#default_value' => $config->get('resource'),
      '#options' => [
        'berry' => $this->t('Berries'), 
        'item' => $this->t('Items'),
        'pokemon' => $this->t('Pokemon'),
      ]
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) 
  {
    $values = $form_state->getValues();
    $this->config('pokemon_block.settings')
      ->set('resource', $values['resource'])
      ->save();

      parent::submitForm($form, $form_state);
  }
}