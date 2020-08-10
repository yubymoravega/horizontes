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

/* api/security.html.twig */
class __TwigTemplate_f56a009204d66e7017dd896b8cad7b086627ac349f2d317bf7542ac33b5590d7 extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/security.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "api/security.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "api/security.html.twig", 1);
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
  
    <div> 
     <h2 style=\"font-weight: 500; text-align: center; \"> Cliente: ";
        // line 29
        echo twig_escape_filter($this->env, (isset($context["nombre"]) || array_key_exists("nombre", $context) ? $context["nombre"] : (function () { throw new RuntimeError('Variable "nombre" does not exist.', 29, $this->source); })()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["apellido"]) || array_key_exists("apellido", $context) ? $context["apellido"] : (function () { throw new RuntimeError('Variable "apellido" does not exist.', 29, $this->source); })()), "html", null, true);
        echo "</h2> 
    <h2 style=\"font-weight: 500; text-align: center; \">A cobrar: \$";
        // line 30
        echo twig_escape_filter($this->env, (isset($context["monto"]) || array_key_exists("monto", $context) ? $context["monto"] : (function () { throw new RuntimeError('Variable "monto" does not exist.', 30, $this->source); })()), "html", null, true);
        echo "</h2> 
    
    </div>
    <div id='credit' class=\"credit-card ";
        // line 33
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["tarjeta"]) || array_key_exists("tarjeta", $context) ? $context["tarjeta"] : (function () { throw new RuntimeError('Variable "tarjeta" does not exist.', 33, $this->source); })()), "brand", [], "any", false, false, false, 33), "html", null, true);
        echo " selectable\">
        <div class=\"credit-card-last4\">
           ";
        // line 35
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["tarjeta"]) || array_key_exists("tarjeta", $context) ? $context["tarjeta"] : (function () { throw new RuntimeError('Variable "tarjeta" does not exist.', 35, $this->source); })()), "last4", [], "any", false, false, false, 35), "html", null, true);
        echo "
        </div>
        <div class=\"credit-card-expiry\">
            ";
        // line 38
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["tarjeta"]) || array_key_exists("tarjeta", $context) ? $context["tarjeta"] : (function () { throw new RuntimeError('Variable "tarjeta" does not exist.', 38, $this->source); })()), "exp_month", [], "any", false, false, false, 38), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["tarjeta"]) || array_key_exists("tarjeta", $context) ? $context["tarjeta"] : (function () { throw new RuntimeError('Variable "tarjeta" does not exist.', 38, $this->source); })()), "exp_year", [], "any", false, false, false, 38), "html", null, true);
        echo "
        </div>
    </div>
 
    <div> <hr/>
     <h1 style=\"font-weight: 500; text-align: center; \">Procesar Cobro</h1>
    
     <a class='pagar' href=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("confirm", ["tel" => (isset($context["tel"]) || array_key_exists("tel", $context) ? $context["tel"] : (function () { throw new RuntimeError('Variable "tel" does not exist.', 45, $this->source); })()), "monto" => (isset($context["monto"]) || array_key_exists("monto", $context) ? $context["monto"] : (function () { throw new RuntimeError('Variable "monto" does not exist.', 45, $this->source); })()), "last4" => twig_get_attribute($this->env, $this->source, (isset($context["tarjeta"]) || array_key_exists("tarjeta", $context) ? $context["tarjeta"] : (function () { throw new RuntimeError('Variable "tarjeta" does not exist.', 45, $this->source); })()), "last4", [], "any", false, false, false, 45)]), "html", null, true);
        echo "\">
        Confirmar
    </a>
  

  <style>
  
  .pagar {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 18px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left: 40%;
}
  
  </style>

 </div>
 
  </body>
</html>


";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "api/security.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 45,  121 => 38,  115 => 35,  110 => 33,  104 => 30,  98 => 29,  78 => 12,  68 => 4,  58 => 3,  35 => 1,);
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
  
    <div> 
     <h2 style=\"font-weight: 500; text-align: center; \"> Cliente: {{nombre}} {{apellido}}</h2> 
    <h2 style=\"font-weight: 500; text-align: center; \">A cobrar: \${{monto}}</h2> 
    
    </div>
    <div id='credit' class=\"credit-card {{tarjeta.brand}} selectable\">
        <div class=\"credit-card-last4\">
           {{tarjeta.last4}}
        </div>
        <div class=\"credit-card-expiry\">
            {{tarjeta.exp_month}}/{{tarjeta.exp_year}}
        </div>
    </div>
 
    <div> <hr/>
     <h1 style=\"font-weight: 500; text-align: center; \">Procesar Cobro</h1>
    
     <a class='pagar' href=\"{{ path('confirm', {'tel': tel, 'monto': monto, 'last4':tarjeta.last4 })}}\">
        Confirmar
    </a>
  

  <style>
  
  .pagar {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 18px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left: 40%;
}
  
  </style>

 </div>
 
  </body>
</html>


{% endblock %}
", "api/security.html.twig", "/var/www/html/horizontes/templates/api/security.html.twig");
    }
}
