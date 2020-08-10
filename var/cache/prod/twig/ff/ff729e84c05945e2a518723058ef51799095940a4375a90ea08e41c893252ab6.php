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
class __TwigTemplate_7f354f883183fac19bd994213b28b2b51f474494cdbdf4c08bafc712885cd210 extends Template
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
        $this->parent = $this->loadTemplate("base.html.twig", "cliente/registrar.html.twig", 2);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
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
    }

    // line 12
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
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
    }

    // line 19
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
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
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["formulario"] ?? null), 'form_start', ["attr" => ["id" => "form_cliente"]]);
        echo "
       
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-cellphone-iphone\"></span></span></span>
                
                  ";
        // line 41
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "telefono", [], "any", false, false, false, 41), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Telefono"]]);
        echo "
 
                    <span class=\"input-group-append\">
                      
                  </div>
                </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-user-plus\"></span></span></span>
                 
                 ";
        // line 51
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "nombre", [], "any", false, false, false, 51), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Nombre"]]);
        echo "

                <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-users\"></span></span></span>
                  
                   ";
        // line 61
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "apellidos", [], "any", false, false, false, 61), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Apellido"]]);
        echo "
                 
                  <span class=\"input-group-append\">                    
                
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-email\"></span></span></span>
                 
                 ";
        // line 71
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "correo", [], "any", false, false, false, 71), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Correo Electronico"]]);
        echo "
                    
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-map-marker\"></span></span></span>
                 
                   ";
        // line 81
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "direccion", [], "any", false, false, false, 81), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Direccion"]]);
        echo "
         
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-book\"></span></span></span>
                      

                  ";
        // line 92
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "comentario", [], "any", false, false, false, 92), 'widget', ["attr" => ["class" => "form-control", "placeholder" => "Comentario"]]);
        echo "
                  
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>


                <div class=\"form-output\" id=\"components-form-subscribe-footer\"></div>

                <div class=\" row justify-content-md-center group offset-top-34\">
                 
           ";
        // line 104
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "continuar", [], "any", false, false, false, 104), 'row');
        echo "
            
        
          </div>

              ";
        // line 109
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["formulario"] ?? null), 'form_end');
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

        \$(\"#cliente_correo\").css(\"border-color\", \"red\");
        \$(\"#mensaje\").text('El cliente debe tener un email valido');
       
  var validador = /^([a-zA-Z0-9_\\.\\-\\+])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+\$/;
 
  if(!validador.test(email)) {

  \$(\"#mensaje\").text('Email no valido');    

  }
     }else{

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
        return array (  232 => 117,  230 => 116,  220 => 109,  212 => 104,  197 => 92,  183 => 81,  170 => 71,  157 => 61,  144 => 51,  131 => 41,  123 => 36,  109 => 24,  107 => 23,  102 => 20,  98 => 19,  92 => 16,  88 => 15,  84 => 14,  79 => 13,  75 => 12,  69 => 9,  65 => 8,  61 => 7,  57 => 6,  52 => 5,  48 => 4,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "cliente/registrar.html.twig", "/var/www/html/horizontes/templates/cliente/registrar.html.twig");
    }
}
