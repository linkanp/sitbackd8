<?php

/**
 * @file
 * Contains \Drupal\apha_discussion_headers\Controller\ImportController.
 */

namespace Drupal\apha_utility\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 *
 *
 * @author Linkan
 */
class UtilityController extends ControllerBase {

    /*
     * Handler function to redirect the Lexicomp Student/Member
     *
     */
    public function redirectLexicompUser(){

        $current_user = \Drupal::currentUser();
        $user = \Drupal\user\Entity\User::load($current_user->id());

        if($user->id() && $user->hasRole('student')){
            return new RedirectResponse('lexistudent');
        } else if($user->id() && $user->hasRole('member')){
            return new RedirectResponse('lexicompstudent');
        } else {
            return new RedirectResponse('lexicomp-student-promotion');
        }

    }


}
