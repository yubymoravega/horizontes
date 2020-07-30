<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* api/index.html.twig */
class __TwigTemplate_b92a28fe8a59640881660d5f67d849c89bf3c96d0efc3170bfd06b182b344efc extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "api/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "
<html lang=\"es\">
  <head>
    <meta charset=\"utf-8\" />
    <title>Accept a card payment</title>
    <meta name=\"description\" content=\"A demo of a card payment on Stripe\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />

    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/global.css"), "html", null, true);
        echo "\" />
    <script src=\"https://js.stripe.com/v3/\"></script>
    <script src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/client.js"), "html", null, true);
        echo "\" defer></script>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
  </head>

  <body>
    <!-- Display a payment form -->
    <form id=\"payment-form\">
      <input type=\"number\" id=\"monto\" style=\"border-color: green; text-align: center;\" disabled name='monto'placeholder=\"Monto a cobrar \$ 0.00\" />
      <div id=\"card-element\"><!--Stripe.js injects the Card Element--></div>
      
      <label style=\"margin-top: 20px;float: left; margin-left: 30px;\">Confirmar Pago</label>
      <input style=\"width: 5%; float: left; margin-top: 7px;\"  type=\"checkbox\" required id=\"check\" name=\"check\" value=\"check\">
      
      <button id=\"submit\" style=\"width: 35%; padding: 12px 0px; float: left; margin-top: 8px; margin-left: 70px;\">
        <div class=\"spinner hidden\" id=\"spinner\"></div>
        <span id=\"button-text\">Pagar</span>
      </button>
 
      <p id=\"card-error\" role=\"alert\"></p>
      <p class=\"result-message hidden\" style=\"line-height: 22px; font-size: 16px; float: left; width: 100%; color: green;\">
        Pago Completado
        <a href=\"\" target=\"_blank\"></a> 
      </p>

      <button id=\"cancelar\" style=\"margin-top: 16px;float: left;\">
        <div class=\"cancelar\" id=\"cancelar\"></div>
        <span id=\"cancelar-text\">Cancelar</span>
      </button>
    </form>
  </body>
</html>

<script>

\$( \"#cancelar\" ).click(function() {
  window.location.href = \"monto.html\";
   
});

\$('#monto').on('input', function () { 
    this.value = this.value.replace(/[^0-9-.]/g,'');
});

document.addEventListener(\"DOMContentLoaded\", function() {
    var elements = document.getElementsByTagName(\"INPUT\");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity(\"\");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(\"Estas Seguro De Procesar El Pago ?\");
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity(\"\");
        };
    }
})


</script>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "api/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  83 => 14,  78 => 12,  68 => 4,  58 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block body %}

<html lang=\"es\">
  <head>
    <meta charset=\"utf-8\" />
    <title>Accept a card payment</title>
    <meta name=\"description\" content=\"A demo of a card payment on Stripe\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />

    <link rel=\"stylesheet\" href=\"{{ asset('css/global.css') }}\" />
    <script src=\"https://js.stripe.com/v3/\"></script>
    <script src=\"{{ asset('js/client.js') }}\" defer></script>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
  </head>

  <body>
    <!-- Display a payment form -->
    <form id=\"payment-form\">
      <input type=\"number\" id=\"monto\" style=\"border-color: green; text-align: center;\" disabled name='monto'placeholder=\"Monto a cobrar \$ 0.00\" />
      <div id=\"card-element\"><!--Stripe.js injects the Card Element--></div>
      
      <label style=\"margin-top: 20px;float: left; margin-left: 30px;\">Confirmar Pago</label>
      <input style=\"width: 5%; float: left; margin-top: 7px;\"  type=\"checkbox\" required id=\"check\" name=\"check\" value=\"check\">
      
      <button id=\"submit\" style=\"width: 35%; padding: 12px 0px; float: left; margin-top: 8px; margin-left: 70px;\">
        <div class=\"spinner hidden\" id=\"spinner\"></div>
        <span id=\"button-text\">Pagar</span>
      </button>
 
      <p id=\"card-error\" role=\"alert\"></p>
      <p class=\"result-message hidden\" style=\"line-height: 22px; font-size: 16px; float: left; width: 100%; color: green;\">
        Pago Completado
        <a href=\"\" target=\"_blank\"></a> 
      </p>

      <button id=\"cancelar\" style=\"margin-top: 16px;float: left;\">
        <div class=\"cancelar\" id=\"cancelar\"></div>
        <span id=\"cancelar-text\">Cancelar</span>
      </button>
    </form>
  </body>
</html>

<script>

\$( \"#cancelar\" ).click(function() {
  window.location.href = \"monto.html\";
   
});

\$('#monto').on('input', function () { 
    this.value = this.value.replace(/[^0-9-.]/g,'');
});

document.addEventListener(\"DOMContentLoaded\", function() {
    var elements = document.getElementsByTagName(\"INPUT\");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity(\"\");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(\"Estas Seguro De Procesar El Pago ?\");
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity(\"\");
        };
    }
})


</script>

{% endblock %}
", "api/index.html.twig", "/var/www/html/horizontes/templates/api/index.html.twig");
    }
}
