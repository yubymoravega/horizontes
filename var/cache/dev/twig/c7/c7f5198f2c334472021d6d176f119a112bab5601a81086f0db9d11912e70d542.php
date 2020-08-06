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

/* security/index.html.twig */
class __TwigTemplate_521f267922955a3dd1b0af7b621425a107aa05418caa9af41a0dba56f61b359c extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/index.html.twig"));

        // line 1
        echo "<!DOCTYPE html>

<html class=\"wide wow-animation scrollTo\" lang=\"en\">
  <head>
    <title>Login - Solyag</title>
    <meta charset=\"utf-8\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta name=\"viewport\" content=\"width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=Edge\">
    <meta name=\"keywords\" content=\"intense web design multipurpose template html\">
    <meta name=\"date\" content=\"Dec 26\">
    <link rel=\"icon\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/favicon.ico"), "html", null, true);
        echo "\"  type=\"image/x-icon\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"//fonts.googleapis.com/css?family=Montserrat:400,700%7CLato:300,300italic,400,700,900%7CYesteryear\">
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style.css"), "html", null, true);
        echo "\"> 
\t\t<!--[if lt IE 10]>
    <div style=\"background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;\"><a href=\"http://windows.microsoft.com/en-US/internet-explorer/\"><img src=\"images/ie8-panel/warning_bar_0000_us.jpg\" border=\"0\" height=\"42\" width=\"820\" alt=\"You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.\"></a></div>
    <script src=\"js/html5shiv.min.js\"></script>
\t\t<![endif]-->
  </head>
  <body>
    <div class=\"page-loader page-loader-variant-1\">
      <div><img class='img-fluid' style='margin-top: -20px;margin-left: -18px;' width='330' height='67' src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo-solyag.png"), "html", null, true);
        echo "\" alt=''/>
        <div class=\"offset-top-41 text-center\">
          <div class=\"spinner\"></div>
        </div>
      </div>
    </div>
    <div class=\"page text-center\">
      <section class=\"section novi-background one-page bg-shark-radio\">
        <div class=\"one-page-header\">
          <!--Navbar Brand-->
          <div class=\"rd-navbar-brand\"><a href=\"index.html\"><img style='margin-top: 80px;margin-left: -15px;' width='200' height='200' src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo-solyag.png"), "html", null, true);
        echo "\" alt=''/></a></div>
        </div>
        <!-- Login-->
        <section>
          <div class=\"container\">
            <div class=\"section-350 section-cover row justify-content-sm-center align-items-sm-center\">
              <div class=\"col-sm-8 col-md-6 col-lg-4\">
                <div style=\"background: rgba(0, 0, 0, 0); box-shadow: 0 0px 0px 0 rgba(0, 0, 0, 0);\" class=\"card text-center section-34 section-sm-41 inset-left-20 inset-right-20 inset-md-left-20 inset-md-right-20 inset-xl-left-30 inset-xl-right-30 bg-default shadow-drop-md\">
                 
                  <!-- RD Mailform--> 
                  <form method=\"post\" class=\"text-left offset-top-30\" >
                    <div class=\"form-group\">
                      <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon input-group-addon-inverse\"><span class=\"novi-icon mdi mdi-account-outline\"></span></span></span>
                       
                       <input autocomplete=\"off\" type=\"text\" value=\"";
        // line 46
        echo twig_escape_filter($this->env, (isset($context["last_username"]) || array_key_exists("last_username", $context) ? $context["last_username"] : (function () { throw new RuntimeError('Variable "last_username" does not exist.', 46, $this->source); })()), "html", null, true);
        echo "\" name=\"username\" id=\"inputUsername\" class=\"form-control\" placeholder=\"Usuario\"  required autofocus>          
                      </div>
                    </div>
                    <div class=\"form-group offset-top-20\">
                      <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon input-group-addon-inverse\"><span class=\"novi-icon mdi mdi-lock-open-outline\"></span></span></span>
                       
                         <input autocomplete=\"off\" type=\"password\" name=\"password\" id=\"inputPassword\" class=\"form-control\" placeholder=\"Clave\" required>
                      </div>
                    </div>

                     <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken("authenticate"), "html", null, true);
        echo "\">

                    <button class=\"btn btn-login btn-sm btn-icon btn-block  offset-top-20\" type=\"submit\">Entrar <span class=\"icon novi-icon mdi mdi-arrow-right-bold-circle-outline\"></span></button>
                  </form>
                 

                       ";
        // line 62
        if ((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 62, $this->source); })())) {
            // line 63
            echo "                         <div class=\"alert alert-danger\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 63, $this->source); })()), "messageKey", [], "any", false, false, false, 63), twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 63, $this->source); })()), "messageData", [], "any", false, false, false, 63), "security"), "html", null, true);
            echo "</div>
                      ";
        }
        // line 65
        echo "
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class=\"one-page-footer\">
          <p class=\"small\" style=\"color: rgba(255,255,255, 0.3)\">Solyag &copy; <span class=\"copyright-year\"></span> .</p>
        </div>
      </section>
    </div>
    <!-- Global RD Mailform Output-->
    <div class=\"snackbars\" id=\"form-output-global\"></div>
    <script src=\"";
        // line 78
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/core.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 79
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/script.js"), "html", null, true);
        echo "\"></script>
    <script src=\"{ asset('js/revolution.min.js') }}\"></script>{
  </body>
</html>

