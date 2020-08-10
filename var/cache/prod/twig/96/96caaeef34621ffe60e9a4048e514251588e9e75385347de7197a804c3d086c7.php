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
class __TwigTemplate_ace3a8ce636f656fa16e270949b43d4db59d5c7fbec0e9b6dc0f90f798385f1d extends Template
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
<script src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/core.min.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/script.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/revolution.min.js"), "html", null, true);
        echo "\"></script>";
    }

    public function getTemplateName()
    {
        return "layout/footer.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 15,  55 => 14,  51 => 13,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout/footer.html", "/var/www/html/horizontes/templates/layout/footer.html");
    }
}
