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

/* cliente/editar.html.twig */
class __TwigTemplate_317ae95e3d82f8b5ddb5b2aaf8d6aac9260ba1d9150a4c62393c4187850c04ee extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "cliente/editar.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "cliente/editar.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "cliente/editar.html.twig", 1);
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
        $this->loadTemplate("layout/header.html", "cliente/editar.html.twig", 22)->display($context);
        // line 23
        echo "
<div id='error' class=\"alert alert-success row justify-content-md-center text-center\" role=\"alert\" style=\"display: none;\">
<p id='mensaje'>Cliente Editado! </p>
</div>

          <!-- Section Input Groups-->
      <section class=\"section novi-background section-20\" id='seccion-principal'>
        <div class=\"container\">
          <h1>Datos Del Cliente</h1>
          <hr class=\"divider divider-sm bg-mantis\">
          <div class=\"row justify-content-md-center text-left\">
            <div class=\"col-md-7 col-lg-4\">

            ";
        // line 36
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 36, $this->source); })()), 'form_start', ["attr" => ["id" => "form_cliente"]]);
        echo "
       
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-cellphone-iphone\"></span></span></span>
                
                  ";
        // line 41
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 41, $this->source); })()), "telefono", [], "any", false, false, false, 41), 'widget', ["attr" => ["disabled" => (isset($context["disabled"]) || array_key_exists("disabled", $context) ? $context["disabled"] : (function () { throw new RuntimeError('Variable "disabled" does not exist.', 41, $this->source); })()), "class" => "form-control", "placeholder" => "Telefono"]]);
        echo "
                 
                    <span class=\"input-group-append\">
                      
                  </div>
                </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-user-plus\"></span></span></span>
                 
                 ";
        // line 51
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 51, $this->source); })()), "nombre", [], "any", false, false, false, 51), 'widget', ["attr" => ["disabled" => (isset($context["disabled"]) || array_key_exists("disabled", $context) ? $context["disabled"] : (function () { throw new RuntimeError('Variable "disabled" does not exist.', 51, $this->source); })()), "class" => "form-control", "placeholder" => "Nombre"]]);
        echo "
                 <span id='edit-nombre' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-users\"></span></span></span>
                  
                   ";
        // line 61
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 61, $this->source); })()), "apellidos", [], "any", false, false, false, 61), 'widget', ["attr" => ["disabled" => (isset($context["disabled"]) || array_key_exists("disabled", $context) ? $context["disabled"] : (function () { throw new RuntimeError('Variable "disabled" does not exist.', 61, $this->source); })()), "class" => "form-control", "placeholder" => "Apellido"]]);
        echo "
                  <span id='edit-apellidos' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-email\"></span></span></span>
                 
                 ";
        // line 71
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 71, $this->source); })()), "correo", [], "any", false, false, false, 71), 'widget', ["attr" => ["disabled" => (isset($context["disabled"]) || array_key_exists("disabled", $context) ? $context["disabled"] : (function () { throw new RuntimeError('Variable "disabled" does not exist.', 71, $this->source); })()), "class" => "form-control", "placeholder" => "Correo Electronico"]]);
        echo "
                    <span id='edit-correo' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-map-marker\"></span></span></span>
                 
                   ";
        // line 81
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 81, $this->source); })()), "direccion", [], "any", false, false, false, 81), 'widget', ["attr" => ["disabled" => (isset($context["disabled"]) || array_key_exists("disabled", $context) ? $context["disabled"] : (function () { throw new RuntimeError('Variable "disabled" does not exist.', 81, $this->source); })()), "class" => "form-control", "placeholder" => "Direccion"]]);
        echo "
                  <span id='edit-direccion' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-book\"></span></span></span>
                      

                  ";
        // line 92
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 92, $this->source); })()), "comentario", [], "any", false, false, false, 92), 'widget', ["attr" => ["disabled" => (isset($context["disabled"]) || array_key_exists("disabled", $context) ? $context["disabled"] : (function () { throw new RuntimeError('Variable "disabled" does not exist.', 92, $this->source); })()), "class" => "form-control", "placeholder" => "Comentario"]]);
        echo "
                  <span id='edit-comentario' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>


                <div class=\"form-output\" id=\"components-form-subscribe-footer\"></div>

                <div class=\" row justify-content-md-center group offset-top-34\">
                 
           ";
        // line 104
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 104, $this->source); })()), "continuar", [], "any", false, false, false, 104), 'row');
        echo "
            
        
          </div>

              ";
        // line 109
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 109, $this->source); })()), 'form_end');
        echo "


            </div>
          </div>
        </div>
      </section>
     ";
        // line 116
        $this->loadTemplate("layout/footer.html", "cliente/editar.html.twig", 116)->display($context);
        // line 117
        echo "  </body>