<script>

  document.addEventListener(\"DOMContentLoaded\", function() {
      var elements = document.getElementsByTagName(\"INPUT\");
      for (var i = 0; i < elements.length; i++) {
          elements[i].oninvalid = function(e) {
              e.target.setCustomValidity(\"\");
              if (!e.target.validity.valid) {
                  e.target.setCustomValidity(\"Campo Obligatorio!\");
              }
          };
          elements[i].oninput = function(e) {
              e.target.setCustomValidity(\"\");
          };
      }
  })
  
  
  </script>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "security/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  151 => 79,  147 => 78,  132 => 65,  126 => 63,  124 => 62,  115 => 56,  102 => 46,  85 => 32,  72 => 22,  61 => 14,  56 => 12,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>

<html class=\"wide wow-animation scrollTo\" lang=\"en\">
  <head>
    <title>Login - Solyag</title>
    <meta charset=\"utf-8\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta name=\"viewport\" content=\"width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=Edge\">
    <meta name=\"keywords\" content=\"intense web design multipurpose template html\">
    <meta name=\"date\" content=\"Dec 26\">
    <link rel=\"icon\" href=\"{{ asset('images/favicon.ico') }}\"  type=\"image/x-icon\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"//fonts.googleapis.com/css?family=Montserrat:400,700%7CLato:300,300italic,400,700,900%7CYesteryear\">
    <link rel=\"stylesheet\" href=\"{{ asset('css/style.css') }}\"> 
\t\t<!--[if lt IE 10]>
    <div style=\"background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;\"><a href=\"http://windows.microsoft.com/en-US/internet-explorer/\"><img src=\"images/ie8-panel/warning_bar_0000_us.jpg\" border=\"0\" height=\"42\" width=\"820\" alt=\"You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.\"></a></div>
    <script src=\"js/html5shiv.min.js\"></script>
\t\t<![endif]-->
  </head>
  <body>
    <div class=\"page-loader page-loader-variant-1\">
      <div><img class='img-fluid' style='margin-top: -20px;margin-left: -18px;' width='330' height='67' src=\"{{ asset('images/logo-solyag.png') }}\" alt=''/>
        <div class=\"offset-top-41 text-center\">
          <div class=\"spinner\"></div>
        </div>
      </div>
    </div>
    <div class=\"page text-center\">
      <section class=\"section novi-background one-page bg-shark-radio\">
        <div class=\"one-page-header\">
          <!--Navbar Brand-->
          <div class=\"rd-navbar-brand\"><a href=\"index.html\"><img style='margin-top: 80px;margin-left: -15px;' width='200' height='200' src=\"{{ asset('images/logo-solyag.png') }}\" alt=''/></a></div>
        </div>
        <!-- Login-->
        <section>
          <div class=\"container\">
            <div class=\"section-350 section-cover row justify-content-sm-center align-items-sm-center\">
              <div class=\"col-sm-8 col-md-6 col-lg-4\">
                <div style=\"background: rgba(0, 0, 0, 0); box-shadow: 0 0px 0px 0 rgba(0, 0, 0, 0);\" class=\"card text-center section-34 section-sm-41 inset-left-20 inset-right-20 inset-md-left-20 inset-md-right-20 inset-xl-left-30 inset-xl-right-30 bg-default shadow-drop-md\">
                 
                  <!-- RD Mailform--> 
                  <form method=\"post\" class=\"text-left offset-top-30\" >
                    <div class=\"form-group\">
                      <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon input-group-addon-inverse\"><span class=\"novi-icon mdi mdi-account-outline\"></span></span></span>
                       
                       <input autocomplete=\"off\" type=\"text\" value=\"{{ last_username }}\" name=\"username\" id=\"inputUsername\" class=\"form-control\" placeholder=\"Usuario\"  required autofocus>          
                      </div>
                    </div>
                    <div class=\"form-group offset-top-20\">
                      <div class=\"input-group input-group-sm\"><span class=\"input-group-prepend\"><span class=\"input-group-text input-group-icon input-group-addon-inverse\"><span class=\"novi-icon mdi mdi-lock-open-outline\"></span></span></span>
                       
                         <input autocomplete=\"off\" type=\"password\" name=\"password\" id=\"inputPassword\" class=\"form-control\" placeholder=\"Clave\" required>
                      </div>
                    </div>

                     <input type=\"hidden\" name=\"_csrf_token\" value=\"{{ csrf_token('authenticate') }}\">

                    <button class=\"btn btn-login btn-sm btn-icon btn-block  offset-top-20\" type=\"submit\">Entrar <span class=\"icon novi-icon mdi mdi-arrow-right-bold-circle-outline\"></span></button>
                  </form>
                 

                       {% if error %}
                         <div class=\"alert alert-danger\">{{ error.messageKey|trans(error.messageData, 'security') }}</div>
                      {% endif %}

                </div>
              </div>
            </div>
          </div>
        </section>
        <div class=\"one-page-footer\">
          <p class=\"small\" style=\"color: rgba(255,255,255, 0.3)\">Solyag &copy; <span class=\"copyright-year\"></span> .</p>
        </div>
      </section>
    </div>
    <!-- Global RD Mailform Output-->
    <div class=\"snackbars\" id=\"form-output-global\"></div>
    <script src=\"{{ asset('js/core.min.js') }}\"></script>
    <script src=\"{{ asset('js/script.js') }}\"></script>
    <script src=\"{ asset('js/revolution.min.js') }}\"></script>{
  </body>
</html>

<script>

  document.addEventListener(\"DOMContentLoaded\", function() {
      var elements = document.getElementsByTagName(\"INPUT\");
      for (var i = 0; i < elements.length; i++) {
          elements[i].oninvalid = function(e) {
              e.target.setCustomValidity(\"\");
              if (!e.target.validity.valid) {
                  e.target.setCustomValidity(\"Campo Obligatorio!\");
              }
          };
          elements[i].oninput = function(e) {
              e.target.setCustomValidity(\"\");
          };
      }
  })
  
  
  </script>", "security/index.html.twig", "/var/www/html/horizontes/templates/security/index.html.twig");
    }
}
