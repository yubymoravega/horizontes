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

/* api/select.html.twig */
class __TwigTemplate_b4a8a859fb7fcb96ce440dc1e032b8602983b7a6e740c34ec81fd13b976841b5 extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/select.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/select.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "api/select.html.twig", 1);
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
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/tarjetas.css"), "html", null, true);
        echo "\"  />
   

    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
  </head>

  <body style=\"background-color: black;\">
<style>
    body {
        background: #6609f2;
    }
</style>
<link href=\"https://fonts.googleapis.com/css2?family=PT+Mono&display=swap\" rel=\"stylesheet\">

<div style='margin: auto; width: 400px; max-width: 95vw; font-family: \"Helvetica Neue\", Helvetica, sans-serif; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); padding: 10px; margin-top: 50px; margin-bottom: 50px; border-radius: 15px; background: #f9fcff;'>
    <h1 style=\"font-weight: 500; text-align: center; \">Tarjetas Guardadas</h1>

    <!--
INFO: The selectable class adds a pointer and shadow animations on hover.
-->

    <!-- Cards -->

    <!-- Visa - selectable -->
    <div id='credit' class=\"credit-card visa selectable\">
        <div class=\"credit-card-last4\">
           ";
        // line 38
        echo twig_escape_filter($this->env, (isset($context["last4"]) || array_key_exists("last4", $context) ? $context["last4"] : (function () { throw new RuntimeError('Variable "last4" does not exist.', 38, $this->source); })()), "html", null, true);
        echo "
        </div>
        <div class=\"credit-card-expiry\">
            ";
        // line 41
        echo twig_escape_filter($this->env, (isset($context["exp_month"]) || array_key_exists("exp_month", $context) ? $context["exp_month"] : (function () { throw new RuntimeError('Variable "exp_month" does not exist.', 41, $this->source); })()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, (isset($context["exp_year"]) || array_key_exists("exp_year", $context) ? $context["exp_year"] : (function () { throw new RuntimeError('Variable "exp_year" does not exist.', 41, $this->source); })()), "html", null, true);
        echo "
        </div>
    </div>
 
 
  </body>
</html>

<script>


\$( \".credit-card\" ).click(function() {
  \$(location).attr('href','api.form";
        // line 53
        echo twig_escape_filter($this->env, (isset($context["tel"]) || array_key_exists("tel", $context) ? $context["tel"] : (function () { throw new RuntimeError('Variable "tel" does not exist.', 53, $this->source); })()), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, (isset($context["monto"]) || array_key_exists("monto", $context) ? $context["monto"] : (function () { throw new RuntimeError('Variable "monto" does not exist.', 53, $this->source); })()), "html", null, true);
        echo "');
});



</script>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "api/select.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  130 => 53,  113 => 41,  107 => 38,  78 => 12,  68 => 4,  58 => 3,  35 => 1,);
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
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
    <link rel=\"stylesheet\" href=\"{{ asset('css/tarjetas.css') }}\"  />
   

    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
  </head>

  <body style=\"background-color: black;\">
<style>
    body {
        background: #6609f2;
    }
</style>
<link href=\"https://fonts.googleapis.com/css2?family=PT+Mono&display=swap\" rel=\"stylesheet\">

<div style='margin: auto; width: 400px; max-width: 95vw; font-family: \"Helvetica Neue\", Helvetica, sans-serif; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); padding: 10px; margin-top: 50px; margin-bottom: 50px; border-radius: 15px; background: #f9fcff;'>
    <h1 style=\"font-weight: 500; text-align: center; \">Tarjetas Guardadas</h1>

    <!--
INFO: The selectable class adds a pointer and shadow animations on hover.
-->

    <!-- Cards -->

    <!-- Visa - selectable -->
    <div id='credit' class=\"credit-card visa selectable\">
        <div class=\"credit-card-last4\">
           {{last4}}
        </div>
        <div class=\"credit-card-expiry\">
            {{exp_month}}/{{exp_year}}
        </div>
    </div>
 
 
  </body>
</html>

<script>


\$( \".credit-card\" ).click(function() {
  \$(location).attr('href','api.form{{tel}}/{{monto}}');
});



</script>

{% endblock %}", "api/select.html.twig", "/var/www/html/horizontes/templates/api/select.html.twig");
    }
}
