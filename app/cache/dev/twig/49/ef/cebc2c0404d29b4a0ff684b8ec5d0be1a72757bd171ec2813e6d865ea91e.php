<?php

/* FOSUserBundle::layout.html.twig */
class __TwigTemplate_49efcebc2c0404d29b4a0ff684b8ec5d0be1a72757bd171ec2813e6d865ea91e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_title($context, array $blocks = array())
    {
        echo "Acme Demo Application";
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
        // line 7
        echo "    ";
        $this->displayParentBlock("content", $context, $blocks);
        echo "

    ";
        // line 9
        $this->displayBlock('fos_user_content', $context, $blocks);
        // line 11
        echo "
";
    }

    // line 9
    public function block_fos_user_content($context, array $blocks = array())
    {
        // line 10
        echo "    ";
    }

    public function getTemplateName()
    {
        return "FOSUserBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 10,  52 => 9,  47 => 11,  45 => 9,  39 => 7,  36 => 6,  30 => 4,);
    }
}
