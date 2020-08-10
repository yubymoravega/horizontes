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
        // line 2
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "cliente/registrar.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "cliente/registrar.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "cliente/registrar.html.twig", 2);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 4
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 5
        echo "        <link href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/favicon.ico"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"icon\" />
        <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/carousel.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style-sunset.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("//fonts.googleapis.com/css?family=Montserrat:400,700%7CLato:300,300italic,400,700,900%7CYesteryear"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 12
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 13
        echo "        <script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/core.min.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
         <script src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/script.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
          <script src=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/revolution.min.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
           <script src=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/carousel.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 19
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 20
        echo "<!DOCTYPE html>
<html class=\"wide wow-animation scrollTo\" lang=\"en\">

";
        // line 23
        $this->loadTemplate("layout/header.html", "cliente/registrar.html.twig", 23)->display($context);
        // line 24
        echo "
<div id='error' class=\"alert alert-danger row justify-content-md-center text-center\" role=\"alert\" style=\"display: none;\">
<p id='mensaje'>El cliente debe tener un número de teléfono valido </p>
</div>
          <!-- Section Input Groups-->
      <section class=\"section novi-background section-20\" id='seccion-principal'>
        <div class=\"container\">
          <h1>Registro Del Cliente</h1>
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
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 41, $this->source); })()), "telefono", [], "any", false, false, false, 41), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Telefono"]]);
        echo "
 
                    <span class=\"input-group-append\">
                      
                  </div>
                </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-user-plus\"></span></span></span>
                 
                 ";
        // line 51
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 51, $this->source); })()), "nombre", [], "any", false, false, false, 51), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Nombre"]]);
        echo "

                <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-users\"></span></span></span>
                  
                   ";
        // line 61
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 61, $this->source); })()), "apellidos", [], "any", false, false, false, 61), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Apellido"]]);
        echo "
                 
                  <span class=\"input-group-append\">                    
                
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-email\"></span></span></span>
                 
                 ";
        // line 71
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 71, $this->source); })()), "correo", [], "any", false, false, false, 71), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Correo Electronico"]]);
        echo "
                    
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-map-marker\"></span></span></span>
                 
                   ";
        // line 81
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 81, $this->source); })()), "direccion", [], "any", false, false, false, 81), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Direccion"]]);
        echo "
         
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-book\"></span></span></span>
                      

                  ";
        // line 92
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["formulario"]) || array_key_exists("formulario", $context) ? $context["formulario"] : (function () { throw new RuntimeError('Variable "formulario" does not exist.', 92, $this->source); })()), "comentario", [], "any", false, false, false, 92), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Comentario"]]);
        echo "
                  
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
        $this->loadTemplate("layout/footer.html", "cliente/registrar.html.twig", 116)->display($context);
        // line 117
        echo "  </body>
</html>

<script>


\$(\"#form_cliente\").submit(function(e){
     e.preventDefault();// cancela el submit
});

var id = false;

