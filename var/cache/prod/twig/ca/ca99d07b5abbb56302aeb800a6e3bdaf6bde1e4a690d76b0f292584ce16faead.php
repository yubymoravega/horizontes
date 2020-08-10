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
class __TwigTemplate_98f1c8ef94ceb50b79a992d829ee636748417a67207a65bd8cb954ae674fb74c extends Template
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
        $this->parent = $this->loadTemplate("base.html.twig", "cliente/editar.html.twig", 1);
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
    }

    // line 18
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
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
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["formulario"] ?? null), 'form_start', ["attr" => ["id" => "form_cliente"]]);
        echo "
       
                <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-cellphone-iphone\"></span></span></span>
                
                  ";
        // line 41
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "telefono", [], "any", false, false, false, 41), 'widget', ["attr" => ["disabled" => ($context["disabled"] ?? null), "class" => "form-control", "placeholder" => "Telefono"]]);
        echo "
                 
                    <span class=\"input-group-append\">
                      
                  </div>
                </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-user-plus\"></span></span></span>
                 
                 ";
        // line 51
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "nombre", [], "any", false, false, false, 51), 'widget', ["attr" => ["disabled" => ($context["disabled"] ?? null), "class" => "form-control", "placeholder" => "Nombre"]]);
        echo "
                 <span id='edit-nombre' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-users\"></span></span></span>
                  
                   ";
        // line 61
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "apellidos", [], "any", false, false, false, 61), 'widget', ["attr" => ["disabled" => ($context["disabled"] ?? null), "class" => "form-control", "placeholder" => "Apellido"]]);
        echo "
                  <span id='edit-apellidos' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon mdi mdi-email\"></span></span></span>
                 
                 ";
        // line 71
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "correo", [], "any", false, false, false, 71), 'widget', ["attr" => ["disabled" => ($context["disabled"] ?? null), "class" => "form-control", "placeholder" => "Correo Electronico"]]);
        echo "
                    <span id='edit-correo' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-map-marker\"></span></span></span>
                 
                   ";
        // line 81
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "direccion", [], "any", false, false, false, 81), 'widget', ["attr" => ["disabled" => ($context["disabled"] ?? null), "class" => "form-control", "placeholder" => "Direccion"]]);
        echo "
                  <span id='edit-direccion' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
                  <span class=\"input-group-append\">                    
                 
                  </div>
             </div>

             <div class=\"form-group\">
                  <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon\"><span class=\"novi-icon fa fa-book\"></span></span></span>
                      

                  ";
        // line 92
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["formulario"] ?? null), "comentario", [], "any", false, false, false, 92), 'widget', ["attr" => ["disabled" => ($context["disabled"] ?? null), "class" => "form-control", "placeholder" => "Comentario"]]);
        echo "
                  <span id='edit-comentario' style='cursor: pointer;' class='novi-icon fa fa-edit mdi icon icon-xxs'></span>
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
        return array (  231 => 117,  229 => 116,  219 => 109,  211 => 104,  196 => 92,  182 => 81,  169 => 71,  156 => 61,  143 => 51,  130 => 41,  122 => 36,  107 => 23,  105 => 22,  100 => 19,  96 => 18,  90 => 15,  86 => 14,  82 => 13,  79 => 12,  75 => 11,  69 => 8,  65 => 7,  61 => 6,  57 => 5,  52 => 4,  48 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cliente/editar.html.twig", "/var/www/html/horizontes/templates/cliente/editar.html.twig");
    }
}
