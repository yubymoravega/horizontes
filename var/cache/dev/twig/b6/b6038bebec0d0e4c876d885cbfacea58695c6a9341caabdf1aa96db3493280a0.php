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

/* layout/body-home.html.twig */
class __TwigTemplate_eced264230a280e1e8f493b6ccf054d1fb1cfe023b59ec9a29dafafc13b8baf7 extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/body-home.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/body-home.html.twig"));

        // line 1
        echo "
<section class=\"section novi-background \">
        <div class=\"container section-34 section-sm-20\">
          <div class=\"row align-items-xl-center\">
            
              <div class=\"row form justify-content-md-center text-left\" style=\"margin-top: 0px;\">
            <div class=\"col-md-7 col-lg-4\">
              <form class=\"rd-mailform\" data-form-output=\"components-form-subscribe-footer\" data-form-type=\"subscribe\" method=\"post\" action=\"#\" novalidate=\"novalidate\">
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm \">
                  <span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\">
                  <span class=\"novi-icon mdi mdi-phone\"></span></span></span>
                    <input class=\"form-control\" placeholder=\"No. De Telefono\" type=\"text\" name=\"number\" id=\"regula-generated-367333\">
                    
                      <button class=\"btn btn-sm btn-primary\" style=\"background-color: black; border-color: black;\" type=\"submit\">Buscar</button></span>
                  </div>
                </div>
                <div class=\"form-output\" id=\"components-form-subscribe-footer\"></div>
              </form>
            </div>
          </div>

          <hr class=\"hr bg-gray\">

          </div>
        </div>
  
       
    
      <!-- What we do-->
      <section class=\"section novi-background section-98 section-sm-110 carousel1\">
        <div class=\"container\">
        
        <div id=\"carousel\">

       <div class=\"hideLeft\">
        <img src=\"https://i1.sndcdn.com/artworks-000165384395-rhrjdn-t500x500.jpg\">
      </div>

      <div class=\"prevLeftSecond\">
        <img src=\"https://i1.sndcdn.com/artworks-000185743981-tuesoj-t500x500.jpg\">
      </div>

      <div class=\"prev\">
        <img src=\"https://i1.sndcdn.com/artworks-000158708482-k160g1-t500x500.jpg\">
      </div>

      <div class=\"selected\">
        <img src=\"https://i1.sndcdn.com/artworks-000062423439-lf7ll2-t500x500.jpg\">
      </div>

      <div class=\"next\">
        <img src=\"https://i1.sndcdn.com/artworks-000028787381-1vad7y-t500x500.jpg\">
      </div>

      <div class=\"nextRightSecond\">
        <img src=\"https://i1.sndcdn.com/artworks-000108468163-dp0b6y-t500x500.jpg\">
      </div>

      <div class=\"hideRight\">
        <img src=\"https://i1.sndcdn.com/artworks-000064920701-xrez5z-t500x500.jpg\">
      </div>

    </div>

    <div class=\"buttons\">
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"prev\">Anterior</button>
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"next\">Siguiente</button>
    </div>
        </div>
      </section>
    ";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "layout/body-home.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("
<section class=\"section novi-background \">
        <div class=\"container section-34 section-sm-20\">
          <div class=\"row align-items-xl-center\">
            
              <div class=\"row form justify-content-md-center text-left\" style=\"margin-top: 0px;\">
            <div class=\"col-md-7 col-lg-4\">
              <form class=\"rd-mailform\" data-form-output=\"components-form-subscribe-footer\" data-form-type=\"subscribe\" method=\"post\" action=\"#\" novalidate=\"novalidate\">
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm \">
                  <span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\">
                  <span class=\"novi-icon mdi mdi-phone\"></span></span></span>
                    <input class=\"form-control\" placeholder=\"No. De Telefono\" type=\"text\" name=\"number\" id=\"regula-generated-367333\">
                    
                      <button class=\"btn btn-sm btn-primary\" style=\"background-color: black; border-color: black;\" type=\"submit\">Buscar</button></span>
                  </div>
                </div>
                <div class=\"form-output\" id=\"components-form-subscribe-footer\"></div>
              </form>
            </div>
          </div>

          <hr class=\"hr bg-gray\">

          </div>
        </div>
  
       
    
      <!-- What we do-->
      <section class=\"section novi-background section-98 section-sm-110 carousel1\">
        <div class=\"container\">
        
        <div id=\"carousel\">

       <div class=\"hideLeft\">
        <img src=\"https://i1.sndcdn.com/artworks-000165384395-rhrjdn-t500x500.jpg\">
      </div>

      <div class=\"prevLeftSecond\">
        <img src=\"https://i1.sndcdn.com/artworks-000185743981-tuesoj-t500x500.jpg\">
      </div>

      <div class=\"prev\">
        <img src=\"https://i1.sndcdn.com/artworks-000158708482-k160g1-t500x500.jpg\">
      </div>

      <div class=\"selected\">
        <img src=\"https://i1.sndcdn.com/artworks-000062423439-lf7ll2-t500x500.jpg\">
      </div>

      <div class=\"next\">
        <img src=\"https://i1.sndcdn.com/artworks-000028787381-1vad7y-t500x500.jpg\">
      </div>

      <div class=\"nextRightSecond\">
        <img src=\"https://i1.sndcdn.com/artworks-000108468163-dp0b6y-t500x500.jpg\">
      </div>

      <div class=\"hideRight\">
        <img src=\"https://i1.sndcdn.com/artworks-000064920701-xrez5z-t500x500.jpg\">
      </div>

    </div>

    <div class=\"buttons\">
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"prev\">Anterior</button>
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"next\">Siguiente</button>
    </div>
        </div>
      </section>
    ", "layout/body-home.html.twig", "/var/www/html/horizontes/templates/layout/body-home.html.twig");
    }
}
