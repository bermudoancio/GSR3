<?php

/* ::base.html.twig */
class __TwigTemplate_36c1a965b6d35c785f2a04ef3ca5d7a20519f8fd6aec714c8de2e9c47b4422fa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts_block' => array($this, 'block_javascripts_block'),
            'body' => array($this, 'block_body'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        
        ";
        // line 7
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "ece3c02_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_ece3c02_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/ece3c02_part_1_styles_1.css");
            // line 8
            echo "            <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
        ";
        } else {
            // asset "ece3c02"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_ece3c02") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/ece3c02.css");
            echo "            <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
        ";
        }
        unset($context["asset_url"]);
        // line 10
        echo "        
        
        ";
        // line 12
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 13
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        
        ";
        // line 15
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "1ae564f_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_1ae564f_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/1ae564f_part_1_jquery-1.11.0.min_1.js");
            // line 16
            echo "            <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
        ";
        } else {
            // asset "1ae564f"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_1ae564f") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/1ae564f.js");
            echo "            <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
        ";
        }
        unset($context["asset_url"]);
        // line 18
        echo "            
        ";
        // line 19
        $this->displayBlock('javascripts_block', $context, $blocks);
        // line 20
        echo "        
    </head>
    <body>
        
        ";
        // line 24
        $this->env->loadTemplate("navegation.html.twig")->display($context);
        // line 25
        echo "        
        ";
        // line 26
        $this->displayBlock('body', $context, $blocks);
        // line 40
        echo "
        ";
        // line 41
        $this->displayBlock('javascripts', $context, $blocks);
        // line 42
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo $this->env->getExtension('translator')->getTranslator()->trans("global.title", array(), "messages");
    }

    // line 12
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 19
    public function block_javascripts_block($context, array $blocks = array())
    {
    }

    // line 26
    public function block_body($context, array $blocks = array())
    {
        // line 27
        echo "            
            ";
        // line 28
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "all", array(), "method"));
        foreach ($context['_seq'] as $context["type"] => $context["messages"]) {
            // line 29
            echo "                ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["messages"]) ? $context["messages"] : $this->getContext($context, "messages")));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 30
                echo "                    <div class=\"flash-";
                echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : $this->getContext($context, "type")), "html", null, true);
                echo "\">
                        ";
                // line 31
                echo twig_escape_filter($this->env, (isset($context["message"]) ? $context["message"] : $this->getContext($context, "message")), "html", null, true);
                echo "
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 34
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['messages'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "
            ";
        // line 36
        $this->displayBlock('content', $context, $blocks);
        // line 39
        echo "        ";
    }

    // line 36
    public function block_content($context, array $blocks = array())
    {
        // line 37
        echo "
            ";
    }

    // line 41
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  181 => 41,  176 => 37,  173 => 36,  169 => 39,  167 => 36,  164 => 35,  158 => 34,  149 => 31,  144 => 30,  139 => 29,  135 => 28,  132 => 27,  129 => 26,  124 => 19,  119 => 12,  113 => 5,  107 => 42,  105 => 41,  102 => 40,  100 => 26,  97 => 25,  95 => 24,  89 => 20,  87 => 19,  84 => 18,  70 => 16,  66 => 15,  60 => 13,  58 => 12,  54 => 10,  40 => 8,  36 => 7,  31 => 5,  25 => 1,);
    }
}
