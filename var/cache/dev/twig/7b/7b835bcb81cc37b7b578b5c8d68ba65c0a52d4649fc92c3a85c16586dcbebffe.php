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

/* layout/body.html.twig */
class __TwigTemplate_9fbf429ceeeb7e3beb60d90c78ab1e737d29b083f0101c5783e12c551a13c2f0 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/body.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/body.html.twig"));

        // line 1
        echo "<!-- Call to action type 2-->
            <section style=\"padding:25px;\" class=\"section novi-background section-66 context-dark bg-dark\">
              <div class=\"container\">

              <div class=\"row\"> 

              <div class=\"col-lg-8\" style=\"text-align: left !important;\">
              
                <div style=\" min-height: 34px; margin-left: 80px;\">
                 <span class=\"novi-icon fa fa-shopping-cart icon-sm text-carrot\"></span>  
              
                  <span style=\"font-size: x-large; margin: 10px; color:#00b4cd;\"> \$ 50.00 </span>
                  </div> 

              </div>

            <div class=\"col-lg-1\">  
               <span class=\"novi-icon mdi mdi-headset icon-sm logo-azul\"></span> 
            </div>

            <div class=\"col-lg-1\"> 
               <span class=\"novi-icon fa fa-bell icon-sm logo-azul\"></span> 
            </div>

            <div class=\"col-lg-1\">
              <span class=\"novi-icon fa fa-user icon-sm logo-azul\"></span> 
            </div>

              </div>
            
            </div>
            </section>

      
    ";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "layout/body.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!-- Call to action type 2-->
            <section style=\"padding:25px;\" class=\"section novi-background section-66 context-dark bg-dark\">
              <div class=\"container\">

              <div class=\"row\"> 

              <div class=\"col-lg-8\" style=\"text-align: left !important;\">
              
                <div style=\" min-height: 34px; margin-left: 80px;\">
                 <span class=\"novi-icon fa fa-shopping-cart icon-sm text-carrot\"></span>  
              
                  <span style=\"font-size: x-large; margin: 10px; color:#00b4cd;\"> \$ 50.00 </span>
                  </div> 

              </div>

            <div class=\"col-lg-1\">  
               <span class=\"novi-icon mdi mdi-headset icon-sm logo-azul\"></span> 
            </div>

            <div class=\"col-lg-1\"> 
               <span class=\"novi-icon fa fa-bell icon-sm logo-azul\"></span> 
            </div>

            <div class=\"col-lg-1\">
              <span class=\"novi-icon fa fa-user icon-sm logo-azul\"></span> 
            </div>

              </div>
            
            </div>
            </section>

      
    ", "layout/body.html.twig", "/var/www/html/horizontes/templates/layout/body.html.twig");
    }
}
