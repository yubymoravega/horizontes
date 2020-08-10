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
class __TwigTemplate_b68f5557ba82b5c28e2561d1b2850fa36a043c26e0f6d038bbe9b403a33a96c9 extends Template
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
        $this->parent = $this->loadTemplate("base.html.twig", "home/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
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
    }

    // line 11
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 12
        echo "   
           <script src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/carousel.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
    ";
    }

    // line 16
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
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
                    
                     <input type=\"text\" id=\"tel\" name=\"tel\" class=\"form-control\" placeholder=\"No. De Telefono\" autocomplete=\"off\" required/>
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
        return array (  165 => 75,  163 => 74,  149 => 63,  142 => 59,  135 => 55,  99 => 21,  97 => 20,  92 => 17,  88 => 16,  82 => 13,  79 => 12,  75 => 11,  69 => 8,  65 => 7,  61 => 6,  57 => 5,  52 => 4,  48 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "home/index.html.twig", "/var/www/html/horizontes/templates/home/index.html.twig");
    }
}