</html>

<script>

\$(\"#cliente_continuar\").click(function(){ 
 
  // \$(\"#error\").css(\"display\", \"\");
 
  });

\$(\"#edit-nombre\").click(function(){ 
  \$('#cliente_nombre').prop(\"disabled\", false);
  \$('#cliente_nombre').css('background-color', 'white');
  });

\$(\"#edit-apellidos\").click(function(){ 
  \$('#cliente_apellidos').prop(\"disabled\", false);
  \$('#cliente_apellidos').css('background-color', 'white');
  });

\$(\"#edit-correo\").click(function(){ 
  \$('#cliente_correo').prop(\"disabled\", false);
  \$('#cliente_correo').css('background-color', 'white');
  });

  \$(\"#edit-direccion\").click(function(){ 
  \$('#cliente_direccion').prop(\"disabled\", false);
  \$('#cliente_direccion').css('background-color', 'white');
  });

  \$(\"#edit-comentario\").click(function(){ 
  \$('#cliente_comentario').prop(\"disabled\", false);
  \$('#cliente_comentario').css('background-color', 'white');
  });


// A \$( document ).ready() block.
\$( document ).ready(function() {
 \$( \"#cliente_continuar\" ).append( \"<span class ='novi-icon fa fa-arrow-circle-right btn icon-xxs btn-icon-right' ></span>\" );

  if(\$('#cliente_telefono').is(':disabled')){

    \$('#cliente_telefono').css('background-color', '#00000052');
  }

   if(\$('#cliente_nombre').is(':disabled')){

    \$('#cliente_nombre').css('background-color', '#00000052');
  }

 if(\$('#cliente_apellidos').is(':disabled')){

    \$('#cliente_apellidos').css('background-color', '#00000052');
  }

 if(\$('#cliente_correo').is(':disabled')){

    \$('#cliente_correo').css('background-color', '#00000052');
  }

 if(\$('#cliente_direccion').is(':disabled')){

    \$('#cliente_direccion').css('background-color', '#00000052');
  }

 if(\$('#cliente_comentario').is(':disabled')){

    \$('#cliente_comentario').css('background-color', '#00000052');
  }

\$('#cliente_telefono').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});

});
</script>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "cliente/editar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  273 => 117,  271 => 116,  261 => 109,  253 => 104,  238 => 92,  224 => 81,  211 => 71,  198 => 61,  185 => 51,  172 => 41,  164 => 36,  149 => 23,  147 => 22,  142 => 19,  132 => 18,  120 => 15,  116 => 14,  112 => 13,  109 => 12,  99 => 11,  87 => 8,  83 => 7,  79 => 6,  75 => 5,  70 => 4,  60 => 3,  37 => 1,);
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
       
         <script src=\"{{ asset('js/script.js') }}\" type=\"text/javascript\"></script>
          <script src=\"{{ asset('js/revolution.min.js') }}\" type=\"text/javascript\"></script>
           <script src=\"{{ asset('js/carousel.js') }}\" type=\"text/javascript\"></script>
    {% endblock %}

{% block body %}
<!DOCTYPE html>
<html class=\"wide wow-animation scrollTo\" lang=\"en\">

{% include 'layout/header.html' %}

