<?php

namespace Drupal\veles_timer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use DateTime;

/**
 * Provides a "Vales timer" block.
 *
 * @Block(
 *   id = "veles_timer",
 *   admin_label = @Translation("Велес Таймер"),
 *   category = @Translation("Custom block")
 * )
 */
class VelesTimer extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $dt = new DateTime('tomorrow');
    $countdown_datetime = $dt->format('Y-m-d H:i:s');

    return [
      'countdown_datetime' => $countdown_datetime,
      'timer_title' => $this->configuration['timer_title'],
      'timer_text' => $this->configuration['timer_text'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['timer_date'] = [
      '#type' => 'datetime',
      '#title' => $this->t('Timer date'),
      '#required' => 1,
      '#default_value' => new DrupalDateTime($this->configuration['countdown_datetime']),
      '#date_date_element' => 'date',
      '#date_time_element' => 'time',
      '#date_year_range' => '2023:+30',
    ];
    $form['timer_title'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Заголовок таймера'),
      '#default_value' => $this->configuration['timer_title']['value'],
      '#required' => 1,

    ];
    $form['timer_text'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Описание таймера'),
      '#default_value' => $this->configuration['timer_text']['value'],
      '#required' => 1,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $dt = $form_state->getValue('timer_date');
    $this->configuration['countdown_datetime'] = $dt->format('Y-m-d H:i:s');
    $this->configuration['timer_title'] = $form_state->getValue('timer_title');
    $this->configuration['timer_text'] = $form_state->getValue('timer_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $settings = [
      'unixtimestamp' => strtotime($this->configuration['countdown_datetime']),
      'timer_title' => $this->configuration['timer_title'],
      'timer_text' => $this->configuration['timer_text'],

    ];


    $path_to_module = \Drupal::service('extension.list.module')->getPath('veles_timer');
    $path_to_images = $path_to_module.'/images';

    $build = [];
    $build['content'] = [
      '#theme' => 'veles_timer',
      '#path_to_images' => $path_to_images
    ];

    // Attach library containing css and js files.
    $build['#attached']['library'][] = 'veles_timer/timer';
    $build['#attached']['drupalSettings']['countdown'] = $settings;

    return $build;
  }

}
