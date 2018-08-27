<?php

namespace Drupal\sitback_utility\Plugin\Block;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'Payment Information Form' block.
 *
 * @Block(
 *   id = "payment_information_form_block",
 *   admin_label = @Translation("Payment information form block"),
 *   category = @Translation("Forms")
 * )
 */
class PaymentInfoFormBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        return \Drupal::formBuilder()->getForm('Drupal\sitback_utility\Form\PaymentInfoForm');
    }

}
