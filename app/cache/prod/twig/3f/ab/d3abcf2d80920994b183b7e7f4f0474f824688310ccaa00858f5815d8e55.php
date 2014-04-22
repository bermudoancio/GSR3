<?php

/* JmbermudoSGR3Bundle:Default:index.html.twig */
class __TwigTemplate_3fabd3abcf2d80920994b183b7e7f4f0474f824688310ccaa00858f5815d8e55 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Hello ";
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo "!
";
    }

    public function getTemplateName()
    {
        return "JmbermudoSGR3Bundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
