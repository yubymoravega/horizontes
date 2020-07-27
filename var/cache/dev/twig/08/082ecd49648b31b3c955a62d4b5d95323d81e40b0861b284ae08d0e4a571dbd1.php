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

/* cliente/registrar.html.twig */
class __TwigTemplate_2d1d2c9f012f2ec1d4bcac8fc899107ca735188994b9832917ab4042baa28bbf extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "cliente/registrar.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "cliente/registrar.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "cliente/registrar.html.twig", 1);
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
        echo "        <script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/core.min.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
         <script src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/script.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
          <script src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/revolution.min.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
           <script src=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/carousel.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 18
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 19
        echo "<!DOCTYPE html>
<html class=\"wide wow-animation scrollTo\" lang=\"en\">

";
        // line 22
        $this->loadTemplate("layout/header.html", "cliente/registrar.html.twig", 22)->display($context);
        // line 23
        echo "
  ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 24, $this->source); })()), "flashes", [0 => "mensaje"], "method", false, false, false, 24));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 25
            echo "             <div class=\"alert alert-danger row justify-content-md-center\">
                ";
            // line 26
            echo twig_escape_filter($this->env, $context["message"], "html", null, true);
            echo "
            </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "
          <!-- Section Input Groups-->
      <section class=\"section novi-background section-20\">
        <div class=\"container\">
          <h1>Registro Del Cliente</h1>
          <hr class=\"divider divider-sm bg-mantis\">
          <div class=\"row justify-content-md-center text-left\">
            <div class=\"col-md-7 col-lg-4\">

            ";
        // line 38
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 38, $this->source); })()), 'form_start', ["attr" => ["class" => "rd-mailform"]]);
        echo "
       
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-cellphone-iphone\"></span></span></span>
                
                  ";
        // line 43
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 43, $this->source); })()), "telefono", [], "any", false, false, false, 43), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Telefono"]]);
        echo "
 
                    <span class=\"input-group-append\">
                      
                  </div>
                </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-user-plus\"></span></span></span>
                 
                 ";
        // line 53
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 53, $this->source); })()), "nombre", [], "any", false, false, false, 53), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Nombre"]]);
        echo "

                <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-users\"></span></span></span>
                  
                   ";
        // line 63
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 63, $this->source); })()), "apellidos", [], "any", false, false, false, 63), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Apellido"]]);
        echo "
                 
                  <span class=\"input-group-append\">                    
                
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-email\"></span></span></span>
                 
                 ";
        // line 73
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 73, $this->source); })()), "correo", [], "any", false, false, false, 73), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Correo Electronico"]]);
        echo "
                    
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-map-marker\"></span></span></span>
                 
                   ";
        // line 83
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 83, $this->source); })()), "direccion", [], "any", false, false, false, 83), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Direccion"]]);
        echo "
         
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-book\"></span></span></span>
                      

                  ";
        // line 94
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 94, $this->source); })()), "comentario", [], "any", false, false, false, 94), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Comentario"]]);
        echo "
                  
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>


                <div class=\"form-output\" id=\"components-form-subscribe-footer\"></div>

                <div class=\" row justify-content-md-center group offset-top-34\">
                 
           ";
        // line 106
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 106, $this->source); })()), "continuar", [], "any", false, false, false, 106), 'row');
        echo "
            
        
          </div>

              ";
        // line 111
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 111, $this->source); })()), 'form_end');
        echo "


            </div>
          </div>
        </div>
      </section>
     ";
        // line 118
        $this->loadTemplate("layout/footer.html", "cliente/registrar.html.twig", 118)->display($context);
        // line 119
        echo "  </body>
</html>

<script>

// A \$( document ).ready() block.
\$( document ).ready(function() {
 \$( \"#cliente_continuar\" ).append( \"<span class ='icon novi-icon mdi mdi-emoticon btn-icon-right' ></span>\" );
});
</script>


";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "cliente/registrar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  290 => 119,  288 => 118,  278 => 111,  270 => 106,  255 => 94,  241 => 83,  228 => 73,  215 => 63,  202 => 53,  189 => 43,  181 => 38,  170 => 29,  161 => 26,  158 => 25,  154 => 24,  151 => 23,  149 => 22,  144 => 19,  134 => 18,  122 => 15,  118 => 14,  114 => 13,  109 => 12,  99 => 11,  87 => 8,  83 => 7,  79 => 6,  75 => 5,  70 => 4,  60 => 3,  37 => 1,);
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
        <script src=\"{{ asset('js/core.min.js') }}\" type=\"text/javascript\"></script>
         <script src=\"{{ asset('js/script.js') }}\" type=\"text/javascript\"></script>
          <script src=\"{{ asset('js/revolution.min.js') }}\" type=\"text/javascript\"></script>
           <script src=\"{{ asset('js/carousel.js') }}\" type=\"text/javascript\"></script>
    {% endblock %}

{% block body %}
<!DOCTYPE html>
<html class=\"wide wow-animation scrollTo\" lang=\"en\">

{% include 'layout/header.html' %}

  {% for message in app.flashes('mensaje') %}
             <div class=\"alert alert-danger row justify-content-md-center\">
                {{ message }}
            </div>
        {% endfor %}

          <!-- Section Input Groups-->
      <section class=\"section novi-background section-20\">
        <div class=\"container\">
          <h1>Registro Del Cliente</h1>
          <hr class=\"divider divider-sm bg-mantis\">
          <div class=\"row justify-content-md-center text-left\">
            <div class=\"col-md-7 col-lg-4\">

            {{ form_start(formulario,{'attr': {'class': 'rd-mailform'}}) }}
       
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-cellphone-iphone\"></span></span></span>
                
                  {{ form_widget(formulario.telefono, {'attr': {'class': 'form-control','placeholder': 'Telefono'}}) }}
 
                    <span class=\"input-group-append\">
                      
                  </div>
                </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-user-plus\"></span></span></span>
                 
                 {{ form_widget(formulario.nombre, {'attr': {'class': 'form-control','placeholder': 'Nombre'}}) }}

                <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-users\"></span></span></span>
                  
                   {{ form_widget(formulario.apellidos, {'attr': {'class': 'form-control','placeholder': 'Apellido'}}) }}
                 
                  <span class=\"input-group-append\">                    
                
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-email\"></span></span></span>
                 
                 {{ form_widget(formulario.correo, {'attr': {'class': 'form-control','placeholder': 'Correo Electronico'}}) }}
                    
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-map-marker\"></span></span></span>
                 
                   {{ form_widget(formulario.direccion, {'attr': {'class': 'form-control','placeholder': 'Direccion'}}) }}
         
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-book\"></span></span></span>
                      

                  {{ form_widget(formulario.comentario, {'attr': {'class': 'form-control','placeholder': 'Comentario'}}) }}
                  
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>


                <div class=\"form-output\" id=\"components-form-subscribe-footer\"></div>

                <div class=\" row justify-content-md-center group offset-top-34\">
                 
           {{ form_row(formulario.continuar) }}
            
        
          </div>

              {{ form_end(formulario) }}


            </div>
          </div>
        </div>
      </section>
     {% include 'layout/footer.html' %}
  </body>
</html>

<script>

// A \$( document ).ready() block.
\$( document ).ready(function() {
 \$( \"#cliente_continuar\" ).append( \"<span class ='icon novi-icon mdi mdi-emoticon btn-icon-right' ></span>\" );
});
</script>


{% endblock %}

", "cliente/registrar.html.twig", "/var/www/html/horizontes/templates/cliente/registrar.html.twig");
    }
}
