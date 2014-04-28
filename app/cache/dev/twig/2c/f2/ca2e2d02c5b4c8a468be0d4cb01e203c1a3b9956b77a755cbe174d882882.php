<?php

/* JMSTranslationBundle:Translate:index.html.twig */
class __TwigTemplate_2cf2ca2e2d02c5b4c8a468be0d4cb01e203c1a3b9956b77a755cbe174d882882 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("JMSTranslationBundle::base.html.twig");

        $this->blocks = array(
            'javascripts' => array($this, 'block_javascripts'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "JMSTranslationBundle::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_javascripts($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    
    <script language=\"javascript\" type=\"text/javascript\">
        \$(document).ready(function() {
            var updateMessagePath = ";
        // line 8
        echo twig_jsonencode_filter($this->env->getExtension('routing')->getPath("jms_translation_update_message", array("config" => (isset($context["selectedConfig"]) ? $context["selectedConfig"] : $this->getContext($context, "selectedConfig")), "domain" => (isset($context["selectedDomain"]) ? $context["selectedDomain"] : $this->getContext($context, "selectedDomain")), "locale" => (isset($context["selectedLocale"]) ? $context["selectedLocale"] : $this->getContext($context, "selectedLocale")))));
        echo ";
        
            \$('#config select').change(function() {
                \$(this).parent().submit();
            });
            
            ";
        // line 14
        if (((isset($context["isWriteable"]) ? $context["isWriteable"] : $this->getContext($context, "isWriteable")) === true)) {
            // line 15
            echo "            \$('textarea')
                .blur(function() {
                    var self = this;
                    \$.ajax(updateMessagePath + '?id=' + encodeURIComponent(\$(this).data('id')), {
                        type: 'POST',
                        headers: {'X-HTTP-METHOD-OVERRIDE': 'PUT'},
                        data: {'_method': 'PUT', 'message': \$(this).val()},
                        error: function() {
                            \$(self).parent().prepend('<div class=\"alert-message error\">Translation could not be saved</div>');
                        },
                        success: function() {
                            \$(self).parent().prepend('<div class=\"alert-message success\">Translation was saved.</div>');
                        },
                        complete: function() {
                            var parent = \$(self).parent();
                            \$(self).data('timeoutId', setTimeout(function() {
                                \$(self).data('timeoutId', undefined);
                                parent.children('.alert-message').fadeOut(300, function() { \$(this).remove(); });
                            }, 10000));
                        }
                    });
                })
                .focus(function() {
                    this.select();
                    
                    var timeoutId = \$(this).data('timeoutId');
                    if (timeoutId) {
                        clearTimeout(timeoutId);
                        \$(this).data('timeoutId', undefined);
                    }
                    
                    \$(this).parent().children('.alert-message').remove();
                })
            ;
            ";
        }
        // line 50
        echo "        });
    </script>
";
    }

    // line 54
    public function block_body($context, array $blocks = array())
    {
        // line 55
        echo "
    <form id=\"config\" action=\"";
        // line 56
        echo $this->env->getExtension('routing')->getPath("jms_translation_index");
        echo "\" method=\"get\">
        <select name=\"config\" class=\"span3\">
            ";
        // line 58
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["configs"]) ? $context["configs"] : $this->getContext($context, "configs")));
        foreach ($context['_seq'] as $context["_key"] => $context["config"]) {
            // line 59
            echo "            <option value=\"";
            echo twig_escape_filter($this->env, (isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "html", null, true);
            echo "\"";
            if (((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")) == (isset($context["selectedConfig"]) ? $context["selectedConfig"] : $this->getContext($context, "selectedConfig")))) {
                echo " selected=\"selected\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, (isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['config'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 61
        echo "        </select>
    
        <select name=\"domain\" class=\"span3\">
            ";
        // line 64
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["domains"]) ? $context["domains"] : $this->getContext($context, "domains")));
        foreach ($context['_seq'] as $context["_key"] => $context["domain"]) {
            // line 65
            echo "            <option value=\"";
            echo twig_escape_filter($this->env, (isset($context["domain"]) ? $context["domain"] : $this->getContext($context, "domain")), "html", null, true);
            echo "\"";
            if (((isset($context["domain"]) ? $context["domain"] : $this->getContext($context, "domain")) == (isset($context["selectedDomain"]) ? $context["selectedDomain"] : $this->getContext($context, "selectedDomain")))) {
                echo " selected=\"selected\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, (isset($context["domain"]) ? $context["domain"] : $this->getContext($context, "domain")), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['domain'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 67
        echo "        </select>
        
        <select name=\"locale\" class=\"span2\">
            ";
        // line 70
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["locales"]) ? $context["locales"] : $this->getContext($context, "locales")));
        foreach ($context['_seq'] as $context["_key"] => $context["locale"]) {
            // line 71
            echo "            <option value=\"";
            echo twig_escape_filter($this->env, (isset($context["locale"]) ? $context["locale"] : $this->getContext($context, "locale")), "html", null, true);
            echo "\"";
            if (((isset($context["locale"]) ? $context["locale"] : $this->getContext($context, "locale")) == (isset($context["selectedLocale"]) ? $context["selectedLocale"] : $this->getContext($context, "selectedLocale")))) {
                echo " selected=\"selected\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, (isset($context["locale"]) ? $context["locale"] : $this->getContext($context, "locale")), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['locale'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 73
        echo "        </select>
    </form>
    
    ";
        // line 76
        if (((isset($context["isWriteable"]) ? $context["isWriteable"] : $this->getContext($context, "isWriteable")) === false)) {
            // line 77
            echo "    <div class=\"alert-message error\">
        The translation file \"<strong>";
            // line 78
            echo twig_escape_filter($this->env, (isset($context["file"]) ? $context["file"] : $this->getContext($context, "file")), "html", null, true);
            echo "</strong>\" is not writable.
    </div>
    ";
        }
        // line 81
        echo "    
    ";
        // line 82
        if (("xliff" != (isset($context["format"]) ? $context["format"] : $this->getContext($context, "format")))) {
            // line 83
            echo "    <div class=\"alert-message warning\">
        Due to limitations of the different loaders/dumpers, some features are unfortunately limited to the XLIFF format. 
        
        <br /><br />
        
        However, you can easily convert your existing translation files to the XLIFF format by running:<br />
        <code>php app/console translation:extract ";
            // line 89
            echo twig_escape_filter($this->env, (isset($context["selectedLocale"]) ? $context["selectedLocale"] : $this->getContext($context, "selectedLocale")), "html", null, true);
            echo " --config=";
            echo twig_escape_filter($this->env, (isset($context["selectedConfig"]) ? $context["selectedConfig"] : $this->getContext($context, "selectedConfig")), "html", null, true);
            echo " --output-format=xliff</code>
    </div>
    ";
        }
        // line 92
        echo "
    <h2>Available Messages</h2>
    
    ";
        // line 95
        if ((!twig_test_empty((isset($context["newMessages"]) ? $context["newMessages"] : $this->getContext($context, "newMessages"))))) {
            // line 96
            echo "    <h3>New Messages</h3>
    ";
            // line 97
            $this->env->loadTemplate("JMSTranslationBundle:Translate:messages.html.twig")->display(array_merge($context, array("messages" => (isset($context["newMessages"]) ? $context["newMessages"] : $this->getContext($context, "newMessages")))));
            // line 98
            echo "    ";
        }
        // line 99
        echo "    
    ";
        // line 100
        if ((!twig_test_empty((isset($context["existingMessages"]) ? $context["existingMessages"] : $this->getContext($context, "existingMessages"))))) {
            // line 101
            echo "    <h3>Existing Messages</h3>
    ";
            // line 102
            $this->env->loadTemplate("JMSTranslationBundle:Translate:messages.html.twig")->display(array_merge($context, array("messages" => (isset($context["existingMessages"]) ? $context["existingMessages"] : $this->getContext($context, "existingMessages")))));
            // line 103
            echo "    ";
        }
        // line 104
        echo "
";
    }

    public function getTemplateName()
    {
        return "JMSTranslationBundle:Translate:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  237 => 104,  234 => 103,  232 => 102,  216 => 96,  191 => 82,  172 => 73,  153 => 70,  148 => 67,  124 => 61,  100 => 56,  97 => 55,  76 => 5,  104 => 50,  70 => 27,  34 => 7,  110 => 41,  23 => 1,  188 => 81,  185 => 41,  181 => 44,  170 => 39,  161 => 36,  129 => 64,  118 => 23,  90 => 30,  65 => 22,  53 => 10,  480 => 162,  474 => 161,  469 => 158,  461 => 155,  457 => 153,  453 => 151,  444 => 149,  440 => 148,  437 => 147,  435 => 146,  430 => 144,  427 => 143,  423 => 142,  413 => 134,  409 => 132,  407 => 131,  402 => 130,  398 => 129,  393 => 126,  387 => 122,  384 => 121,  381 => 120,  379 => 119,  374 => 116,  368 => 112,  365 => 111,  362 => 110,  360 => 109,  355 => 106,  341 => 105,  337 => 103,  322 => 101,  314 => 99,  312 => 98,  309 => 97,  305 => 95,  298 => 91,  294 => 90,  285 => 89,  283 => 88,  278 => 86,  268 => 85,  264 => 84,  258 => 81,  252 => 80,  247 => 78,  241 => 77,  229 => 101,  220 => 70,  214 => 95,  177 => 76,  169 => 60,  140 => 55,  132 => 51,  128 => 49,  107 => 12,  61 => 13,  273 => 96,  269 => 94,  254 => 92,  243 => 88,  240 => 86,  238 => 85,  235 => 74,  230 => 82,  227 => 100,  224 => 99,  221 => 98,  219 => 97,  217 => 75,  208 => 68,  204 => 72,  179 => 77,  159 => 61,  143 => 31,  135 => 29,  119 => 42,  102 => 36,  71 => 27,  67 => 22,  63 => 21,  59 => 22,  38 => 11,  94 => 54,  89 => 20,  85 => 25,  75 => 24,  68 => 14,  56 => 17,  87 => 21,  21 => 2,  26 => 12,  93 => 46,  88 => 50,  78 => 21,  46 => 13,  27 => 5,  44 => 12,  31 => 6,  28 => 5,  201 => 89,  196 => 90,  183 => 82,  171 => 61,  166 => 71,  163 => 62,  158 => 67,  156 => 35,  151 => 34,  142 => 59,  138 => 54,  136 => 56,  121 => 46,  117 => 44,  105 => 58,  91 => 40,  62 => 23,  49 => 14,  24 => 7,  25 => 3,  19 => 1,  79 => 18,  72 => 16,  69 => 24,  47 => 10,  40 => 8,  37 => 7,  22 => 3,  246 => 90,  157 => 71,  145 => 46,  139 => 45,  131 => 52,  123 => 47,  120 => 24,  115 => 43,  111 => 37,  108 => 36,  101 => 5,  98 => 35,  96 => 31,  83 => 18,  74 => 14,  66 => 15,  55 => 20,  52 => 16,  50 => 10,  43 => 12,  41 => 8,  35 => 8,  32 => 4,  29 => 3,  209 => 92,  203 => 78,  199 => 67,  193 => 83,  189 => 71,  187 => 84,  182 => 78,  176 => 40,  173 => 65,  168 => 72,  164 => 59,  162 => 57,  154 => 58,  149 => 51,  147 => 33,  144 => 49,  141 => 48,  133 => 65,  130 => 41,  125 => 25,  122 => 43,  116 => 41,  112 => 21,  109 => 59,  106 => 36,  103 => 32,  99 => 31,  95 => 25,  92 => 24,  86 => 29,  82 => 9,  80 => 32,  73 => 19,  64 => 17,  60 => 18,  57 => 12,  54 => 15,  51 => 15,  48 => 12,  45 => 9,  42 => 9,  39 => 7,  36 => 7,  33 => 6,  30 => 2,);
    }
}