if(id == true){
  \$(\"#cliente_telefono\").css(\"border-color\", \"\");
}

\$( \"#cliente_continuar\" ).click(function() {
  
    var telefono = \$.trim(\$(\"#cliente_telefono\").val());

     var nombre = \$.trim(\$(\"#cliente_nombre\").val());

     var apellido =  \$.trim(\$(\"#cliente_apellidos\").val());

      var email =  \$.trim(\$(\"#cliente_correo\").val());

     if(telefono.length < 8){

       \$(\"#cliente_telefono\").css(\"border-color\", \"red\");

       \$(\"#error\").css(\"display\", \"\");
    
      }else if(nombre.length < 1){

        \$(\"#cliente_nombre\").css(\"border-color\", \"red\");

       \$(\"#mensaje\").text('El cliente debe tener un nombre');

     }else if(apellido.length < 2){

        \$(\"#cliente_apellidos\").css(\"border-color\", \"red\");

       \$(\"#mensaje\").text('El cliente debe tener un apellido');
       
     }else if(email.length > 0){

    var regex = /[\\w-\\.]{2,}@([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}/;

    if (regex.test(\$(\"#cliente_correo\").val().trim())) {
        envio();

    } else {

      \$(\"#error\").css(\"display\", \"\");

           \$(\"#cliente_correo\").css(\"border-color\", \"red\");

       \$(\"#mensaje\").text('Email no valido!');

    }


     }else{

         envio();   

     }

      function envio() {
  

        \$(\"#cliente_correo\").css(\"border-color\", \"\");

        \$(\"#cliente_telefono\").css(\"border-color\", \"\");

       \$(\"#cliente_apellidos\").css(\"border-color\", \"\");

       \$(\"#cliente_nombre\").css(\"border-color\", \"\");

        \$(\"#error\").css(\"display\", \"none\");

         \$(\"#cliente_correo\").css(\"border-color\", \"\");

       \t\$(\"#error\").removeClass(\"alert-danger\");

        \$(\"#error\").addClass(\"alert-success\");

        \$(\"#mensaje\").text('Cliente Guardado!');

         \$(\"#error\").css(\"display\", \"\");

          id = true;

        \$( \"#form_cliente\" ).submit();

            }


});

// A \$( document ).ready() block.

\$( document ).ready(function() {

 \$( \"#cliente_continuar\" ).append( \"<span class ='icon novi-icon mdi mdi-emoticon btn-icon-right' ></span>\" );

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
        return "cliente/registrar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  274 => 117,  272 => 116,  262 => 109,  254 => 104,  239 => 92,  225 => 81,  212 => 71,  199 => 61,  186 => 51,  173 => 41,  165 => 36,  151 => 24,  149 => 23,  144 => 20,  134 => 19,  122 => 16,  118 => 15,  114 => 14,  109 => 13,  99 => 12,  87 => 9,  83 => 8,  79 => 7,  75 => 6,  70 => 5,  60 => 4,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("
{% extends 'base.html.twig' %}

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

<div id='error' class=\"alert alert-danger row justify-content-md-center text-center\" role=\"alert\" style=\"display: none;\">
<p id='mensaje'>El cliente debe tener un número de teléfono valido </p>
</div>
          <!-- Section Input Groups-->
      <section class=\"section novi-background section-20\" id='seccion-principal'>
        <div class=\"container\">
          <h1>Registro Del Cliente</h1>
          <hr class=\"divider divider-sm bg-mantis\">
          <div class=\"row justify-content-md-center text-left\">
            <div class=\"col-md-7 col-lg-4\">

            {{ form_start(formulario,{'attr': { 'id': 'form_cliente'}}) }}
       
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
                 
                 {{ form_widget(formulario.correo, {'attr': { 'class': 'form-control','placeholder': 'Correo Electronico'}}) }}
                    
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


\$(\"#form_cliente\").submit(function(e){
     e.preventDefault();// cancela el submit
});

var id = false;

if(id == true){
  \$(\"#cliente_telefono\").css(\"border-color\", \"\");
}

\$( \"#cliente_continuar\" ).click(function() {
  
    var telefono = \$.trim(\$(\"#cliente_telefono\").val());

     var nombre = \$.trim(\$(\"#cliente_nombre\").val());

     var apellido =  \$.trim(\$(\"#cliente_apellidos\").val());

      var email =  \$.trim(\$(\"#cliente_correo\").val());

     if(telefono.length < 8){

       \$(\"#cliente_telefono\").css(\"border-color\", \"red\");

       \$(\"#error\").css(\"display\", \"\");
    
      }else if(nombre.length < 1){

        \$(\"#cliente_nombre\").css(\"border-color\", \"red\");

       \$(\"#mensaje\").text('El cliente debe tener un nombre');

     }else if(apellido.length < 2){

        \$(\"#cliente_apellidos\").css(\"border-color\", \"red\");

       \$(\"#mensaje\").text('El cliente debe tener un apellido');
       
     }else if(email.length > 0){

    var regex = /[\\w-\\.]{2,}@([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}/;

    if (regex.test(\$(\"#cliente_correo\").val().trim())) {
        envio();

    } else {

      \$(\"#error\").css(\"display\", \"\");

           \$(\"#cliente_correo\").css(\"border-color\", \"red\");

       \$(\"#mensaje\").text('Email no valido!');

    }


     }else{

         envio();   

     }

      function envio() {
  

        \$(\"#cliente_correo\").css(\"border-color\", \"\");

        \$(\"#cliente_telefono\").css(\"border-color\", \"\");

       \$(\"#cliente_apellidos\").css(\"border-color\", \"\");

       \$(\"#cliente_nombre\").css(\"border-color\", \"\");

        \$(\"#error\").css(\"display\", \"none\");

         \$(\"#cliente_correo\").css(\"border-color\", \"\");

       \t\$(\"#error\").removeClass(\"alert-danger\");

        \$(\"#error\").addClass(\"alert-success\");

        \$(\"#mensaje\").text('Cliente Guardado!');

         \$(\"#error\").css(\"display\", \"\");

          id = true;

        \$( \"#form_cliente\" ).submit();

            }


});

// A \$( document ).ready() block.

\$( document ).ready(function() {

 \$( \"#cliente_continuar\" ).append( \"<span class ='icon novi-icon mdi mdi-emoticon btn-icon-right' ></span>\" );

\$('#cliente_telefono').on('input', function () { 

    this.value = this.value.replace(/[^0-9]/g,'');
});
});
</script>

{% endblock %}", "cliente/registrar.html.twig", "/var/www/html/horizontes/templates/cliente/registrar.html.twig");
    }
}
