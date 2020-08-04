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

/* api/listado.html.twig */
class __TwigTemplate_65ef2d4a3432d292777ea8b85ac620b7bea80bbea8a68bf363e87c7299211a7b extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/listado.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/listado.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "api/listado.html.twig", 1);
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
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\" />
    <title>Accept a card payment</title>
    <meta name=\"description\" content=\"A demo of a card payment on Stripe\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />

    <link rel=\"stylesheet\" href=\"global.css\" />
  
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
  </head>

  <body style=\"background-color: black;\">
    <!-- Display a payment form -->
    <form id=\"payment-form\" name='payment-form' action=\"guardar-monto.php\" method=\"POST\" style=\"border: 1px solid #fff;  box-shadow: 0px 0px 11px 11px #ffffff36;\">
      <label style=\"float: left; margin-top: 4px; color: white; padding-bottom: 10px;\">Monto A Cobrar</label>
      <input autocomplete=\"off\" name='monto' type=\"text\" id=\"monto\" placeholder=\"0.00\" required/>

      <button id=\"submit\" type=\"submit\" style=\"    margin-left: 70px; margin-top: 11px; width: 65%;\">
        <div class=\"spinner hidden\" id=\"spinner\"></div>
        <span id=\"button-text\">Pagar</span>
      </button>
     
    </form>
  </body>
</html>

<script>

\$('#monto').on('input', function () { 
    this.value = this.value.replace(/[^0-9-.]/g,'');
});

document.addEventListener(\"DOMContentLoaded\", function() {
    var elements = document.getElementsByTagName(\"INPUT\");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity(\"\");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(\"Introduce Una Cantidad Exacta!\");
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
        return "api/listado.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 4,  58 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block body %}

<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\" />
    <title>Accept a card payment</title>
    <meta name=\"description\" content=\"A demo of a card payment on Stripe\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />

    <link rel=\"stylesheet\" href=\"global.css\" />
  
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
  </head>

  <body style=\"background-color: black;\">
    <!-- Display a payment form -->
    <form id=\"payment-form\" name='payment-form' action=\"guardar-monto.php\" method=\"POST\" style=\"border: 1px solid #fff;  box-shadow: 0px 0px 11px 11px #ffffff36;\">
      <label style=\"float: left; margin-top: 4px; color: white; padding-bottom: 10px;\">Monto A Cobrar</label>
      <input autocomplete=\"off\" name='monto' type=\"text\" id=\"monto\" placeholder=\"0.00\" required/>

      <button id=\"submit\" type=\"submit\" style=\"    margin-left: 70px; margin-top: 11px; width: 65%;\">
        <div class=\"spinner hidden\" id=\"spinner\"></div>
        <span id=\"button-text\">Pagar</span>
      </button>
     
    </form>
  </body>
</html>

<script>

\$('#monto').on('input', function () { 
    this.value = this.value.replace(/[^0-9-.]/g,'');
});

document.addEventListener(\"DOMContentLoaded\", function() {
    var elements = document.getElementsByTagName(\"INPUT\");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity(\"\");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(\"Introduce Una Cantidad Exacta!\");
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity(\"\");
        };
    }
})

</script>

{% endblock %}
", "api/listado.html.twig", "/var/www/html/horizontes/templates/api/listado.html.twig");
    }
}
