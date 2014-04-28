<?php

/* AcmeDemoBundle:Secured:helloadmin.html.twig */
class __TwigTemplate_22c7f73be2e8fe499d72dd62356de79fa76f745885c70504a6177b48daed0585 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("AcmeDemoBundle:Secured:layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "AcmeDemoBundle:Secured:layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 9
        $context["code"] = $this->env->getExtension('demo')->getCode($this);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ("Hello " . (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name"))), "html", null, true);
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    <h1 class=\"title\">Hello ";
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
        echo " secured for Admins only!</h1>
";
    }

    public function getTemplateName()
    {
        return "AcmeDemoBundle:Secured:helloadmin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 28,  84 => 29,  237 => 104,  234 => 103,  232 => 102,  216 => 96,  191 => 82,  172 => 73,  153 => 70,  148 => 67,  124 => 61,  100 => 56,  97 => 55,  76 => 17,  104 => 50,  70 => 27,  34 => 7,  110 => 22,  23 => 1,  188 => 81,  185 => 41,  181 => 44,  170 => 39,  161 => 36,  129 => 64,  118 => 23,  90 => 32,  65 => 22,  53 => 11,  480 => 162,  474 => 161,  469 => 158,  461 => 155,  457 => 153,  453 => 151,  444 => 149,  440 => 148,  437 => 147,  435 => 146,  430 => 144,  427 => 143,  423 => 142,  413 => 134,  409 => 132,  407 => 131,  402 => 130,  398 => 129,  393 => 126,  387 => 122,  384 => 121,  381 => 120,  379 => 119,  374 => 116,  368 => 112,  365 => 111,  362 => 110,  360 => 109,  355 => 106,  341 => 105,  337 => 103,  322 => 101,  314 => 99,  312 => 98,  309 => 97,  305 => 95,  298 => 91,  294 => 90,  285 => 89,  283 => 88,  278 => 86,  268 => 85,  264 => 84,  258 => 81,  252 => 80,  247 => 78,  241 => 77,  229 => 101,  220 => 70,  214 => 95,  177 => 76,  169 => 60,  140 => 55,  132 => 51,  128 => 49,  107 => 12,  61 => 12,  273 => 96,  269 => 94,  254 => 92,  243 => 88,  240 => 86,  238 => 85,  235 => 74,  230 => 82,  227 => 100,  224 => 99,  221 => 98,  219 => 97,  217 => 75,  208 => 68,  204 => 72,  179 => 77,  159 => 61,  143 => 31,  135 => 29,  119 => 42,  102 => 17,  71 => 27,  67 => 22,  63 => 21,  59 => 13,  38 => 6,  94 => 34,  89 => 20,  85 => 25,  75 => 24,  68 => 14,  56 => 11,  87 => 21,  21 => 2,  26 => 9,  93 => 46,  88 => 31,  78 => 26,  46 => 8,  27 => 5,  44 => 12,  31 => 3,  28 => 3,  201 => 89,  196 => 90,  183 => 82,  171 => 61,  166 => 71,  163 => 62,  158 => 67,  156 => 35,  151 => 34,  142 => 59,  138 => 54,  136 => 56,  121 => 46,  117 => 19,  105 => 18,  91 => 40,  62 => 23,  49 => 10,  24 => 7,  25 => 3,  19 => 1,  79 => 18,  72 => 16,  69 => 24,  47 => 8,  40 => 6,  37 => 5,  22 => 3,  246 => 90,  157 => 71,  145 => 46,  139 => 45,  131 => 52,  123 => 47,  120 => 20,  115 => 43,  111 => 37,  108 => 19,  101 => 5,  98 => 35,  96 => 31,  83 => 18,  74 => 14,  66 => 15,  55 => 20,  52 => 10,  50 => 10,  43 => 7,  41 => 5,  35 => 5,  32 => 4,  29 => 3,  209 => 92,  203 => 78,  199 => 67,  193 => 83,  189 => 71,  187 => 84,  182 => 78,  176 => 40,  173 => 65,  168 => 72,  164 => 59,  162 => 57,  154 => 58,  149 => 51,  147 => 33,  144 => 49,  141 => 48,  133 => 65,  130 => 41,  125 => 25,  122 => 43,  116 => 41,  112 => 21,  109 => 59,  106 => 36,  103 => 32,  99 => 31,  95 => 25,  92 => 24,  86 => 29,  82 => 28,  80 => 32,  73 => 16,  64 => 13,  60 => 18,  57 => 12,  54 => 15,  51 => 15,  48 => 9,  45 => 8,  42 => 7,  39 => 7,  36 => 5,  33 => 3,  30 => 3,);
    }
}
