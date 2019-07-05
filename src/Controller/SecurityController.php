<?php
/**
 * Created by PhpStorm.
 * User: henry
 * Date: 19-9-16
 * Time: 14:39
 */

namespace App\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use App\Service\ImapService;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


/**
 * @property  userManager
 */
class SecurityController extends BaseController {

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request){

        $session = $request->getSession();
        $password = null;
        $err = $session->get('_security.last_error');

        if ($err) {
            $password = $err->getToken()->getCredentials();
        }

        // echo('<pre>'); var_dump($session->all());die();
        // [credentials:Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken:private]
        $response = parent::loginAction($request);

        // do your stuff.
        //var_dump($response->getContent('error'));
        if ($response->getContent('error')) {
            /** @var $session \Symfony\Component\HttpFoundation\Session\Session */

            //echo '<pre>'; print_r($session); die();

            // last username entered by the user
            $lastUsername = (null === $session) ? '' : $session->get('_security.last_username');

 /*           echo 'user : '.$lastUsername.'<br>';
            echo 'password : '.$password;*/

            if ($password && $lastUsername) {
                $access = ImapService::validatePasswordAction($lastUsername, $password);
                if ($access) {
                    //echo '<div>Imap is gelukt!</div>';

                    if (class_exists ('\Symfony\Component\Security\Core\Security')) {
                        $authErrorKey = Security::AUTHENTICATION_ERROR;
                        $lastUsernameKey = Security::LAST_USERNAME;
                    }

                    //echo '<pre>'; print_r($request); die();
                    $userManager = $this->container->get ('fos_user.user_manager');

                    // REMOVE USER FIRST
                    $user = $userManager->findUserByUsername(substr ($lastUsername, 0, strpos ($lastUsername, '@')));
                    if ($user) {
                        // $userManager->deleteUser ($user);
                        $userManager->updateUser($user, true);
                    } else {
                        // Create our user and set details (check if user already in table).
                        $user = $userManager->createUser();
                        $user->setUsername(substr($lastUsername, 0, strpos($lastUsername, '@')));
                        $user->setEmail($lastUsername);
                        $user->setPlainPassword($password);
                        $user->setEnabled((Boolean)true);
                        $user->addRole('ROLE_USER');
                        // Update the user
                        $userManager->updateUser($user, true);
                    }
                    $token = new UsernamePasswordToken(
                        $user,
                        $user->getPassword (),
                        'secured_area',
                        $user->getRoles ()
                    );

                    $this->get ('security.token_storage')->setToken ($token);
                    $request->getSession ()->set ('_security_secured_area', serialize ($token));

                    $token = new UsernamePasswordToken($user, $user->getPassword (), "secured_area", $user->getRoles ());
                    $this->get ("security.token_storage")->setToken ($token);

                    $event = new InteractiveLoginEvent($request, $token);
                    $this->get ("event_dispatcher")->dispatch ("security.interactive_login", $event);

                    // get the error if any (works with forward and redirect -- see below)
                    $error = null;

                    if ($this->has('security.csrf.token_manager')) {
                        $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
                        //die('csrfToken = ' .$csrfToken);
                    }

                    return $this->redirectToRoute('activity_index');
 /*                   return $this->renderLogin(array(
                        'last_username' => substr($lastUsername,0,strpos($lastUsername,'@')),
                        'error' => $error,
                        'csrf_token' => $csrfToken,
                    ));*/

                } else {
                    //echo 'fout gegaan';
                }
            }
        }

         return $response;

    }

}
