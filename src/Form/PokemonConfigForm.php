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

    $form['settings']['active'] = [
      '#type' => 'radios',
      '#title' => $this->t('What to show?'),
      '#default_value' => $config->get('resource'),
      '#options' => [
        0 => $this->t('Berries'), 
        1 => $this->t('Items'),
        2 => $this->t('Pokemon'),
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
      ->set('your_message', $values['your_message'])
      ->save();
  }

}