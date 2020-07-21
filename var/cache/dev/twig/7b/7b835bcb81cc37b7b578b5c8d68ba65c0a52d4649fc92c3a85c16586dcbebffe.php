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
            <section style=\"padding:25px;\" class=\"section novi-background section-66 context-dark bg-dark fixed-top\">
              <div class=\"container\">

              <div class=\"row\"> 

              <div class=\"col-lg-8\" style=\"text-align: left !important;\">
              
                <div style=\" min-height: 34px; margin-left: 80px;\">
                 <span class=\"novi-icon fa fa-shopping-cart icon-sm logo-azul\"></span>  

                  <span style=\"font-size: x-large; margin: 10px; color:#FFF;\"> \$ 50.00 </span>
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
    
      <!-- Skills  slider-->
      <section class=\"section novi-background   section-lg-200  bg-lighter\">
        <div class=\"container\">
       
       <div class=\"row justify-content-md-center text-left\">
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
      </section>

    


      <!-- Skills  slider-->
      <section class=\"section novi-background   section-lg-200  bg-lighter\">
       
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
      <button id=\"prev\">Prev</button>
      <button id=\"next\">Next</button>
    </div>
       
          <hr class=\"hr bg-gray\">
  
        </div>
      </section>

          

        <footer class=\"section novi-background section-relative section-34 page-footer bg-black context-dark\">
        <div class=\"container\">
          <div class=\"row justify-content-md-center text-xl-center\">
            <div class=\"col-sm-12 col-lg-4\">
              <!-- Footer brand-->
              <div class=\"footer-brand\"><a href=\"index.html\"><img style='margin-top: -5px;margin-left: -15px;  width: 40%;'  src=\" ";
        // line 115
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo_grupo_horizontes.png"), "html", null, true);
        echo " \" alt=''/></a></div>
              <p class=\"small text-darker offset-top-4\">&copy; <span class=\"copyright-year\"> </span>  Grupo Horizontes
               
              </p>
            </div>
          </div>
        </div>
      </footer>
    ";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "layout/body.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 115,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!-- Call to action type 2-->
            <section style=\"padding:25px;\" class=\"section novi-background section-66 context-dark bg-dark fixed-top\">
              <div class=\"container\">

              <div class=\"row\"> 

              <div class=\"col-lg-8\" style=\"text-align: left !important;\">
              
                <div style=\" min-height: 34px; margin-left: 80px;\">
                 <span class=\"novi-icon fa fa-shopping-cart icon-sm logo-azul\"></span>  

                  <span style=\"font-size: x-large; margin: 10px; color:#FFF;\"> \$ 50.00 </span>
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
    
      <!-- Skills  slider-->
      <section class=\"section novi-background   section-lg-200  bg-lighter\">
        <div class=\"container\">
       
       <div class=\"row justify-content-md-center text-left\">
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
      </section>

    


      <!-- Skills  slider-->
      <section class=\"section novi-background   section-lg-200  bg-lighter\">
       
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
      <button id=\"prev\">Prev</button>
      <button id=\"next\">Next</button>
    </div>
       
          <hr class=\"hr bg-gray\">
  
        </div>
      </section>

          

        <footer class=\"section novi-background section-relative section-34 page-footer bg-black context-dark\">
        <div class=\"container\">
          <div class=\"row justify-content-md-center text-xl-center\">
            <div class=\"col-sm-12 col-lg-4\">
              <!-- Footer brand-->
              <div class=\"footer-brand\"><a href=\"index.html\"><img style='margin-top: -5px;margin-left: -15px;  width: 40%;'  src=\" {{ asset('images/logo_grupo_horizontes.png') }} \" alt=''/></a></div>
              <p class=\"small text-darker offset-top-4\">&copy; <span class=\"copyright-year\"> </span>  Grupo Horizontes
               
              </p>
            </div>
          </div>
        </div>
      </footer>
    ", "layout/body.html.twig", "/var/www/html/horizontes/templates/layout/body.html.twig");
    }
}