<div id='error' class=\"alert alert-success row justify-content-md-center text-center\" role=\"alert\" style=\"display: none;\">
<p id='mensaje'>Cliente Editado! </p>
</div>

          <!-- Section Input Groups-->
      <section class=\"section novi-background section-20\" id='seccion-principal'>
        <div class=\"container\">
          <h1>Datos Del Cliente</h1>
          <hr class=\"divider divider-sm bg-mantis\">
          <div class=\"row justify-content-md-center text-left\">
            <div class=\"col-md-7 col-lg-4\">

            {{ form_start(formulario,{'attr': { 'id': 'form_cliente'}}) }}
       
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-cellphone-iphone\"></span></span></span>
                
                  {{ form_widget(formulario.telefono, {'attr': {'disabled': disabled,'class': 'form-control','placeholder': 'Telefono'}}) }}
                 
                    <span class=\"input-group-append\">
                      
                  </div>
                </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-user-plus\"></span></span></span>
                 
                 {{ form_widget(formulario.nombre, {'attr': {'disabled': disabled,'class': 'form-control','placeholder': 'Nombre'}}) }}
                 <span id='edit-nombre' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-users\"></span></span></span>
                  
                   {{ form_widget(formulario.apellidos, {'attr': {'disabled': disabled,'class': 'form-control','placeholder': 'Apellido'}}) }}
                  <span id='edit-apellidos' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-email\"></span></span></span>
                 
                 {{ form_widget(formulario.correo, {'attr': {'disabled': disabled,'class': 'form-control','placeholder': 'Correo Electronico'}}) }}
                    <span id='edit-correo' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-map-marker\"></span></span></span>
                 
                   {{ form_widget(formulario.direccion, {'attr': {'disabled': disabled,'class': 'form-control','placeholder': 'Direccion'}}) }}
                  <span id='edit-direccion' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-book\"></span></span></span>
                      

                  {{ form_widget(formulario.comentario, {'attr': {'disabled': disabled,'class': 'form-control','placeholder': 'Comentario'}}) }}
                  <span id='edit-comentario' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
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

\$(\"#cliente_continuar\").click(function(){ 
 
  // \$(\"#error\").css(\"display\", \"\");
 
  });

\$(\"#edit-nombre\").click(function(){ 
  \$('#cliente_nombre').prop(\"disabled\", false);
  \$('#cliente_nombre').css('background-color', 'white');
  });

\$(\"#edit-apellidos\").click(function(){ 
  \$('#cliente_apellidos').prop(\"disabled\", false);
  \$('#cliente_apellidos').css('background-color', 'white');
  });

\$(\"#edit-correo\").click(function(){ 
  \$('#cliente_correo').prop(\"disabled\", false);
  \$('#cliente_correo').css('background-color', 'white');
  });

  \$(\"#edit-direccion\").click(function(){ 
  \$('#cliente_direccion').prop(\"disabled\", false);
  \$('#cliente_direccion').css('background-color', 'white');
  });

  \$(\"#edit-comentario\").click(function(){ 
  \$('#cliente_comentario').prop(\"disabled\", false);
  \$('#cliente_comentario').css('background-color', 'white');
  });


// A \$( document ).ready() block.
\$( document ).ready(function() {
 \$( \"#cliente_continuar\" ).append( \"<span class ='novi-icon fa fa-arrow-circle-right btn icon-xxs btn-icon-right' ></span>\" );

  if(\$('#cliente_telefono').is(':disabled')){

    \$('#cliente_telefono').css('background-color', '#00000052');
  }

   if(\$('#cliente_nombre').is(':disabled')){

    \$('#cliente_nombre').css('background-color', '#00000052');
  }

 if(\$('#cliente_apellidos').is(':disabled')){

    \$('#cliente_apellidos').css('background-color', '#00000052');
  }

 if(\$('#cliente_correo').is(':disabled')){

    \$('#cliente_correo').css('background-color', '#00000052');
  }

 if(\$('#cliente_direccion').is(':disabled')){

    \$('#cliente_direccion').css('background-color', '#00000052');
  }

 if(\$('#cliente_comentario').is(':disabled')){

    \$('#cliente_comentario').css('background-color', '#00000052');
  }

\$('#cliente_telefono').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});

});
</script>

{% endblock %}

", "cliente/editar.html.twig", "/var/www/html/horizontes/templates/cliente/editar.html.twig");
    }
}
