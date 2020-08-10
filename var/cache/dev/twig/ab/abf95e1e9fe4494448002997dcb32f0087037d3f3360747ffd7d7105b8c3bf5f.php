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

/* home/index.html.twig */
class __TwigTemplate_5feee9be8590f57bb7316c4de817d23c8645242b55518d4a40cc65d0333ebdf4 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'javascripts' => [$this, 'block_javascripts'],
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "home/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "home/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "home/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 4
        echo "        <link href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/favicon.ico"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"icon\" />
        <link href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/carousel.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style-sunset.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("//fonts.googleapis.com/css?family=Montserrat:400,700%7CLato:300,300italic,400,700,900%7CYesteryear"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 12
        echo "   
           <script src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/carousel.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 16
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 17
        echo "<!DOCTYPE html>
<html class=\"wide wow-animation scrollTo\" lang=\"en\">

";
        // line 20
        $this->loadTemplate("layout/header.html", "home/index.html.twig", 20)->display($context);
        // line 21
        echo "
      <!-- Classic Breadcrumbs-->
      <section class=\"section novi-background \">
         <div class=\"row form justify-content-md-center text-left\" style=\"margin-top: 0px;\">
            <div class=\"col-md-7 col-lg-4\">
              <form name=\"form-telefono\" method=\"POST\"  id=\"form-telefono\" action=\"cliente-index\" >
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm \">
                  <span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\">
                  <span class=\"novi-icon mdi mdi-phone\"></span></span></span>
                    
                     <input  type=\"text\" id=\"tel\" name=\"tel\" class=\"form-control\" placeholder=\"No. De Telefono\" autocomplete=\"off\" required />
                     <button id=\"submit\" type=\"submit\" class=\"btn-sm btn-default btn \">Continuar</button>  
                     
                </div>
                </div>
         
            </form>
       
            </div>
          </div>

          <hr class=\"hr bg-gray\">
        
      </section>


      <!-- What we do-->
      <section class=\"section novi-background section-98 section-sm-110 carousel1\">
        <div class=\"container\">
        
        <div id=\"carousel\">

       <div class=\"hideLeft\">
        <img src=\"";
        // line 55
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/combo-carne.jpg"), "html", null, true);
        echo "\">
      </div>

      <div class=\"prevLeftSecond\">
        <img src=\"";
        // line 59
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/cubacel.jpg"), "html", null, true);
        echo "\">
      </div>

      <div class=\"prev\">
        <img src=\"";
        // line 63
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/promocion.jpg"), "html", null, true);
        echo "\">
      </div>

    </div>

    <div class=\"buttons\">
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"prev\">Anterior</button>
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"next\">Siguiente</button>
    </div>
        </div>
      </section>
     ";
        // line 74
        $this->loadTemplate("layout/footer.html", "home/index.html.twig", 74)->display($context);
        // line 75
        echo "  </body>
</html>

<script>

\$('#tel').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});

document.addEventListener(\"DOMContentLoaded\", function() {
    var elements = document.getElementsByTagName(\"INPUT\");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity(\"\");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(\"Numero De Telefono!\");
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
        return "home/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  207 => 75,  205 => 74,  191 => 63,  184 => 59,  177 => 55,  141 => 21,  139 => 20,  134 => 17,  124 => 16,  112 => 13,  109 => 12,  99 => 11,  87 => 8,  83 => 7,  79 => 6,  75 => 5,  70 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block stylesheets %}
        <link href=\"{{ asset('images/favicon.ico') }}\" type=\"text/css\" rel=\"icon\" />
        <link href=\"{{ asset('css/carousel.css') }}\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"{{ asset('css/style.css') }}\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"{{ asset('css/style-sunset.css') }}\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"{{ asset('//fonts.googleapis.com/css?family=Montserrat:400,700%7CLato:300,300italic,400,700,900%7CYesteryear') }}\" type=\"text/css\" rel=\"stylesheet\" />
{% endblock %}

   {% block javascripts %}
   
           <script src=\"{{ asset('js/carousel.js') }}\" type=\"text/javascript\"></script>
    {% endblock %}

{% block body %}
<!DOCTYPE html>
<html class=\"wide wow-animation scrollTo\" lang=\"en\">

{% include 'layout/header.html' %}

      <!-- Classic Breadcrumbs-->
      <section class=\"section novi-background \">
         <div class=\"row form justify-content-md-center text-left\" style=\"margin-top: 0px;\">
            <div class=\"col-md-7 col-lg-4\">
              <form name=\"form-telefono\" method=\"POST\"  id=\"form-telefono\" action=\"cliente-index\" >
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm \">
                  <span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\">
                  <span class=\"novi-icon mdi mdi-phone\"></span></span></span>
                    
                     <input  type=\"text\" id=\"tel\" name=\"tel\" class=\"form-control\" placeholder=\"No. De Telefono\" autocomplete=\"off\" required />
                     <button id=\"submit\" type=\"submit\" class=\"btn-sm btn-default btn \">Continuar</button>  
                     
                </div>
                </div>
         
            </form>
       
            </div>
          </div>

          <hr class=\"hr bg-gray\">
        
      </section>


      <!-- What we do-->
      <section class=\"section novi-background section-98 section-sm-110 carousel1\">
        <div class=\"container\">
        
        <div id=\"carousel\">

       <div class=\"hideLeft\">
        <img src=\"{{ asset('images/combo-carne.jpg') }}\">
      </div>

      <div class=\"prevLeftSecond\">
        <img src=\"{{ asset('images/cubacel.jpg') }}\">
      </div>

      <div class=\"prev\">
        <img src=\"{{ asset('images/promocion.jpg') }}\">
      </div>

    </div>

    <div class=\"buttons\">
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"prev\">Anterior</button>
      <button class=\"btn-aqil-effect-mod-1 btn-default btn btn-aqil-effect\" id=\"next\">Siguiente</button>
    </div>
        </div>
      </section>
     {% include 'layout/footer.html' %}
  </body>
</html>

<script>

\$('#tel').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});

document.addEventListener(\"DOMContentLoaded\", function() {
    var elements = document.getElementsByTagName(\"INPUT\");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity(\"\");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity(\"Numero De Telefono!\");
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity(\"\");
        };
    }
})

</script>

{% endblock %}

", "home/index.html.twig", "/var/www/html/horizontes/templates/home/index.html.twig");
    }
}
