<?php

/**
 * @file
 * Contains \Drupal\filefield_sources\Plugin\FilefieldSource\Unsplash.
 */

namespace Drupal\filefield_sources_unsplash\Plugin\FilefieldSource;

use Drupal\Core\Form\FormStateInterface;
//use Drupal\filefield_sources\FilefieldSourceInterface;
use Symfony\Component\Routing\Route;
use Drupal\Core\Field\WidgetInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Site\Settings;
use Drupal\Component\Utility\Unicode;
use Drupal\filefield_sources\Plugin\FilefieldSource\Remote;

/**
 * A FileField source plugin to allow downloading a file from a unsplash server.
 *
 * @FilefieldSource(
 *   id = "unsplash",
 *   name = @Translation("Unsplash URL textfield"),
 *   label = @Translation("Unsplash URL"),
 *   description = @Translation("Download a file from a unsplash server.")
 * )
 */
class Unsplash extends Remote {

  /**
   * {@inheritdoc}
   */
  public static function value(array &$element, &$input, FormStateInterface $form_state) {  
    $unsplash_url = parse_url($input['filefield_remote']['url']);
    if(isset($unsplash_url['query'])) {
      parse_str($unsplash_url['query'], $query_array);
      if(isset($query_array['photo'])){
        $input['filefield_remote']['url'] = 'https://source.unsplash.com/' .$query_array['photo'];
        parent::value($element, $input, $form_state);
      } else {
        drupal_set_message(t('Please use an Unsplash url http://unsplash.com?photo=XXXXXXX'), 'error');
        return;
      }
    }

  }
}
