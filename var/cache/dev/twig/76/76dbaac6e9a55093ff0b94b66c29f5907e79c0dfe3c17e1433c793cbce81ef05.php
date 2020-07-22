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

/* layout/footer.html */
class __TwigTemplate_35684ca9fd425d0732ae66f503c6e79bc6bf5ce67582eaa0d9c2268a18ec1bec extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/footer.html"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/footer.html"));

        // line 1
        echo " <!-- Default footer-->
 <footer class=\"section novi-background section-relative section-top-20 section-bottom-20 page-footer bg-black context-dark\">
       
  <div class=\"container \">
    <p class=\"small text-light\">Grupo SOLYAG &copy; <span class=\"copyright-year\"></span> . Todos los derechos reservados.
    </p>
  </div>
</footer>
</div>
</div>
<!-- Global RD Mailform Output-->
<div class=\"snackbars\" id=\"form-output-global\"></div>
<script src=\"js/core.min.js\"></script>
<script src=\"js/script.js\"></script>
<script src=\"js/revolution.min.js\"></script>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "layout/footer.html";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source(" <!-- Default footer-->
 <footer class=\"section novi-background section-relative section-top-20 section-bottom-20 page-footer bg-black context-dark\">
       
  <div class=\"container \">
    <p class=\"small text-light\">Grupo SOLYAG &copy; <span class=\"copyright-year\"></span> . Todos los derechos reservados.
    </p>
  </div>
</footer>
</div>
</div>
<!-- Global RD Mailform Output-->
<div class=\"snackbars\" id=\"form-output-global\"></div>
<script src=\"js/core.min.js\"></script>
<script src=\"js/script.js\"></script>
<script src=\"js/revolution.min.js\"></script>", "layout/footer.html", "/var/www/html/horizontes/templates/layout/footer.html");
    }
}
