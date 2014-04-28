<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // es__RG__jmbermudo_sgr3_homepage
        if (preg_match('#^/(?P<name>[^/]++)?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'es__RG__jmbermudo_sgr3_homepage')), array (  '_controller' => 'Jmbermudo\\SGR3Bundle\\Controller\\DefaultController::indexAction',  'name' => 'pepe',  '_locale' => 'es',));
        }

        // en__RG__jmbermudo_sgr3_homepage
        if (0 === strpos($pathinfo, '/en') && preg_match('#^/en(?:/(?P<name>[^/]++))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'en__RG__jmbermudo_sgr3_homepage')), array (  '_controller' => 'Jmbermudo\\SGR3Bundle\\Controller\\DefaultController::indexAction',  'name' => 'pepe',  '_locale' => 'en',));
        }

        // es__RG__fos_user_security_login
        if ($pathinfo === '/login') {
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_locale' => 'es',  '_route' => 'es__RG__fos_user_security_login',);
        }

        // en__RG__fos_user_security_login
        if ($pathinfo === '/en/login') {
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_locale' => 'en',  '_route' => 'en__RG__fos_user_security_login',);
        }

        // es__RG__fos_user_security_check
        if ($pathinfo === '/login_check') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_es__RG__fos_user_security_check;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_locale' => 'es',  '_route' => 'es__RG__fos_user_security_check',);
        }
        not_es__RG__fos_user_security_check:

        // en__RG__fos_user_security_check
        if ($pathinfo === '/en/login_check') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_en__RG__fos_user_security_check;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_locale' => 'en',  '_route' => 'en__RG__fos_user_security_check',);
        }
        not_en__RG__fos_user_security_check:

        // es__RG__fos_user_security_logout
        if ($pathinfo === '/logout') {
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_locale' => 'es',  '_route' => 'es__RG__fos_user_security_logout',);
        }

        // en__RG__fos_user_security_logout
        if ($pathinfo === '/en/logout') {
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_locale' => 'en',  '_route' => 'en__RG__fos_user_security_logout',);
        }

        // es__RG__fos_user_registration_register
        if (rtrim($pathinfo, '/') === '/register') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'es__RG__fos_user_registration_register');
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_locale' => 'es',  '_route' => 'es__RG__fos_user_registration_register',);
        }

        // en__RG__fos_user_registration_register
        if (rtrim($pathinfo, '/') === '/en/register') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'en__RG__fos_user_registration_register');
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_locale' => 'en',  '_route' => 'en__RG__fos_user_registration_register',);
        }

        // es__RG__fos_user_registration_check_email
        if ($pathinfo === '/register/check-email') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_es__RG__fos_user_registration_check_email;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_locale' => 'es',  '_route' => 'es__RG__fos_user_registration_check_email',);
        }
        not_es__RG__fos_user_registration_check_email:

        // en__RG__fos_user_registration_check_email
        if ($pathinfo === '/en/register/check-email') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_en__RG__fos_user_registration_check_email;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_locale' => 'en',  '_route' => 'en__RG__fos_user_registration_check_email',);
        }
        not_en__RG__fos_user_registration_check_email:

        // es__RG__fos_user_registration_confirm
        if (0 === strpos($pathinfo, '/register/confirm') && preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_es__RG__fos_user_registration_confirm;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'es__RG__fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',  '_locale' => 'es',));
        }
        not_es__RG__fos_user_registration_confirm:

        // en__RG__fos_user_registration_confirm
        if (0 === strpos($pathinfo, '/en/register/confirm') && preg_match('#^/en/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_en__RG__fos_user_registration_confirm;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'en__RG__fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',  '_locale' => 'en',));
        }
        not_en__RG__fos_user_registration_confirm:

        // es__RG__fos_user_registration_confirmed
        if ($pathinfo === '/register/confirmed') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_es__RG__fos_user_registration_confirmed;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_locale' => 'es',  '_route' => 'es__RG__fos_user_registration_confirmed',);
        }
        not_es__RG__fos_user_registration_confirmed:

        // en__RG__fos_user_registration_confirmed
        if ($pathinfo === '/en/register/confirmed') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_en__RG__fos_user_registration_confirmed;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_locale' => 'en',  '_route' => 'en__RG__fos_user_registration_confirmed',);
        }
        not_en__RG__fos_user_registration_confirmed:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
