<?php

/* FOSUserBundle:Group:new_content.html.twig */
class __TwigTemplate_0142c974b701b1bdfee9148636150cda479024eae52cd6e07cc21807b6237e88 extends Twig_Template
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
        // line 2
        echo "
<form action=\"";
        // line 3
        echo $this->env->getExtension('routing')->getPath("fos_user_group_new");
        echo "\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'enctype');
        echo " method=\"POST\" class=\"fos_user_group_new\">
    ";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'widget');
        echo "
    <div>
        <input type=\"submit\" value=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("group.new.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "\" />
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Group:new_content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  23 => 3,  188 => 42,  185 => 41,  181 => 44,  170 => 39,  161 => 36,  129 => 26,  118 => 23,  90 => 45,  65 => 15,  53 => 10,  480 => 162,  474 => 161,  469 => 158,  461 => 155,  457 => 153,  453 => 151,  444 => 149,  440 => 148,  437 => 147,  435 => 146,  430 => 144,  427 => 143,  423 => 142,  413 => 134,  409 => 132,  407 => 131,  402 => 130,  398 => 129,  393 => 126,  387 => 122,  384 => 121,  381 => 120,  379 => 119,  374 => 116,  368 => 112,  365 => 111,  362 => 110,  360 => 109,  355 => 106,  341 => 105,  337 => 103,  322 => 101,  314 => 99,  312 => 98,  309 => 97,  305 => 95,  298 => 91,  294 => 90,  285 => 89,  283 => 88,  278 => 86,  268 => 85,  264 => 84,  258 => 81,  252 => 80,  247 => 78,  241 => 77,  229 => 73,  220 => 70,  214 => 69,  177 => 65,  169 => 60,  140 => 55,  132 => 51,  128 => 49,  107 => 12,  61 => 13,  273 => 96,  269 => 94,  254 => 92,  243 => 88,  240 => 86,  238 => 85,  235 => 74,  230 => 82,  227 => 81,  224 => 71,  221 => 77,  219 => 76,  217 => 75,  208 => 68,  204 => 72,  179 => 41,  159 => 61,  143 => 31,  135 => 29,  119 => 42,  102 => 32,  71 => 19,  67 => 15,  63 => 15,  59 => 13,  38 => 6,  94 => 28,  89 => 20,  85 => 25,  75 => 17,  68 => 14,  56 => 10,  87 => 25,  21 => 2,  26 => 6,  93 => 46,  88 => 21,  78 => 21,  46 => 9,  27 => 4,  44 => 12,  31 => 4,  28 => 4,  201 => 92,  196 => 90,  183 => 82,  171 => 61,  166 => 71,  163 => 62,  158 => 67,  156 => 35,  151 => 34,  142 => 59,  138 => 54,  136 => 56,  121 => 46,  117 => 44,  105 => 40,  91 => 27,  62 => 23,  49 => 19,  24 => 1,  25 => 3,  19 => 2,  79 => 18,  72 => 16,  69 => 16,  47 => 9,  40 => 7,  37 => 6,  22 => 3,  246 => 90,  157 => 56,  145 => 46,  139 => 45,  131 => 52,  123 => 47,  120 => 24,  115 => 22,  111 => 37,  108 => 36,  101 => 5,  98 => 31,  96 => 31,  83 => 18,  74 => 14,  66 => 15,  55 => 15,  52 => 21,  50 => 10,  43 => 8,  41 => 7,  35 => 7,  32 => 4,  29 => 3,  209 => 82,  203 => 78,  199 => 67,  193 => 46,  189 => 71,  187 => 84,  182 => 66,  176 => 40,  173 => 65,  168 => 72,  164 => 59,  162 => 57,  154 => 58,  149 => 51,  147 => 33,  144 => 49,  141 => 48,  133 => 55,  130 => 41,  125 => 25,  122 => 43,  116 => 41,  112 => 21,  109 => 34,  106 => 36,  103 => 32,  99 => 31,  95 => 47,  92 => 21,  86 => 28,  82 => 22,  80 => 19,  73 => 19,  64 => 17,  60 => 6,  57 => 12,  54 => 10,  51 => 14,  48 => 11,  45 => 17,  42 => 7,  39 => 8,  36 => 5,  33 => 6,  30 => 5,);
    }
}
