<?php

/* FOSUserBundle:Security:login.html.twig */
class __TwigTemplate_3a3999af571fa5bddaa06926642a621a75a3b583580013341b88dd94d7bc97eb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("FOSUserBundle::layout.html.twig");

        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FOSUserBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_fos_user_content($context, array $blocks = array())
    {
        // line 6
        echo "
    <div class=\"container\">    
        <div id=\"loginbox\" style=\"margin-top:50px;\" class=\"mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2\">                    
            <div class=\"panel panel-info\" >
                    <div class=\"panel-heading\">
                        <div class=\"panel-title\">";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("login.title", array(), "messages"), "html", null, true);
        echo "</div>
                    </div>     

                    <div style=\"padding-top:30px\" class=\"panel-body\" >

                        <div style=\"display:none\" id=\"login-alert\" class=\"alert alert-danger col-sm-12\">
                            ";
        // line 17
        if ((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error"))) {
            // line 18
            echo "                                <div>";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), array(), "FOSUserBundle"), "html", null, true);
            echo "</div>
                            ";
        }
        // line 20
        echo "                        </div>
                            
                        <form action=\"";
        // line 22
        echo $this->env->getExtension('routing')->getPath("fos_user_security_check");
        echo "\" method=\"post\">
                            <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 23
        echo twig_escape_filter($this->env, (isset($context["csrf_token"]) ? $context["csrf_token"] : $this->getContext($context, "csrf_token")), "html", null, true);
        echo "\" />
                                    
                            <div style=\"margin-bottom: 25px\" class=\"input-group\">
                                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                                        <input type=\"text\" id=\"username\" name=\"_username\" class=\"form-control\" value=\"";
        // line 27
        echo twig_escape_filter($this->env, (isset($context["last_username"]) ? $context["last_username"] : $this->getContext($context, "last_username")), "html", null, true);
        echo "\" required=\"required\" placeholder=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.username", array(), "FOSUserBundle"), "html", null, true);
        echo "\" />
                                    </div>
                                
                            <div style=\"margin-bottom: 25px\" class=\"input-group\">
                                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                        <input type=\"password\" id=\"password\" name=\"_password\" required=\"required\" class=\"form-control\" placeholder=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.password", array(), "FOSUserBundle"), "html", null, true);
        echo "\" />
                                    </div>
                                    

                                
                            <div class=\"input-group\">
                                      <div class=\"checkbox\">
                                        <label>
                                          <input id=\"login-remember\" type=\"checkbox\" name=\"remember\" value=\"1\"> ";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.remember_me", array(), "FOSUserBundle"), "html", null, true);
        echo "
                                        </label>
                                      </div>
                                    </div>


                                <div style=\"margin-top:10px\" class=\"form-group\">
                                    <!-- Button -->

                                    <div class=\"col-sm-12 controls\">
                                      <input type=\"submit\" id=\"_submit\" name=\"_submit\" value=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "\" class=\"btn btn-success\" />

                                    </div>
                                </div>
 
                            </form>     



                        </div>                     
                    </div>  
        </div>
    </div>
    ";
    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 50,  91 => 40,  80 => 32,  70 => 27,  63 => 23,  59 => 22,  55 => 20,  49 => 18,  47 => 17,  38 => 11,  31 => 6,  28 => 5,);
    }
}
