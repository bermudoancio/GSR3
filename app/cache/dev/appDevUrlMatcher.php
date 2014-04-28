<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
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

        if (0 === strpos($pathinfo, '/css/ece3c02')) {
            // _assetic_ece3c02
            if ($pathinfo === '/css/ece3c02.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => 'ece3c02',  'pos' => NULL,  '_format' => 'css',  '_route' => '_assetic_ece3c02',);
            }

            // _assetic_ece3c02_0
            if ($pathinfo === '/css/ece3c02_part_1_styles_1.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => 'ece3c02',  'pos' => 0,  '_format' => 'css',  '_route' => '_assetic_ece3c02_0',);
            }

        }

        if (0 === strpos($pathinfo, '/js/1ae564f')) {
            // _assetic_1ae564f
            if ($pathinfo === '/js/1ae564f.js') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '1ae564f',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_1ae564f',);
            }

            // _assetic_1ae564f_0
            if ($pathinfo === '/js/1ae564f_part_1_jquery-1.11.0.min_1.js') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '1ae564f',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_1ae564f_0',);
            }

        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

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

        // es__RG__jmbermudo_sgr3_homepage
        if (preg_match('#^/(?P<name>[^/]++)?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'es__RG__jmbermudo_sgr3_homepage')), array (  '_controller' => 'Jmbermudo\\SGR3Bundle\\Controller\\DefaultController::indexAction',  'name' => 'pepe',  '_locale' => 'es',));
        }

        // en__RG__jmbermudo_sgr3_homepage
        if (0 === strpos($pathinfo, '/en') && preg_match('#^/en(?:/(?P<name>[^/]++))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'en__RG__jmbermudo_sgr3_homepage')), array (  '_controller' => 'Jmbermudo\\SGR3Bundle\\Controller\\DefaultController::indexAction',  'name' => 'pepe',  '_locale' => 'en',));
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
