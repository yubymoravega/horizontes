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

/* layout/header.html */
class __TwigTemplate_bdf8d89afa1d89d9ee118da13f2f7b5495ddb10cd2233b6e04f2c7597b915373 extends Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/header.html"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "layout/header.html"));

        // line 1
        echo "  <head>
    <title>Services</title>
    <meta charset=\"utf-8\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta name=\"viewport\" content=\"width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=Edge\">
    <meta name=\"keywords\" content=\"intense web design multipurpose template html\">
    <meta name=\"date\" content=\"Dec 26\">
    <link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/x-icon\">
   
\t\t<!--[if lt IE 10]>
    <div style=\"background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;\"><a href=\"http://windows.microsoft.com/en-US/internet-explorer/\"><img src=\"images/ie8-panel/warning_bar_0000_us.jpg\" border=\"0\" height=\"42\" width=\"820\" alt=\"You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.\"></a></div>
    <script src=\"js/html5shiv.min.js\"></script>
\t\t<![endif]-->
  </head>
    <body>
      <div class=\"page-loader page-loader-variant-1\">
        <div><img class='img-fluid' style='margin-top: -20px;margin-left: -18px;' width='330' height='67' src=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo-solyag.png"), "html", null, true);
        echo "\" alt=''/>
          <div class=\"offset-top-41 text-center\">
            <div class=\"spinner\"></div>
          </div>
        </div>
      </div>
      <div class=\"page text-center\">
        <!-- Page Header-->
        <header class=\"page-head\">
          <!-- RD Navbar Transparent-->
          <div class=\"rd-navbar-wrap\">
            <!--  <nav class=\"rd-navbar rd-navbar-default rd-navbar-dark\" data-md-device-layout=\"rd-navbar-fixed\" data-lg-device-layout=\"rd-navbar-fixed\" data-lg-auto-height=\"true\" data-md-layout=\"rd-navbar-fixed\" data-lg-layout=\"rd-navbar-fixed\" data-lg-stick-up=\"true\"> -->
             <nav class=\"rd-navbar rd-navbar-default rd-navbar-dark\" data-md-device-layout=\"rd-navbar-fixed\" data-lg-device-layout=\"rd-navbar-fixed\" data-lg-auto-height=\"true\" data-md-layout=\"rd-navbar-fixed\" data-lg-layout=\"rd-navbar-fixed\" data-lg-stick-up=\"true\">
            
              <div class=\"rd-navbar-inner\">
                <!-- RD Navbar Panel-->
                <div class=\"rd-navbar-panel\">
                  <!-- RD Navbar Toggle-->
                  <button class=\"rd-navbar-toggle\" data-rd-navbar-toggle=\".rd-navbar, .rd-navbar-nav-wrap\"><span></span></button>
                  <!--Navbar Brand-->
                  <div class=\"rd-navbar-brand\" style=\"left: 30%;\" ><a href=\"index.html\"><img style='margin-left: -15px;' width='184' height='54' src=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo-chico.png"), "html", null, true);
        echo "\"  alt=''/></a></div>
                </div>
                <div class=\"rd-navbar-menu-wrap\">
                  <div class=\"rd-navbar-nav-wrap\">
                    <div class=\"rd-navbar-mobile-scroll\">
                      <!--Navbar Brand Mobile-->
                      <div class=\"rd-navbar-mobile-brand\"><a href=\"index.html\"><img style='margin-top: -5px;margin-left: -15px;' width='138' height='40' src=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo-chico.png"), "html", null, true);
        echo "\" alt=''/></a></div>
                      <div class=\"form-search-wrap\">
                        <!-- RD Search Form-->
                        <form class=\"form-search rd-search\" action=\"search-results.html\" method=\"GET\">
                          <div class=\"form-group\">
                            <label class=\"form-label form-search-label form-label-sm\" for=\"rd-navbar-form-search-widget\">Search</label>
                            <input class=\"form-search-input input-sm form-control form-control-gray-lightest input-sm\" id=\"rd-navbar-form-search-widget\" type=\"text\" name=\"s\" autocomplete=\"off\"/>
                          </div>
                          <button class=\"form-search-submit\" type=\"submit\"><span class=\"novi-icon mdi mdi-magnify\"></span></button>
                        </form>
                      </div>
                      <!-- RD Navbar Nav-->
                      <ul class=\"rd-navbar-nav\">
                        <li><a href=\"index.html\"><span>Telecomunicaciones</span><span class=\"rd-navbar-label text-middle label-custom label-xs-custom label-rounded-custom label label-info\">novi</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Child Themes</span><span class=\"rd-navbar-label label-custom label-xs-custom label-rounded-custom label label-info\">novi</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"child/intense-photographer-portfolio/index.html\"><span class=\"text-middle\">Photographer</span></a>
                                </li>
                                <li><a href=\"child/intense-restaurant/index.html\"><span class=\"text-middle\">Restaurant</span></a>
                                </li>
                                <li><a href=\"child/intense-personal-blog/index.html\"><span class=\"text-middle\">Personal Blog</span></a>
                                </li>
                                <li><a href=\"child/intense-real-estate/index.html\"><span class=\"text-middle\">Real Estate</span></a>
                                </li>
                                <li><a href=\"child/intense-handmade/index.html\"><span class=\"text-middle\">Handmade</span></a>
                                </li>
                                <li><a href=\"child/intense-dental-clinic/index.html\"><span class=\"text-middle\">Dental Clinic</span></a>
                                </li>
                                <li><a href=\"child/intense-financial-analytic/index.html\"><span class=\"text-middle\">Financial Advisor</span></a>
                                </li>
                                <li><a href=\"child/intense-gym/index.html\"><span class=\"text-middle\">Gym</span></a>
                                </li>
                                <li><a href=\"child/intense-child-care/index.html\"><span class=\"text-middle\">Child Care</span></a>
                                </li>
                                <li><a href=\"child/intense-job-board/index.html\"><span class=\"text-middle\">Job Board</span></a>
                                </li>
                                <li><a href=\"newsletter/responsive/index.html\"><span class=\"text-middle\">Newsletter</span></a>
                                </li>
                                <li><a href=\"child/intense-taxi/index.html\"><span class=\"text-middle\">Taxi</span></a>
                                </li>
                                <li><a href=\"child/intense-pet-shop/index.html\"><span class=\"text-middle\">Pet shop</span></a>
                                </li>
                                <li><a href=\"child/intense-barbershop/index.html\"><span class=\"text-middle\">Barbershop</span></a>
                                </li>
                                <li><a href=\"child/car-repair/index.html\"><span class=\"text-middle\">Car Repair</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Landing pages</span><span class=\"rd-navbar-label label-custom label-xs-custom label-rounded-custom label label-info\">novi</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"child/intense-application/index.html\"><span class=\"text-middle\">Application</span></a>
                                </li>
                                <li><a href=\"child/intense-book/index.html\"><span class=\"text-middle\">Book</span></a>
                                </li>
                                <li><a href=\"child/intense-product/index.html\"><span class=\"text-middle\">Product</span></a>
                                </li>
                                <li><a href=\"child/intense-travel/index.html\"><span class=\"text-middle\">Travel</span></a>
                                </li>
                                <li><a href=\"child/intense-startup/index.html\"><span class=\"text-middle\">Startup</span></a>
                                </li>
                                <li><a href=\"child/intense-event/index.html\"><span class=\"text-middle\">Event</span></a>
                                </li>
                                <li><a href=\"child/landing-agency/index.html\"><span class=\"text-middle\">Agency</span></a>
                                </li>
                                <li><a href=\"child/landing-business/index.html\"><span class=\"text-middle\">Business</span></a>
                                </li>
                                <li><a href=\"child/landing-corporate/index.html\"><span class=\"text-middle\">Corporate</span></a>
                                </li>
                                <li><a href=\"child/landing-personal/index.html\"><span class=\"text-middle\">Personal</span></a>
                                </li>
                                <li><a href=\"child/landing-shop/index.html\"><span class=\"text-middle\">Shop</span></a>
                                </li>
                                <li><a href=\"child/landing-startup/index.html\"><span class=\"text-middle\">Startup</span></a>
                                </li>
                                <li><a href=\"child/black-friday/index.html\"><span class=\"text-middle\">Black Friday</span></a>
                                </li>
                                <li><a href=\"child/christmas-cards/index.html\"><span class=\"text-middle\">Christmas Cards</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Home Types</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"index.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"index-one-page.html\"><span class=\"text-middle\">One Page</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Home Skins</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"index-variant-2.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"index-skin-sunset.html\"><span class=\"text-middle\">Sunset</span></a>
                                </li>
                                <li><a href=\"index-skin-simply-chic.html\"><span class=\"text-middle\">Simply Chic</span></a>
                                </li>
                                <li><a href=\"index-skin-minimal-blue.html\"><span class=\"text-middle\">Minimal Blue</span></a>
                                </li>
                                <li><a href=\"index-skin-sunrise.html\"><span class=\"text-middle\">Sunrise</span></a>
                                </li>
                                <li><a href=\"index-skin-renaissance.html\"><span class=\"text-middle\">Renaissance</span></a>
                                </li>
                                <li><a href=\"index-skin-green-space.html\"><span class=\"text-middle\">Green Space</span></a>
                                </li>
                                <li><a href=\"index-skin-red-energy.html\"><span class=\"text-middle\">Red Energy</span></a>
                                </li>
                                <li><a href=\"index-skin-eternal-joy.html\"><span class=\"text-middle\">Eternal Joy</span></a>
                                </li>
                                <li><a href=\"index-skin-commercial.html\"><span class=\"text-middle\">Commercial</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"index.html\"><span class=\"text-middle\">Home Intro</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"index-variant-2.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"index-promo.html\"><span class=\"text-middle\">Promo</span></a>
                                </li>
                                <li><a href=\"index-fast-registration.html\"><span class=\"text-middle\">Fast Registration</span></a>
                                </li>
                                <li><a href=\"index-make-an-appointment.html\"><span class=\"text-middle\">Appointment</span></a>
                                </li>
                                <li><a href=\"index-video-background.html\"><span class=\"text-middle\">Video Background</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a class=\"new\" href=\"#\"><span>Paqueteria</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Revolution slider</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"revolution-crossfade.html\"><span class=\"text-middle\">Slider crossfade</span></a>
                                </li>
                                <li><a href=\"revolution-fadethrough.html\"><span class=\"text-middle\">Slider fade through</span></a>
                                </li>
                                <li><a href=\"revolution-slidehorizontal.html\"><span class=\"text-middle\">Slider slide 1</span></a>
                                </li>
                                <li><a href=\"revolution-slidevertical.html\"><span class=\"text-middle\">Slider slide 2</span></a>
                                </li>
                                <li><a href=\"revolution-slidingoverlayhorizontal.html\"><span class=\"text-middle\">Slider overlay 1</span></a>
                                </li>
                                <li><a href=\"revolution-slidingoverlayvertical.html\"><span class=\"text-middle\">Slider overlay 2</span></a>
                                </li>
                                <li><a href=\"revolution-boxslide.html\"><span class=\"text-middle\">Slider box slide</span></a>
                                </li>
                                <li><a href=\"revolution-slotslide.html\"><span class=\"text-middle\">Slider slot slide</span></a>
                                </li>
                                <li><a href=\"revolution-boxfade.html\"><span class=\"text-middle\">Slider box fade</span></a>
                                </li>
                                <li><a href=\"revolution-slotfade.html\"><span class=\"text-middle\">Slider slot fade</span></a>
                                </li>
                                <li><a href=\"revolution-parallaxhorizontal.html\"><span class=\"text-middle\">Slider parallax 1</span></a>
                                </li>
                                <li><a href=\"revolution-parallaxvertical.html\"><span class=\"text-middle\">Slider parallax 2</span></a>
                                </li>
                                <li><a href=\"revolution-slotzoom-horizontal.html\"><span class=\"text-middle\">Slider slot zoom 1</span></a>
                                </li>
                                <li><a href=\"revolution-slotzoom-vertical.html\"><span class=\"text-middle\">Slider slot zoom 2</span></a>
                                </li>
                                <li><a href=\"revolution-incube.html\"><span class=\"text-middle\">Slider incube</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Plugins</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"rd-event-calendar.html\"><span class=\"text-middle\">RD Event Calendar</span></a>
                                </li>
                                <li><a href=\"rd-parallax.html\"><span class=\"text-middle\">Parallax</span></a>
                                </li>
                                <li><a href=\"rd-video.html\"><span class=\"text-middle\">Vide</span></a>
                                </li>
                                <li><a href=\"rd-navbar.html\"><span class=\"text-middle\">RD Navbar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Social Widgets</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"rd-twitter-feed.html\"><span class=\"text-middle\">RD Twitter Feed</span></a>
                                </li>
                                <li><a href=\"rd-flickr-feed.html\"><span class=\"text-middle\">RD Flickr Gallery</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Headers</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"#\"><span class=\"text-middle\">Default</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-default-transparent.html\"><span class=\"text-middle\">Transparent</span></a>
                                    </li>
                                    <li><a href=\"header-default-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-default-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Sidebar toggle</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-sidebar-toggle-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-sidebar-toggle-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Sidebar fixed</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-sidebar-fixed-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-sidebar-fixed-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Floated</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-floated-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-floated-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">With Top Panel</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-top-panel-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-top-panel-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Logo center</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-logo-center-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-logo-center-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Footers</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"footer-default.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"footer-variant-2.html\"><span class=\"text-middle\">Variant 2</span></a>
                                </li>
                                <li><a href=\"footer-variant-3.html\"><span class=\"text-middle\">Variant 3</span></a>
                                </li>
                                <li><a href=\"footer-variant-4.html\"><span class=\"text-middle\">Variant 4</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Page Loaders</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"page-loader-variant-1.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"rd-mailform.html\"><span class=\"text-middle\">Form Plugins</span></a>
                            </li>
                            <li><a href=\"captcha.html\"><span class=\"text-middle\">google reCaptcha</span></a>
                            </li>
                            <li><a href=\"subscribe.html\"><span class=\"text-middle\">Mailchimp &amp; Campaign Monitor</span></a>
                            </li>
                            <li><a href=\"charts-and-graphs.html\"><span class=\"text-middle\">Charts and Graphs</span></a>
                            </li>
                            <li><a href=\"ui-kit.html\"><span class=\"text-middle\">Advanced UI Kit</span></a>
                            </li>
                          </ul>
                        </li>
                        <li class=\"active\"><a href=\"#\"><span>Canasta Familiar</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <div class=\"row\">
                              <ul class=\"col-xl-3\">
                                <li><a href=\"404.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-bullhorn\"></span><span class=\"text-middle\">404 Page</span></a></li>
                                <li><a href=\"503.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-bullhorn\"></span><span class=\"text-middle\">503 Page</span></a></li>
                                <li><a href=\"about-us.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple\"></span><span class=\"text-middle\">About Us</span></a></li>
                                <li><a href=\"about-us-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple\"></span><span class=\"text-middle\">About Us v2</span></a></li>
                                <li><a href=\"about-me.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-convert\"></span><span class=\"text-middle\">About Me</span></a></li>
                                <li><a href=\"about-me-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-convert\"></span><span class=\"text-middle\">About Me v2</span></a></li>
                                <li><a href=\"services.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-folder-outline\"></span><span class=\"text-middle\">Services</span></a></li>
                                <li><a href=\"our-team.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-switch\"></span><span class=\"text-middle\">Our Team</span></a></li>
                                <li><a href=\"our-team-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-switch\"></span><span class=\"text-middle\">Our Team v2</span></a></li>
                              </ul>
                              <ul class=\"col-xl-3\">
                                <li><a href=\"team-member.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-box-outline\"></span><span class=\"text-middle\">Team Member</span></a></li>
                                <li><a href=\"team-member-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-box-outline\"></span><span class=\"text-middle\">Team Member v2</span></a></li>
                                <li><a href=\"careers.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-check\"></span><span class=\"text-middle\">Careers</span></a></li>
                                <li><a href=\"categories.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-filter-variant\"></span><span class=\"text-middle\">Categories</span></a></li>
                                <li><a href=\"faq.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq</span></a></li>
                                <li><a href=\"faq-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq v2</span></a></li>
                                <li><a href=\"faq-variant-3.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq v3</span></a></li>
                                <li><a href=\"faq-variant-4.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq v4</span></a></li>
                                <li><a href=\"contact-me.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-contact-mail\"></span><span class=\"text-middle\">Contact Me</span></a></li>
                              </ul>
                              <ul class=\"col-xl-3\">
                                <li><a href=\"contact-us.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Contact Us</span></a></li>
                                <li><a href=\"contact-us-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Contact Us v2</span></a></li>
                                <li><a href=\"get-in-touch.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Get In Touch</span></a></li>
                                <li><a href=\"contact-us-variant-3.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Contact Us v3</span></a></li>
                                <li><a href=\"subscribe.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-email-outline\"></span><span class=\"text-middle\">Subscribe</span></a></li>
                                <li><a href=\"sitemap.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-sitemap\"></span><span class=\"text-middle\">Sitemap</span></a></li>
                                <li><a href=\"coming-soon.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-clock-fast\"></span><span class=\"text-middle\">Coming Soon</span></a></li>
                                <li><a href=\"search-results.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-magnify\"></span><span class=\"text-middle\">Search Results</span></a></li>
                                <li><a href=\"login.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-login\"></span><span class=\"text-middle\">Login</span></a></li>
                              </ul>
                              <ul class=\"col-xl-3\">
                                <li><a href=\"register.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple-outline\"></span><span class=\"text-middle\">Register</span></a></li>
                                <li><a href=\"register-login.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple-outline\"></span><span class=\"text-middle\">Login / Register</span></a></li>
                                <li><a href=\"pricing.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-certificate\"></span><span class=\"text-middle\">Pricing</span></a></li>
                                <li><a href=\"make-an-appointment.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-calendar-clock\"></span><span class=\"text-middle\">Appointment</span></a></li>
                                <li><a href=\"make-an-appointment-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-calendar-clock\"></span><span class=\"text-middle\">Appointment v2</span></a></li>
                                <li><a href=\"maintenance.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-wrench\"></span><span class=\"text-middle\">Maintenance</span></a></li>
                                <li><a href=\"clients.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-wrench\"></span><span class=\"text-middle\">Clients</span></a></li>
                                <li><a href=\"under-construction.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-worker\"></span><span class=\"text-middle\">Under Construction</span></a></li>
                                <li><a href=\"privacy.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-file-outline\"></span><span class=\"text-middle\">Privacy Policy</span></a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li><a href=\"portfolio-grid-3-columns.html\"><span>Turismo</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Grid Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-grid-3-columns.html\"><span class=\"text-middle\">Horizontal</span></a>
                                </li>
                                <li><a href=\"portfolio-grid-3-columns-vertical.html\"><span class=\"text-middle\">Vertical</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Masonry Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-masonry-3-columns.html\"><span class=\"text-middle\">Horizontal</span></a>
                                </li>
                                <li><a href=\"portfolio-masonry-3-columns-vertical.html\"><span class=\"text-middle\">Vertical</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Wide Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-wide-3-columns.html\"><span class=\"text-middle\">Horizontal</span></a>
                                </li>
                                <li><a href=\"portfolio-wide-3-columns-vertical.html\"><span class=\"text-middle\">Vertical</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Fullwidth Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-fullwidth-3-columns.html\"><span class=\"text-middle\">3 Columns</span></a>
                                </li>
                                <li><a href=\"portfolio-fullwidth-4-columns.html\"><span class=\"text-middle\">4 Columns</span></a>
                                </li>
                                <li><a href=\"portfolio-fullwidth-5-columns.html\"><span class=\"text-middle\">5 Columns</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"portfolio-fullscreen-3-columns.html\"><span class=\"text-middle\">Fullscreen Layout</span></a>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Custom Effects</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-classic-effect.html\"><span class=\"text-middle\">Classic Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-zoe-effect.html\"><span class=\"text-middle\">Zoe Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-winston-effect.html\"><span class=\"text-middle\">Winston Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-josip-effect.html\"><span class=\"text-middle\">Josip Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-janes-effect.html\"><span class=\"text-middle\">Janes Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-apollo-effect.html\"><span class=\"text-middle\">Apollo Effect</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Single Project</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-single-project-default.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"portfolio-single-project-variant-2.html\"><span class=\"text-middle\">Variant 2</span></a>
                                </li>
                                <li><a href=\"portfolio-single-project-variant-3.html\"><span class=\"text-middle\">Variant 3</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a href=\"blog-default-left-sidebar.html\"><span>Tienda Virtual</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Classic</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-classic-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Events</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"events-list-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"events-list-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"events-list-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"events-list-single.html\"><span class=\"text-middle\">Single Event</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"events-list-single.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                    </li>
                                    <li><a href=\"events-list-single-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                    </li>
                                    <li><a href=\"events-list-single-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Wide</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-wide-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-single.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Default</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-default-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-single.html\"><span class=\"text-middle\">Single Post</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"blog-default-single.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                    </li>
                                    <li><a href=\"blog-default-single-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                    </li>
                                    <li><a href=\"blog-default-single-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                    </li>
                                    <li><a href=\"blog-default-single-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Grid</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-grid-1-columns.html\"><span class=\"text-middle\">1 Columns</span></a>
                                </li>
                                <li><a href=\"blog-grid-2-columns.html\"><span class=\"text-middle\">2 Columns</span></a>
                                </li>
                                <li><a href=\"blog-grid-3-columns.html\"><span class=\"text-middle\">3 Columns</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Masonry</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-masonry-1-columns.html\"><span class=\"text-middle\">1 Columns</span></a>
                                </li>
                                <li><a href=\"blog-masonry-2-columns.html\"><span class=\"text-middle\">2 Columns</span></a>
                                </li>
                                <li><a href=\"blog-masonry-3-columns.html\"><span class=\"text-middle\">3 Columns</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Timeline</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-timeline-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-timeline-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-timeline-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-single.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                                <li><a href=\"blog-timeline-archive.html\"><span class=\"text-middle\">Archive</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Modern</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-modern-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-modern-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-modern-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a href=\"shop-grid-left-sidebar.html\"><span>Multi Servicios</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Grid View</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-grid-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-grid-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-grid-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">List View</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-list-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-list-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-list-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Single Product</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-single-product-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-single-product-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-single-product-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"shop-cart.html\"><span class=\"text-middle\">Cart View</span></a>
                            </li>
                            <li><a href=\"shop-checkout.html\"><span class=\"text-middle\">Checkout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-checkout.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"shop-checkout-variant-2.html\"><span class=\"text-middle\">Variant 2</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a href=\"ui-kit.html\"><span>Contabilidad</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <!-- Responsive-tabs-->
                            <div class=\"responsive-tabs responsive-tabs-classic\" data-type=\"horizontal\">
                              <ul class=\"resp-tabs-list tabs-1 text-center tabs-group-default\" data-group=\"tabs-group-default\">
                                <li>Toolkit Components</li>
                                <li>Bootstrap Components</li>
                              </ul>
                              <div class=\"resp-tabs-container text-left tabs-group-default\" data-group=\"tabs-group-default\">
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"accordions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-playlist-plus\"></span><span class=\"text-middle\">Accordions</span></a></li>
                                    <li><a href=\"alerts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-alert-outline\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"animations.html\"><span class=\"novi-icon rd-navbar-icon fa fa-magic\"></span><span class=\"text-middle\">Animations</span></a></li>
                                    <li><a href=\"breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drag-horizontal\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"buttons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-shuffle\"></span><span class=\"text-middle\">Buttons</span></a></li>
                                    <li><a href=\"call-to-actions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-triangle\"></span><span class=\"text-middle\">Call to actions</span></a></li>
                                    <li><a href=\"lists-of-comments.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-multiple-outline\"></span><span class=\"text-middle\">Lists of comments</span></a></li>
                                    <li><a href=\"content-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-outline\"></span><span class=\"text-middle\">Content boxes</span></a></li>
                                    <li><a href=\"offer-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-checkbox-multiple-blank-outline\"></span><span class=\"text-middle\">Offer boxes</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"counters.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timelapse\"></span><span class=\"text-middle\">Counters</span></a></li>
                                    <li><a href=\"dividers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-division\"></span><span class=\"text-middle\">Dividers</span></a></li>
                                    <li><a href=\"footer-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-bottom\"></span><span class=\"text-middle\">Footer widgets</span></a></li>
                                    <li><a href=\"form-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-keyboard-variant\"></span><span class=\"text-middle\">Form elements</span></a></li>
                                    <li><a href=\"grid-system.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-week\"></span><span class=\"text-middle\">Grid system</span></a></li>
                                    <li><a href=\"product-grids.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-module\"></span><span class=\"text-middle\">Product Grids</span></a></li>
                                    <li><a href=\"icon-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-emoticon\"></span><span class=\"text-middle\">Icon boxes</span></a></li>
                                    <li><a href=\"icons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drawing\"></span><span class=\"text-middle\">Icons</span></a></li>
                                    <li><a href=\"infographics.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-trending-up\"></span><span class=\"text-middle\">Infographics</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"labels.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-label-outline\"></span><span class=\"text-middle\">Labels</span></a></li>
                                    <li><a href=\"lists.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-list-numbers\"></span><span class=\"text-middle\">Lists</span></a></li>
                                    <li><a href=\"maps.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Maps</span></a></li>
                                    <li><a href=\"media-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-youtube-play\"></span><span class=\"text-middle\">Media elements</span></a></li>
                                    <li><a href=\"member-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-account-circle\"></span><span class=\"text-middle\">Member boxes</span></a></li>
                                    <li><a href=\"navigation.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-unfolded\"></span><span class=\"text-middle\">Navigation</span></a></li>
                                    <li><a href=\"pagination.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-numeric-1-box-outline\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"posts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-clipboard-outline\"></span><span class=\"text-middle\">Posts</span></a></li>
                                    <li><a href=\"pricing-and-plans.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-coin\"></span><span class=\"text-middle\">Pricing and plans</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"sections.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-difference-ba\"></span><span class=\"text-middle\">Sections</span></a></li>
                                    <li><a href=\"sidebar-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-left\"></span><span class=\"text-middle\">Sidebar widgets</span></a></li>
                                    <li><a href=\"tables.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-table\"></span><span class=\"text-middle\">Tables</span></a></li>
                                    <li><a href=\"tabs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-line-spacing\"></span><span class=\"text-middle\">Tabs</span></a></li>
                                    <li><a href=\"testimonials.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-text-outline\"></span><span class=\"text-middle\">Testimonials</span></a></li>
                                    <li><a href=\"text-rotator.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-textdirection-l-to-r\"></span><span class=\"text-middle\">Text rotator</span></a></li>
                                    <li><a href=\"thumbnails.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-credit-card-scan\"></span><span class=\"text-middle\">Thumbnails</span></a></li>
                                    <li><a href=\"timers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timer\"></span><span class=\"text-middle\">Timers</span></a></li>
                                    <li><a href=\"typography.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-text\"></span><span class=\"text-middle\">Typography</span></a></li>
                                  </ul>
                                </div>
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-alerts.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"bootstrap-badges.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Badges</span></a></li>
                                    <li><a href=\"bootstrap-breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"bootstrap-button-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Groups</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-button-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-input-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Input Groups</span></a></li>
                                    <li><a href=\"bootstrap-jumbotron.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Jumbotron</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-list-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">List Groups</span></a></li>
                                    <li><a href=\"bootstrap-media-objects.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Media Objects</span></a></li>
                                    <li><a href=\"bootstrap-navbar.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navbar</span></a></li>
                                    <li><a href=\"bootstrap-navs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navs</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-page-header.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Page Header</span></a></li>
                                    <li><a href=\"bootstrap-pagination.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"bootstrap-progress-bars.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Progress Bars</span></a></li>
                                    <li><a href=\"bootstrap-responsive-embed.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Responsive embed</span></a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li><a href=\"ui-kit.html\"><span>Reportes</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <!-- Responsive-tabs-->
                            <div class=\"responsive-tabs responsive-tabs-classic\" data-type=\"horizontal\">
                              <ul class=\"resp-tabs-list tabs-1 text-center tabs-group-default\" data-group=\"tabs-group-default\">
                                <li>Toolkit Components</li>
                                <li>Bootstrap Components</li>
                              </ul>
                              <div class=\"resp-tabs-container text-left tabs-group-default\" data-group=\"tabs-group-default\">
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"accordions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-playlist-plus\"></span><span class=\"text-middle\">Accordions</span></a></li>
                                    <li><a href=\"alerts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-alert-outline\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"animations.html\"><span class=\"novi-icon rd-navbar-icon fa fa-magic\"></span><span class=\"text-middle\">Animations</span></a></li>
                                    <li><a href=\"breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drag-horizontal\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"buttons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-shuffle\"></span><span class=\"text-middle\">Buttons</span></a></li>
                                    <li><a href=\"call-to-actions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-triangle\"></span><span class=\"text-middle\">Call to actions</span></a></li>
                                    <li><a href=\"lists-of-comments.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-multiple-outline\"></span><span class=\"text-middle\">Lists of comments</span></a></li>
                                    <li><a href=\"content-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-outline\"></span><span class=\"text-middle\">Content boxes</span></a></li>
                                    <li><a href=\"offer-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-checkbox-multiple-blank-outline\"></span><span class=\"text-middle\">Offer boxes</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"counters.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timelapse\"></span><span class=\"text-middle\">Counters</span></a></li>
                                    <li><a href=\"dividers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-division\"></span><span class=\"text-middle\">Dividers</span></a></li>
                                    <li><a href=\"footer-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-bottom\"></span><span class=\"text-middle\">Footer widgets</span></a></li>
                                    <li><a href=\"form-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-keyboard-variant\"></span><span class=\"text-middle\">Form elements</span></a></li>
                                    <li><a href=\"grid-system.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-week\"></span><span class=\"text-middle\">Grid system</span></a></li>
                                    <li><a href=\"product-grids.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-module\"></span><span class=\"text-middle\">Product Grids</span></a></li>
                                    <li><a href=\"icon-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-emoticon\"></span><span class=\"text-middle\">Icon boxes</span></a></li>
                                    <li><a href=\"icons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drawing\"></span><span class=\"text-middle\">Icons</span></a></li>
                                    <li><a href=\"infographics.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-trending-up\"></span><span class=\"text-middle\">Infographics</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"labels.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-label-outline\"></span><span class=\"text-middle\">Labels</span></a></li>
                                    <li><a href=\"lists.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-list-numbers\"></span><span class=\"text-middle\">Lists</span></a></li>
                                    <li><a href=\"maps.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Maps</span></a></li>
                                    <li><a href=\"media-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-youtube-play\"></span><span class=\"text-middle\">Media elements</span></a></li>
                                    <li><a href=\"member-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-account-circle\"></span><span class=\"text-middle\">Member boxes</span></a></li>
                                    <li><a href=\"navigation.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-unfolded\"></span><span class=\"text-middle\">Navigation</span></a></li>
                                    <li><a href=\"pagination.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-numeric-1-box-outline\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"posts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-clipboard-outline\"></span><span class=\"text-middle\">Posts</span></a></li>
                                    <li><a href=\"pricing-and-plans.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-coin\"></span><span class=\"text-middle\">Pricing and plans</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"sections.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-difference-ba\"></span><span class=\"text-middle\">Sections</span></a></li>
                                    <li><a href=\"sidebar-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-left\"></span><span class=\"text-middle\">Sidebar widgets</span></a></li>
                                    <li><a href=\"tables.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-table\"></span><span class=\"text-middle\">Tables</span></a></li>
                                    <li><a href=\"tabs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-line-spacing\"></span><span class=\"text-middle\">Tabs</span></a></li>
                                    <li><a href=\"testimonials.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-text-outline\"></span><span class=\"text-middle\">Testimonials</span></a></li>
                                    <li><a href=\"text-rotator.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-textdirection-l-to-r\"></span><span class=\"text-middle\">Text rotator</span></a></li>
                                    <li><a href=\"thumbnails.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-credit-card-scan\"></span><span class=\"text-middle\">Thumbnails</span></a></li>
                                    <li><a href=\"timers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timer\"></span><span class=\"text-middle\">Timers</span></a></li>
                                    <li><a href=\"typography.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-text\"></span><span class=\"text-middle\">Typography</span></a></li>
                                  </ul>
                                </div>
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-alerts.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"bootstrap-badges.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Badges</span></a></li>
                                    <li><a href=\"bootstrap-breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"bootstrap-button-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Groups</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-button-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-input-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Input Groups</span></a></li>
                                    <li><a href=\"bootstrap-jumbotron.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Jumbotron</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-list-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">List Groups</span></a></li>
                                    <li><a href=\"bootstrap-media-objects.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Media Objects</span></a></li>
                                    <li><a href=\"bootstrap-navbar.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navbar</span></a></li>
                                    <li><a href=\"bootstrap-navs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navs</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-page-header.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Page Header</span></a></li>
                                    <li><a href=\"bootstrap-pagination.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"bootstrap-progress-bars.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Progress Bars</span></a></li>
                                    <li><a href=\"bootstrap-responsive-embed.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Responsive embed</span></a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li><a href=\"ui-kit.html\"><span>Controles</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <!-- Responsive-tabs-->
                            <div class=\"responsive-tabs responsive-tabs-classic\" data-type=\"horizontal\">
                              <ul class=\"resp-tabs-list tabs-1 text-center tabs-group-default\" data-group=\"tabs-group-default\">
                                <li>Toolkit Components</li>
                                <li>Bootstrap Components</li>
                              </ul>
                              <div class=\"resp-tabs-container text-left tabs-group-default\" data-group=\"tabs-group-default\">
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"accordions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-playlist-plus\"></span><span class=\"text-middle\">Accordions</span></a></li>
                                    <li><a href=\"alerts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-alert-outline\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"animations.html\"><span class=\"novi-icon rd-navbar-icon fa fa-magic\"></span><span class=\"text-middle\">Animations</span></a></li>
                                    <li><a href=\"breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drag-horizontal\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"buttons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-shuffle\"></span><span class=\"text-middle\">Buttons</span></a></li>
                                    <li><a href=\"call-to-actions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-triangle\"></span><span class=\"text-middle\">Call to actions</span></a></li>
                                    <li><a href=\"lists-of-comments.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-multiple-outline\"></span><span class=\"text-middle\">Lists of comments</span></a></li>
                                    <li><a href=\"content-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-outline\"></span><span class=\"text-middle\">Content boxes</span></a></li>
                                    <li><a href=\"offer-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-checkbox-multiple-blank-outline\"></span><span class=\"text-middle\">Offer boxes</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"counters.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timelapse\"></span><span class=\"text-middle\">Counters</span></a></li>
                                    <li><a href=\"dividers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-division\"></span><span class=\"text-middle\">Dividers</span></a></li>
                                    <li><a href=\"footer-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-bottom\"></span><span class=\"text-middle\">Footer widgets</span></a></li>
                                    <li><a href=\"form-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-keyboard-variant\"></span><span class=\"text-middle\">Form elements</span></a></li>
                                    <li><a href=\"grid-system.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-week\"></span><span class=\"text-middle\">Grid system</span></a></li>
                                    <li><a href=\"product-grids.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-module\"></span><span class=\"text-middle\">Product Grids</span></a></li>
                                    <li><a href=\"icon-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-emoticon\"></span><span class=\"text-middle\">Icon boxes</span></a></li>
                                    <li><a href=\"icons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drawing\"></span><span class=\"text-middle\">Icons</span></a></li>
                                    <li><a href=\"infographics.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-trending-up\"></span><span class=\"text-middle\">Infographics</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"labels.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-label-outline\"></span><span class=\"text-middle\">Labels</span></a></li>
                                    <li><a href=\"lists.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-list-numbers\"></span><span class=\"text-middle\">Lists</span></a></li>
                                    <li><a href=\"maps.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Maps</span></a></li>
                                    <li><a href=\"media-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-youtube-play\"></span><span class=\"text-middle\">Media elements</span></a></li>
                                    <li><a href=\"member-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-account-circle\"></span><span class=\"text-middle\">Member boxes</span></a></li>
                                    <li><a href=\"navigation.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-unfolded\"></span><span class=\"text-middle\">Navigation</span></a></li>
                                    <li><a href=\"pagination.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-numeric-1-box-outline\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"posts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-clipboard-outline\"></span><span class=\"text-middle\">Posts</span></a></li>
                                    <li><a href=\"pricing-and-plans.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-coin\"></span><span class=\"text-middle\">Pricing and plans</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"sections.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-difference-ba\"></span><span class=\"text-middle\">Sections</span></a></li>
                                    <li><a href=\"sidebar-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-left\"></span><span class=\"text-middle\">Sidebar widgets</span></a></li>
                                    <li><a href=\"tables.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-table\"></span><span class=\"text-middle\">Tables</span></a></li>
                                    <li><a href=\"tabs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-line-spacing\"></span><span class=\"text-middle\">Tabs</span></a></li>
                                    <li><a href=\"testimonials.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-text-outline\"></span><span class=\"text-middle\">Testimonials</span></a></li>
                                    <li><a href=\"text-rotator.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-textdirection-l-to-r\"></span><span class=\"text-middle\">Text rotator</span></a></li>
                                    <li><a href=\"thumbnails.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-credit-card-scan\"></span><span class=\"text-middle\">Thumbnails</span></a></li>
                                    <li><a href=\"timers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timer\"></span><span class=\"text-middle\">Timers</span></a></li>
                                    <li><a href=\"typography.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-text\"></span><span class=\"text-middle\">Typography</span></a></li>
                                  </ul>
                                </div>
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-alerts.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"bootstrap-badges.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Badges</span></a></li>
                                    <li><a href=\"bootstrap-breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"bootstrap-button-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Groups</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-button-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-input-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Input Groups</span></a></li>
                                    <li><a href=\"bootstrap-jumbotron.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Jumbotron</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-list-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">List Groups</span></a></li>
                                    <li><a href=\"bootstrap-media-objects.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Media Objects</span></a></li>
                                    <li><a href=\"bootstrap-navbar.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navbar</span></a></li>
                                    <li><a href=\"bootstrap-navs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navs</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-page-header.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Page Header</span></a></li>
                                    <li><a href=\"bootstrap-pagination.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"bootstrap-progress-bars.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Progress Bars</span></a></li>
                                    <li><a href=\"bootstrap-responsive-embed.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Responsive embed</span></a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!--RD Navbar Search-->
                  <div class=\"rd-navbar-search\"><a class=\"rd-navbar-search-toggle mdi\" data-rd-navbar-toggle=\".rd-navbar-inner,.rd-navbar-search\" href=\"#\"><span></span></a>
                    <form class=\"rd-navbar-search-form search-form-icon-right rd-search\" action=\"search-results.html\" method=\"GET\">
                      <div class=\"form-group\">
                        <label class=\"form-label\" for=\"rd-navbar-search-form-control\">Type and hit enter...</label>
                        <input class=\"rd-navbar-search-form-control form-control form-control-gray-lightest\" id=\"rd-navbar-search-form-control\" type=\"text\" name=\"s\" autocomplete=\"off\"/>
                      </div>
                    </form>
                  </div>
                  <!--RD Navbar shop-->
                  <div class=\"rd-navbar-cart-wrap\">
                  <a class=\"rd-navbar-cart mdi icon-user \"  href=\"#\" ><span></span><br> <p class=\"p-text\">Usuario</p></a>
                  <a class=\"rd-navbar-cart mdi icon-notification\" href=\"#\" ><span></span> <br> <p class=\"p-text\">Atender</p></a>
                  <a class=\"rd-navbar-cart mdi icon-ventas\"  href=\"#\" ><span></span><br> <p class=\"p-text\">Servicio</p></a>
                  <a class=\"rd-navbar-cart mdi icon-carrito \"  data-rd-navbar-toggle=\".rd-navbar-cart-dropdown\" href=\"#\" ><span></span><br> <p class=\"p-text\">Factura</p></a>
                  <a class=\"rd-navbar-cart mdi icon-texto\"  href=\"#\" ><span class=\"span-text\" style=\"width: 115px;\" >\$ 00.00</span><br> <p style=\"margin-top: -3px;\" class=\"p-text\">Valor Total</p></a>
                 
                    <div class=\"rd-navbar-cart-dropdown\">
                      <ul class=\"rd-navbar-list-products\">
                        <li>
                          <div class=\"rd-navbar-product-image\"><img src=\"images/shop/product-01-60x60.png\" alt=\"\"/></div>
                          <div class=\"rd-navbar-product-caption\">
                            <h6 class=\"rd-navbar-product-title\"><a href=\"shop-single-product-left-sidebar.html\">Fashion model new</a></h6>
                            <p class=\"rd-navbar-product-price\">\$129.99</p>
                          </div><a class=\"mdi mdi-window-close rd-navbar-product-remove\" href=\"#\"></a>
                        </li>
                        <li>
                          <div class=\"rd-navbar-product-image\"><img src=\"images/shop/product-01-60x60-3.png\" alt=\"\"/></div>
                          <div class=\"rd-navbar-product-caption\">
                            <h6 class=\"rd-navbar-product-title\"><a href=\"shop-single-product-left-sidebar.html\">Fashion model new 2</a></h6>
                            <p class=\"rd-navbar-product-price\">\$69.99</p>
                          </div><a class=\"mdi mdi-window-close rd-navbar-product-remove\" href=\"#\"></a>
                        </li>
                      </ul>
                      <div class=\"rd-navbar-cart-total\">
                        <h6 class=\"rd-navbar-cart-total-title\">Cart subtotal</h6><span class=\"rd-navbar-cart-total-price\">\$199.98</span>
                      </div>
                      <div class=\"text-center\"><a class=\"btn btn-rect btn-sm btn-primary btn-icon btn-icon-left\" href=\"shop-cart.html\"><span class=\"icon novi-icon mdi mdi-lock\"></span>Go to checkout</a></div>
                    </div>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </header>

        <div class=\"container section-34 section-sm-34\">
          <div class=\"row align-items-xl-center\">
            <div class=\"col-xl-5 d-none d-xl-block text-xl-left\">     
            </div>
            <div class=\"col-xl-2 d-none d-md-block\">       
            </div>
            <div class=\"offset-top-0 offset-md-top-10 col-xl-5 offset-xl-top-0 small text-xl-right\">
              <ul class=\"list-inline list-inline-dashed p\">
                <li class=\"list-inline-item\"><a href=\"index.html\">Home</a></li>
                <li class=\"list-inline-item\"><a href=\"#\">Pages</a></li>
                <li class=\"list-inline-item\">Services
                </li>
              </ul>
            </div>
          </div>
        </div>
      
    ";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "layout/header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 44,  85 => 38,  62 => 18,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("  <head>
    <title>Services</title>
    <meta charset=\"utf-8\">
    <meta name=\"format-detection\" content=\"telephone=no\">
    <meta name=\"viewport\" content=\"width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=Edge\">
    <meta name=\"keywords\" content=\"intense web design multipurpose template html\">
    <meta name=\"date\" content=\"Dec 26\">
    <link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/x-icon\">
   
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
        <!-- Page Header-->
        <header class=\"page-head\">
          <!-- RD Navbar Transparent-->
          <div class=\"rd-navbar-wrap\">
            <!--  <nav class=\"rd-navbar rd-navbar-default rd-navbar-dark\" data-md-device-layout=\"rd-navbar-fixed\" data-lg-device-layout=\"rd-navbar-fixed\" data-lg-auto-height=\"true\" data-md-layout=\"rd-navbar-fixed\" data-lg-layout=\"rd-navbar-fixed\" data-lg-stick-up=\"true\"> -->
             <nav class=\"rd-navbar rd-navbar-default rd-navbar-dark\" data-md-device-layout=\"rd-navbar-fixed\" data-lg-device-layout=\"rd-navbar-fixed\" data-lg-auto-height=\"true\" data-md-layout=\"rd-navbar-fixed\" data-lg-layout=\"rd-navbar-fixed\" data-lg-stick-up=\"true\">
            
              <div class=\"rd-navbar-inner\">
                <!-- RD Navbar Panel-->
                <div class=\"rd-navbar-panel\">
                  <!-- RD Navbar Toggle-->
                  <button class=\"rd-navbar-toggle\" data-rd-navbar-toggle=\".rd-navbar, .rd-navbar-nav-wrap\"><span></span></button>
                  <!--Navbar Brand-->
                  <div class=\"rd-navbar-brand\" style=\"left: 30%;\" ><a href=\"index.html\"><img style='margin-left: -15px;' width='184' height='54' src=\"{{ asset('images/logo-chico.png') }}\"  alt=''/></a></div>
                </div>
                <div class=\"rd-navbar-menu-wrap\">
                  <div class=\"rd-navbar-nav-wrap\">
                    <div class=\"rd-navbar-mobile-scroll\">
                      <!--Navbar Brand Mobile-->
                      <div class=\"rd-navbar-mobile-brand\"><a href=\"index.html\"><img style='margin-top: -5px;margin-left: -15px;' width='138' height='40' src=\"{{ asset('images/logo-chico.png') }}\" alt=''/></a></div>
                      <div class=\"form-search-wrap\">
                        <!-- RD Search Form-->
                        <form class=\"form-search rd-search\" action=\"search-results.html\" method=\"GET\">
                          <div class=\"form-group\">
                            <label class=\"form-label form-search-label form-label-sm\" for=\"rd-navbar-form-search-widget\">Search</label>
                            <input class=\"form-search-input input-sm form-control form-control-gray-lightest input-sm\" id=\"rd-navbar-form-search-widget\" type=\"text\" name=\"s\" autocomplete=\"off\"/>
                          </div>
                          <button class=\"form-search-submit\" type=\"submit\"><span class=\"novi-icon mdi mdi-magnify\"></span></button>
                        </form>
                      </div>
                      <!-- RD Navbar Nav-->
                      <ul class=\"rd-navbar-nav\">
                        <li><a href=\"index.html\"><span>Telecomunicaciones</span><span class=\"rd-navbar-label text-middle label-custom label-xs-custom label-rounded-custom label label-info\">novi</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Child Themes</span><span class=\"rd-navbar-label label-custom label-xs-custom label-rounded-custom label label-info\">novi</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"child/intense-photographer-portfolio/index.html\"><span class=\"text-middle\">Photographer</span></a>
                                </li>
                                <li><a href=\"child/intense-restaurant/index.html\"><span class=\"text-middle\">Restaurant</span></a>
                                </li>
                                <li><a href=\"child/intense-personal-blog/index.html\"><span class=\"text-middle\">Personal Blog</span></a>
                                </li>
                                <li><a href=\"child/intense-real-estate/index.html\"><span class=\"text-middle\">Real Estate</span></a>
                                </li>
                                <li><a href=\"child/intense-handmade/index.html\"><span class=\"text-middle\">Handmade</span></a>
                                </li>
                                <li><a href=\"child/intense-dental-clinic/index.html\"><span class=\"text-middle\">Dental Clinic</span></a>
                                </li>
                                <li><a href=\"child/intense-financial-analytic/index.html\"><span class=\"text-middle\">Financial Advisor</span></a>
                                </li>
                                <li><a href=\"child/intense-gym/index.html\"><span class=\"text-middle\">Gym</span></a>
                                </li>
                                <li><a href=\"child/intense-child-care/index.html\"><span class=\"text-middle\">Child Care</span></a>
                                </li>
                                <li><a href=\"child/intense-job-board/index.html\"><span class=\"text-middle\">Job Board</span></a>
                                </li>
                                <li><a href=\"newsletter/responsive/index.html\"><span class=\"text-middle\">Newsletter</span></a>
                                </li>
                                <li><a href=\"child/intense-taxi/index.html\"><span class=\"text-middle\">Taxi</span></a>
                                </li>
                                <li><a href=\"child/intense-pet-shop/index.html\"><span class=\"text-middle\">Pet shop</span></a>
                                </li>
                                <li><a href=\"child/intense-barbershop/index.html\"><span class=\"text-middle\">Barbershop</span></a>
                                </li>
                                <li><a href=\"child/car-repair/index.html\"><span class=\"text-middle\">Car Repair</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Landing pages</span><span class=\"rd-navbar-label label-custom label-xs-custom label-rounded-custom label label-info\">novi</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"child/intense-application/index.html\"><span class=\"text-middle\">Application</span></a>
                                </li>
                                <li><a href=\"child/intense-book/index.html\"><span class=\"text-middle\">Book</span></a>
                                </li>
                                <li><a href=\"child/intense-product/index.html\"><span class=\"text-middle\">Product</span></a>
                                </li>
                                <li><a href=\"child/intense-travel/index.html\"><span class=\"text-middle\">Travel</span></a>
                                </li>
                                <li><a href=\"child/intense-startup/index.html\"><span class=\"text-middle\">Startup</span></a>
                                </li>
                                <li><a href=\"child/intense-event/index.html\"><span class=\"text-middle\">Event</span></a>
                                </li>
                                <li><a href=\"child/landing-agency/index.html\"><span class=\"text-middle\">Agency</span></a>
                                </li>
                                <li><a href=\"child/landing-business/index.html\"><span class=\"text-middle\">Business</span></a>
                                </li>
                                <li><a href=\"child/landing-corporate/index.html\"><span class=\"text-middle\">Corporate</span></a>
                                </li>
                                <li><a href=\"child/landing-personal/index.html\"><span class=\"text-middle\">Personal</span></a>
                                </li>
                                <li><a href=\"child/landing-shop/index.html\"><span class=\"text-middle\">Shop</span></a>
                                </li>
                                <li><a href=\"child/landing-startup/index.html\"><span class=\"text-middle\">Startup</span></a>
                                </li>
                                <li><a href=\"child/black-friday/index.html\"><span class=\"text-middle\">Black Friday</span></a>
                                </li>
                                <li><a href=\"child/christmas-cards/index.html\"><span class=\"text-middle\">Christmas Cards</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Home Types</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"index.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"index-one-page.html\"><span class=\"text-middle\">One Page</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Home Skins</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"index-variant-2.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"index-skin-sunset.html\"><span class=\"text-middle\">Sunset</span></a>
                                </li>
                                <li><a href=\"index-skin-simply-chic.html\"><span class=\"text-middle\">Simply Chic</span></a>
                                </li>
                                <li><a href=\"index-skin-minimal-blue.html\"><span class=\"text-middle\">Minimal Blue</span></a>
                                </li>
                                <li><a href=\"index-skin-sunrise.html\"><span class=\"text-middle\">Sunrise</span></a>
                                </li>
                                <li><a href=\"index-skin-renaissance.html\"><span class=\"text-middle\">Renaissance</span></a>
                                </li>
                                <li><a href=\"index-skin-green-space.html\"><span class=\"text-middle\">Green Space</span></a>
                                </li>
                                <li><a href=\"index-skin-red-energy.html\"><span class=\"text-middle\">Red Energy</span></a>
                                </li>
                                <li><a href=\"index-skin-eternal-joy.html\"><span class=\"text-middle\">Eternal Joy</span></a>
                                </li>
                                <li><a href=\"index-skin-commercial.html\"><span class=\"text-middle\">Commercial</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"index.html\"><span class=\"text-middle\">Home Intro</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"index-variant-2.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"index-promo.html\"><span class=\"text-middle\">Promo</span></a>
                                </li>
                                <li><a href=\"index-fast-registration.html\"><span class=\"text-middle\">Fast Registration</span></a>
                                </li>
                                <li><a href=\"index-make-an-appointment.html\"><span class=\"text-middle\">Appointment</span></a>
                                </li>
                                <li><a href=\"index-video-background.html\"><span class=\"text-middle\">Video Background</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a class=\"new\" href=\"#\"><span>Paqueteria</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Revolution slider</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"revolution-crossfade.html\"><span class=\"text-middle\">Slider crossfade</span></a>
                                </li>
                                <li><a href=\"revolution-fadethrough.html\"><span class=\"text-middle\">Slider fade through</span></a>
                                </li>
                                <li><a href=\"revolution-slidehorizontal.html\"><span class=\"text-middle\">Slider slide 1</span></a>
                                </li>
                                <li><a href=\"revolution-slidevertical.html\"><span class=\"text-middle\">Slider slide 2</span></a>
                                </li>
                                <li><a href=\"revolution-slidingoverlayhorizontal.html\"><span class=\"text-middle\">Slider overlay 1</span></a>
                                </li>
                                <li><a href=\"revolution-slidingoverlayvertical.html\"><span class=\"text-middle\">Slider overlay 2</span></a>
                                </li>
                                <li><a href=\"revolution-boxslide.html\"><span class=\"text-middle\">Slider box slide</span></a>
                                </li>
                                <li><a href=\"revolution-slotslide.html\"><span class=\"text-middle\">Slider slot slide</span></a>
                                </li>
                                <li><a href=\"revolution-boxfade.html\"><span class=\"text-middle\">Slider box fade</span></a>
                                </li>
                                <li><a href=\"revolution-slotfade.html\"><span class=\"text-middle\">Slider slot fade</span></a>
                                </li>
                                <li><a href=\"revolution-parallaxhorizontal.html\"><span class=\"text-middle\">Slider parallax 1</span></a>
                                </li>
                                <li><a href=\"revolution-parallaxvertical.html\"><span class=\"text-middle\">Slider parallax 2</span></a>
                                </li>
                                <li><a href=\"revolution-slotzoom-horizontal.html\"><span class=\"text-middle\">Slider slot zoom 1</span></a>
                                </li>
                                <li><a href=\"revolution-slotzoom-vertical.html\"><span class=\"text-middle\">Slider slot zoom 2</span></a>
                                </li>
                                <li><a href=\"revolution-incube.html\"><span class=\"text-middle\">Slider incube</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Plugins</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"rd-event-calendar.html\"><span class=\"text-middle\">RD Event Calendar</span></a>
                                </li>
                                <li><a href=\"rd-parallax.html\"><span class=\"text-middle\">Parallax</span></a>
                                </li>
                                <li><a href=\"rd-video.html\"><span class=\"text-middle\">Vide</span></a>
                                </li>
                                <li><a href=\"rd-navbar.html\"><span class=\"text-middle\">RD Navbar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Social Widgets</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"rd-twitter-feed.html\"><span class=\"text-middle\">RD Twitter Feed</span></a>
                                </li>
                                <li><a href=\"rd-flickr-feed.html\"><span class=\"text-middle\">RD Flickr Gallery</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Headers</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"#\"><span class=\"text-middle\">Default</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-default-transparent.html\"><span class=\"text-middle\">Transparent</span></a>
                                    </li>
                                    <li><a href=\"header-default-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-default-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Sidebar toggle</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-sidebar-toggle-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-sidebar-toggle-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Sidebar fixed</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-sidebar-fixed-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-sidebar-fixed-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Floated</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-floated-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-floated-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">With Top Panel</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-top-panel-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-top-panel-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a href=\"#\"><span class=\"text-middle\">Logo center</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"header-logo-center-light.html\"><span class=\"text-middle\">Light</span></a>
                                    </li>
                                    <li><a href=\"header-logo-center-dark.html\"><span class=\"text-middle\">Dark</span></a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Footers</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"footer-default.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"footer-variant-2.html\"><span class=\"text-middle\">Variant 2</span></a>
                                </li>
                                <li><a href=\"footer-variant-3.html\"><span class=\"text-middle\">Variant 3</span></a>
                                </li>
                                <li><a href=\"footer-variant-4.html\"><span class=\"text-middle\">Variant 4</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Page Loaders</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"page-loader-variant-1.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"rd-mailform.html\"><span class=\"text-middle\">Form Plugins</span></a>
                            </li>
                            <li><a href=\"captcha.html\"><span class=\"text-middle\">google reCaptcha</span></a>
                            </li>
                            <li><a href=\"subscribe.html\"><span class=\"text-middle\">Mailchimp &amp; Campaign Monitor</span></a>
                            </li>
                            <li><a href=\"charts-and-graphs.html\"><span class=\"text-middle\">Charts and Graphs</span></a>
                            </li>
                            <li><a href=\"ui-kit.html\"><span class=\"text-middle\">Advanced UI Kit</span></a>
                            </li>
                          </ul>
                        </li>
                        <li class=\"active\"><a href=\"#\"><span>Canasta Familiar</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <div class=\"row\">
                              <ul class=\"col-xl-3\">
                                <li><a href=\"404.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-bullhorn\"></span><span class=\"text-middle\">404 Page</span></a></li>
                                <li><a href=\"503.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-bullhorn\"></span><span class=\"text-middle\">503 Page</span></a></li>
                                <li><a href=\"about-us.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple\"></span><span class=\"text-middle\">About Us</span></a></li>
                                <li><a href=\"about-us-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple\"></span><span class=\"text-middle\">About Us v2</span></a></li>
                                <li><a href=\"about-me.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-convert\"></span><span class=\"text-middle\">About Me</span></a></li>
                                <li><a href=\"about-me-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-convert\"></span><span class=\"text-middle\">About Me v2</span></a></li>
                                <li><a href=\"services.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-folder-outline\"></span><span class=\"text-middle\">Services</span></a></li>
                                <li><a href=\"our-team.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-switch\"></span><span class=\"text-middle\">Our Team</span></a></li>
                                <li><a href=\"our-team-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-switch\"></span><span class=\"text-middle\">Our Team v2</span></a></li>
                              </ul>
                              <ul class=\"col-xl-3\">
                                <li><a href=\"team-member.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-box-outline\"></span><span class=\"text-middle\">Team Member</span></a></li>
                                <li><a href=\"team-member-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-box-outline\"></span><span class=\"text-middle\">Team Member v2</span></a></li>
                                <li><a href=\"careers.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-check\"></span><span class=\"text-middle\">Careers</span></a></li>
                                <li><a href=\"categories.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-filter-variant\"></span><span class=\"text-middle\">Categories</span></a></li>
                                <li><a href=\"faq.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq</span></a></li>
                                <li><a href=\"faq-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq v2</span></a></li>
                                <li><a href=\"faq-variant-3.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq v3</span></a></li>
                                <li><a href=\"faq-variant-4.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-help-circle\"></span><span class=\"text-middle\">Faq v4</span></a></li>
                                <li><a href=\"contact-me.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-contact-mail\"></span><span class=\"text-middle\">Contact Me</span></a></li>
                              </ul>
                              <ul class=\"col-xl-3\">
                                <li><a href=\"contact-us.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Contact Us</span></a></li>
                                <li><a href=\"contact-us-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Contact Us v2</span></a></li>
                                <li><a href=\"get-in-touch.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Get In Touch</span></a></li>
                                <li><a href=\"contact-us-variant-3.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Contact Us v3</span></a></li>
                                <li><a href=\"subscribe.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-email-outline\"></span><span class=\"text-middle\">Subscribe</span></a></li>
                                <li><a href=\"sitemap.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-sitemap\"></span><span class=\"text-middle\">Sitemap</span></a></li>
                                <li><a href=\"coming-soon.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-clock-fast\"></span><span class=\"text-middle\">Coming Soon</span></a></li>
                                <li><a href=\"search-results.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-magnify\"></span><span class=\"text-middle\">Search Results</span></a></li>
                                <li><a href=\"login.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-login\"></span><span class=\"text-middle\">Login</span></a></li>
                              </ul>
                              <ul class=\"col-xl-3\">
                                <li><a href=\"register.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple-outline\"></span><span class=\"text-middle\">Register</span></a></li>
                                <li><a href=\"register-login.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-account-multiple-outline\"></span><span class=\"text-middle\">Login / Register</span></a></li>
                                <li><a href=\"pricing.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-certificate\"></span><span class=\"text-middle\">Pricing</span></a></li>
                                <li><a href=\"make-an-appointment.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-calendar-clock\"></span><span class=\"text-middle\">Appointment</span></a></li>
                                <li><a href=\"make-an-appointment-variant-2.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-calendar-clock\"></span><span class=\"text-middle\">Appointment v2</span></a></li>
                                <li><a href=\"maintenance.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-wrench\"></span><span class=\"text-middle\">Maintenance</span></a></li>
                                <li><a href=\"clients.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-wrench\"></span><span class=\"text-middle\">Clients</span></a></li>
                                <li><a href=\"under-construction.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-worker\"></span><span class=\"text-middle\">Under Construction</span></a></li>
                                <li><a href=\"privacy.html\"><span class=\"rd-navbar-icon novi-icon mdi mdi-file-outline\"></span><span class=\"text-middle\">Privacy Policy</span></a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li><a href=\"portfolio-grid-3-columns.html\"><span>Turismo</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Grid Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-grid-3-columns.html\"><span class=\"text-middle\">Horizontal</span></a>
                                </li>
                                <li><a href=\"portfolio-grid-3-columns-vertical.html\"><span class=\"text-middle\">Vertical</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Masonry Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-masonry-3-columns.html\"><span class=\"text-middle\">Horizontal</span></a>
                                </li>
                                <li><a href=\"portfolio-masonry-3-columns-vertical.html\"><span class=\"text-middle\">Vertical</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Wide Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-wide-3-columns.html\"><span class=\"text-middle\">Horizontal</span></a>
                                </li>
                                <li><a href=\"portfolio-wide-3-columns-vertical.html\"><span class=\"text-middle\">Vertical</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Fullwidth Layout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-fullwidth-3-columns.html\"><span class=\"text-middle\">3 Columns</span></a>
                                </li>
                                <li><a href=\"portfolio-fullwidth-4-columns.html\"><span class=\"text-middle\">4 Columns</span></a>
                                </li>
                                <li><a href=\"portfolio-fullwidth-5-columns.html\"><span class=\"text-middle\">5 Columns</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"portfolio-fullscreen-3-columns.html\"><span class=\"text-middle\">Fullscreen Layout</span></a>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Custom Effects</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-classic-effect.html\"><span class=\"text-middle\">Classic Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-zoe-effect.html\"><span class=\"text-middle\">Zoe Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-winston-effect.html\"><span class=\"text-middle\">Winston Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-josip-effect.html\"><span class=\"text-middle\">Josip Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-janes-effect.html\"><span class=\"text-middle\">Janes Effect</span></a>
                                </li>
                                <li><a href=\"portfolio-apollo-effect.html\"><span class=\"text-middle\">Apollo Effect</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Single Project</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"portfolio-single-project-default.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"portfolio-single-project-variant-2.html\"><span class=\"text-middle\">Variant 2</span></a>
                                </li>
                                <li><a href=\"portfolio-single-project-variant-3.html\"><span class=\"text-middle\">Variant 3</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a href=\"blog-default-left-sidebar.html\"><span>Tienda Virtual</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Classic</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-classic-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Events</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"events-list-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"events-list-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"events-list-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"events-list-single.html\"><span class=\"text-middle\">Single Event</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"events-list-single.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                    </li>
                                    <li><a href=\"events-list-single-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                    </li>
                                    <li><a href=\"events-list-single-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Wide</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-wide-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-single.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Default</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-default-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-default-single.html\"><span class=\"text-middle\">Single Post</span></a>
                                  <ul class=\"rd-navbar-dropdown\">
                                    <li><a href=\"blog-default-single.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                    </li>
                                    <li><a href=\"blog-default-single-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                    </li>
                                    <li><a href=\"blog-default-single-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                    </li>
                                    <li><a href=\"blog-default-single-both-sidebar.html\"><span class=\"text-middle\">Both Sidebar</span></a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Grid</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-grid-1-columns.html\"><span class=\"text-middle\">1 Columns</span></a>
                                </li>
                                <li><a href=\"blog-grid-2-columns.html\"><span class=\"text-middle\">2 Columns</span></a>
                                </li>
                                <li><a href=\"blog-grid-3-columns.html\"><span class=\"text-middle\">3 Columns</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Masonry</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-masonry-1-columns.html\"><span class=\"text-middle\">1 Columns</span></a>
                                </li>
                                <li><a href=\"blog-masonry-2-columns.html\"><span class=\"text-middle\">2 Columns</span></a>
                                </li>
                                <li><a href=\"blog-masonry-3-columns.html\"><span class=\"text-middle\">3 Columns</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Timeline</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-timeline-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-timeline-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-timeline-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-wide-single.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                                <li><a href=\"blog-timeline-archive.html\"><span class=\"text-middle\">Archive</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Blog Modern</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"blog-modern-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-modern-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-modern-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                                <li><a href=\"blog-classic-single-post.html\"><span class=\"text-middle\">Single Post</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a href=\"shop-grid-left-sidebar.html\"><span>Multi Servicios</span></a>
                          <ul class=\"rd-navbar-dropdown\">
                            <li><a href=\"#\"><span class=\"text-middle\">Grid View</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-grid-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-grid-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-grid-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">List View</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-list-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-list-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-list-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"#\"><span class=\"text-middle\">Single Product</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-single-product-no-sidebar.html\"><span class=\"text-middle\">No Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-single-product-left-sidebar.html\"><span class=\"text-middle\">Left Sidebar</span></a>
                                </li>
                                <li><a href=\"shop-single-product-right-sidebar.html\"><span class=\"text-middle\">Right Sidebar</span></a>
                                </li>
                              </ul>
                            </li>
                            <li><a href=\"shop-cart.html\"><span class=\"text-middle\">Cart View</span></a>
                            </li>
                            <li><a href=\"shop-checkout.html\"><span class=\"text-middle\">Checkout</span></a>
                              <ul class=\"rd-navbar-dropdown\">
                                <li><a href=\"shop-checkout.html\"><span class=\"text-middle\">Default</span></a>
                                </li>
                                <li><a href=\"shop-checkout-variant-2.html\"><span class=\"text-middle\">Variant 2</span></a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a href=\"ui-kit.html\"><span>Contabilidad</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <!-- Responsive-tabs-->
                            <div class=\"responsive-tabs responsive-tabs-classic\" data-type=\"horizontal\">
                              <ul class=\"resp-tabs-list tabs-1 text-center tabs-group-default\" data-group=\"tabs-group-default\">
                                <li>Toolkit Components</li>
                                <li>Bootstrap Components</li>
                              </ul>
                              <div class=\"resp-tabs-container text-left tabs-group-default\" data-group=\"tabs-group-default\">
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"accordions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-playlist-plus\"></span><span class=\"text-middle\">Accordions</span></a></li>
                                    <li><a href=\"alerts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-alert-outline\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"animations.html\"><span class=\"novi-icon rd-navbar-icon fa fa-magic\"></span><span class=\"text-middle\">Animations</span></a></li>
                                    <li><a href=\"breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drag-horizontal\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"buttons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-shuffle\"></span><span class=\"text-middle\">Buttons</span></a></li>
                                    <li><a href=\"call-to-actions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-triangle\"></span><span class=\"text-middle\">Call to actions</span></a></li>
                                    <li><a href=\"lists-of-comments.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-multiple-outline\"></span><span class=\"text-middle\">Lists of comments</span></a></li>
                                    <li><a href=\"content-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-outline\"></span><span class=\"text-middle\">Content boxes</span></a></li>
                                    <li><a href=\"offer-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-checkbox-multiple-blank-outline\"></span><span class=\"text-middle\">Offer boxes</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"counters.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timelapse\"></span><span class=\"text-middle\">Counters</span></a></li>
                                    <li><a href=\"dividers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-division\"></span><span class=\"text-middle\">Dividers</span></a></li>
                                    <li><a href=\"footer-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-bottom\"></span><span class=\"text-middle\">Footer widgets</span></a></li>
                                    <li><a href=\"form-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-keyboard-variant\"></span><span class=\"text-middle\">Form elements</span></a></li>
                                    <li><a href=\"grid-system.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-week\"></span><span class=\"text-middle\">Grid system</span></a></li>
                                    <li><a href=\"product-grids.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-module\"></span><span class=\"text-middle\">Product Grids</span></a></li>
                                    <li><a href=\"icon-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-emoticon\"></span><span class=\"text-middle\">Icon boxes</span></a></li>
                                    <li><a href=\"icons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drawing\"></span><span class=\"text-middle\">Icons</span></a></li>
                                    <li><a href=\"infographics.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-trending-up\"></span><span class=\"text-middle\">Infographics</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"labels.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-label-outline\"></span><span class=\"text-middle\">Labels</span></a></li>
                                    <li><a href=\"lists.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-list-numbers\"></span><span class=\"text-middle\">Lists</span></a></li>
                                    <li><a href=\"maps.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Maps</span></a></li>
                                    <li><a href=\"media-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-youtube-play\"></span><span class=\"text-middle\">Media elements</span></a></li>
                                    <li><a href=\"member-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-account-circle\"></span><span class=\"text-middle\">Member boxes</span></a></li>
                                    <li><a href=\"navigation.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-unfolded\"></span><span class=\"text-middle\">Navigation</span></a></li>
                                    <li><a href=\"pagination.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-numeric-1-box-outline\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"posts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-clipboard-outline\"></span><span class=\"text-middle\">Posts</span></a></li>
                                    <li><a href=\"pricing-and-plans.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-coin\"></span><span class=\"text-middle\">Pricing and plans</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"sections.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-difference-ba\"></span><span class=\"text-middle\">Sections</span></a></li>
                                    <li><a href=\"sidebar-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-left\"></span><span class=\"text-middle\">Sidebar widgets</span></a></li>
                                    <li><a href=\"tables.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-table\"></span><span class=\"text-middle\">Tables</span></a></li>
                                    <li><a href=\"tabs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-line-spacing\"></span><span class=\"text-middle\">Tabs</span></a></li>
                                    <li><a href=\"testimonials.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-text-outline\"></span><span class=\"text-middle\">Testimonials</span></a></li>
                                    <li><a href=\"text-rotator.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-textdirection-l-to-r\"></span><span class=\"text-middle\">Text rotator</span></a></li>
                                    <li><a href=\"thumbnails.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-credit-card-scan\"></span><span class=\"text-middle\">Thumbnails</span></a></li>
                                    <li><a href=\"timers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timer\"></span><span class=\"text-middle\">Timers</span></a></li>
                                    <li><a href=\"typography.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-text\"></span><span class=\"text-middle\">Typography</span></a></li>
                                  </ul>
                                </div>
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-alerts.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"bootstrap-badges.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Badges</span></a></li>
                                    <li><a href=\"bootstrap-breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"bootstrap-button-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Groups</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-button-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-input-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Input Groups</span></a></li>
                                    <li><a href=\"bootstrap-jumbotron.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Jumbotron</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-list-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">List Groups</span></a></li>
                                    <li><a href=\"bootstrap-media-objects.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Media Objects</span></a></li>
                                    <li><a href=\"bootstrap-navbar.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navbar</span></a></li>
                                    <li><a href=\"bootstrap-navs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navs</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-page-header.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Page Header</span></a></li>
                                    <li><a href=\"bootstrap-pagination.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"bootstrap-progress-bars.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Progress Bars</span></a></li>
                                    <li><a href=\"bootstrap-responsive-embed.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Responsive embed</span></a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li><a href=\"ui-kit.html\"><span>Reportes</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <!-- Responsive-tabs-->
                            <div class=\"responsive-tabs responsive-tabs-classic\" data-type=\"horizontal\">
                              <ul class=\"resp-tabs-list tabs-1 text-center tabs-group-default\" data-group=\"tabs-group-default\">
                                <li>Toolkit Components</li>
                                <li>Bootstrap Components</li>
                              </ul>
                              <div class=\"resp-tabs-container text-left tabs-group-default\" data-group=\"tabs-group-default\">
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"accordions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-playlist-plus\"></span><span class=\"text-middle\">Accordions</span></a></li>
                                    <li><a href=\"alerts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-alert-outline\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"animations.html\"><span class=\"novi-icon rd-navbar-icon fa fa-magic\"></span><span class=\"text-middle\">Animations</span></a></li>
                                    <li><a href=\"breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drag-horizontal\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"buttons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-shuffle\"></span><span class=\"text-middle\">Buttons</span></a></li>
                                    <li><a href=\"call-to-actions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-triangle\"></span><span class=\"text-middle\">Call to actions</span></a></li>
                                    <li><a href=\"lists-of-comments.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-multiple-outline\"></span><span class=\"text-middle\">Lists of comments</span></a></li>
                                    <li><a href=\"content-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-outline\"></span><span class=\"text-middle\">Content boxes</span></a></li>
                                    <li><a href=\"offer-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-checkbox-multiple-blank-outline\"></span><span class=\"text-middle\">Offer boxes</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"counters.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timelapse\"></span><span class=\"text-middle\">Counters</span></a></li>
                                    <li><a href=\"dividers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-division\"></span><span class=\"text-middle\">Dividers</span></a></li>
                                    <li><a href=\"footer-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-bottom\"></span><span class=\"text-middle\">Footer widgets</span></a></li>
                                    <li><a href=\"form-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-keyboard-variant\"></span><span class=\"text-middle\">Form elements</span></a></li>
                                    <li><a href=\"grid-system.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-week\"></span><span class=\"text-middle\">Grid system</span></a></li>
                                    <li><a href=\"product-grids.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-module\"></span><span class=\"text-middle\">Product Grids</span></a></li>
                                    <li><a href=\"icon-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-emoticon\"></span><span class=\"text-middle\">Icon boxes</span></a></li>
                                    <li><a href=\"icons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drawing\"></span><span class=\"text-middle\">Icons</span></a></li>
                                    <li><a href=\"infographics.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-trending-up\"></span><span class=\"text-middle\">Infographics</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"labels.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-label-outline\"></span><span class=\"text-middle\">Labels</span></a></li>
                                    <li><a href=\"lists.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-list-numbers\"></span><span class=\"text-middle\">Lists</span></a></li>
                                    <li><a href=\"maps.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Maps</span></a></li>
                                    <li><a href=\"media-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-youtube-play\"></span><span class=\"text-middle\">Media elements</span></a></li>
                                    <li><a href=\"member-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-account-circle\"></span><span class=\"text-middle\">Member boxes</span></a></li>
                                    <li><a href=\"navigation.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-unfolded\"></span><span class=\"text-middle\">Navigation</span></a></li>
                                    <li><a href=\"pagination.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-numeric-1-box-outline\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"posts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-clipboard-outline\"></span><span class=\"text-middle\">Posts</span></a></li>
                                    <li><a href=\"pricing-and-plans.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-coin\"></span><span class=\"text-middle\">Pricing and plans</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"sections.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-difference-ba\"></span><span class=\"text-middle\">Sections</span></a></li>
                                    <li><a href=\"sidebar-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-left\"></span><span class=\"text-middle\">Sidebar widgets</span></a></li>
                                    <li><a href=\"tables.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-table\"></span><span class=\"text-middle\">Tables</span></a></li>
                                    <li><a href=\"tabs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-line-spacing\"></span><span class=\"text-middle\">Tabs</span></a></li>
                                    <li><a href=\"testimonials.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-text-outline\"></span><span class=\"text-middle\">Testimonials</span></a></li>
                                    <li><a href=\"text-rotator.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-textdirection-l-to-r\"></span><span class=\"text-middle\">Text rotator</span></a></li>
                                    <li><a href=\"thumbnails.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-credit-card-scan\"></span><span class=\"text-middle\">Thumbnails</span></a></li>
                                    <li><a href=\"timers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timer\"></span><span class=\"text-middle\">Timers</span></a></li>
                                    <li><a href=\"typography.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-text\"></span><span class=\"text-middle\">Typography</span></a></li>
                                  </ul>
                                </div>
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-alerts.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"bootstrap-badges.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Badges</span></a></li>
                                    <li><a href=\"bootstrap-breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"bootstrap-button-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Groups</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-button-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-input-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Input Groups</span></a></li>
                                    <li><a href=\"bootstrap-jumbotron.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Jumbotron</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-list-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">List Groups</span></a></li>
                                    <li><a href=\"bootstrap-media-objects.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Media Objects</span></a></li>
                                    <li><a href=\"bootstrap-navbar.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navbar</span></a></li>
                                    <li><a href=\"bootstrap-navs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navs</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-page-header.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Page Header</span></a></li>
                                    <li><a href=\"bootstrap-pagination.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"bootstrap-progress-bars.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Progress Bars</span></a></li>
                                    <li><a href=\"bootstrap-responsive-embed.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Responsive embed</span></a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li><a href=\"ui-kit.html\"><span>Controles</span></a>
                          <div class=\"rd-navbar-megamenu\">
                            <!-- Responsive-tabs-->
                            <div class=\"responsive-tabs responsive-tabs-classic\" data-type=\"horizontal\">
                              <ul class=\"resp-tabs-list tabs-1 text-center tabs-group-default\" data-group=\"tabs-group-default\">
                                <li>Toolkit Components</li>
                                <li>Bootstrap Components</li>
                              </ul>
                              <div class=\"resp-tabs-container text-left tabs-group-default\" data-group=\"tabs-group-default\">
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"accordions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-playlist-plus\"></span><span class=\"text-middle\">Accordions</span></a></li>
                                    <li><a href=\"alerts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-alert-outline\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"animations.html\"><span class=\"novi-icon rd-navbar-icon fa fa-magic\"></span><span class=\"text-middle\">Animations</span></a></li>
                                    <li><a href=\"breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drag-horizontal\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"buttons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-shuffle\"></span><span class=\"text-middle\">Buttons</span></a></li>
                                    <li><a href=\"call-to-actions.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-triangle\"></span><span class=\"text-middle\">Call to actions</span></a></li>
                                    <li><a href=\"lists-of-comments.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-multiple-outline\"></span><span class=\"text-middle\">Lists of comments</span></a></li>
                                    <li><a href=\"content-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-outline\"></span><span class=\"text-middle\">Content boxes</span></a></li>
                                    <li><a href=\"offer-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-checkbox-multiple-blank-outline\"></span><span class=\"text-middle\">Offer boxes</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"counters.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timelapse\"></span><span class=\"text-middle\">Counters</span></a></li>
                                    <li><a href=\"dividers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-division\"></span><span class=\"text-middle\">Dividers</span></a></li>
                                    <li><a href=\"footer-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-bottom\"></span><span class=\"text-middle\">Footer widgets</span></a></li>
                                    <li><a href=\"form-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-keyboard-variant\"></span><span class=\"text-middle\">Form elements</span></a></li>
                                    <li><a href=\"grid-system.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-week\"></span><span class=\"text-middle\">Grid system</span></a></li>
                                    <li><a href=\"product-grids.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-view-module\"></span><span class=\"text-middle\">Product Grids</span></a></li>
                                    <li><a href=\"icon-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-emoticon\"></span><span class=\"text-middle\">Icon boxes</span></a></li>
                                    <li><a href=\"icons.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-drawing\"></span><span class=\"text-middle\">Icons</span></a></li>
                                    <li><a href=\"infographics.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-trending-up\"></span><span class=\"text-middle\">Infographics</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"labels.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-label-outline\"></span><span class=\"text-middle\">Labels</span></a></li>
                                    <li><a href=\"lists.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-list-numbers\"></span><span class=\"text-middle\">Lists</span></a></li>
                                    <li><a href=\"maps.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-map-marker-circle\"></span><span class=\"text-middle\">Maps</span></a></li>
                                    <li><a href=\"media-elements.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-youtube-play\"></span><span class=\"text-middle\">Media elements</span></a></li>
                                    <li><a href=\"member-boxes.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-account-circle\"></span><span class=\"text-middle\">Member boxes</span></a></li>
                                    <li><a href=\"navigation.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-cube-unfolded\"></span><span class=\"text-middle\">Navigation</span></a></li>
                                    <li><a href=\"pagination.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-numeric-1-box-outline\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"posts.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-clipboard-outline\"></span><span class=\"text-middle\">Posts</span></a></li>
                                    <li><a href=\"pricing-and-plans.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-coin\"></span><span class=\"text-middle\">Pricing and plans</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"sections.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-vector-difference-ba\"></span><span class=\"text-middle\">Sections</span></a></li>
                                    <li><a href=\"sidebar-widgets.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-border-left\"></span><span class=\"text-middle\">Sidebar widgets</span></a></li>
                                    <li><a href=\"tables.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-table\"></span><span class=\"text-middle\">Tables</span></a></li>
                                    <li><a href=\"tabs.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-line-spacing\"></span><span class=\"text-middle\">Tabs</span></a></li>
                                    <li><a href=\"testimonials.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-comment-text-outline\"></span><span class=\"text-middle\">Testimonials</span></a></li>
                                    <li><a href=\"text-rotator.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-textdirection-l-to-r\"></span><span class=\"text-middle\">Text rotator</span></a></li>
                                    <li><a href=\"thumbnails.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-credit-card-scan\"></span><span class=\"text-middle\">Thumbnails</span></a></li>
                                    <li><a href=\"timers.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-timer\"></span><span class=\"text-middle\">Timers</span></a></li>
                                    <li><a href=\"typography.html\"><span class=\"novi-icon rd-navbar-icon mdi mdi-format-text\"></span><span class=\"text-middle\">Typography</span></a></li>
                                  </ul>
                                </div>
                                <div class=\"row\">
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-alerts.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Alerts</span></a></li>
                                    <li><a href=\"bootstrap-badges.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Badges</span></a></li>
                                    <li><a href=\"bootstrap-breadcrumbs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Breadcrumbs</span></a></li>
                                    <li><a href=\"bootstrap-button-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Groups</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-button-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Button Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-dropdowns.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Dropdowns</span></a></li>
                                    <li><a href=\"bootstrap-input-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Input Groups</span></a></li>
                                    <li><a href=\"bootstrap-jumbotron.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Jumbotron</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-list-groups.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">List Groups</span></a></li>
                                    <li><a href=\"bootstrap-media-objects.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Media Objects</span></a></li>
                                    <li><a href=\"bootstrap-navbar.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navbar</span></a></li>
                                    <li><a href=\"bootstrap-navs.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Navs</span></a></li>
                                  </ul>
                                  <ul class=\"col-xl-3\">
                                    <li><a href=\"bootstrap-page-header.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Page Header</span></a></li>
                                    <li><a href=\"bootstrap-pagination.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Pagination</span></a></li>
                                    <li><a href=\"bootstrap-progress-bars.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Progress Bars</span></a></li>
                                    <li><a href=\"bootstrap-responsive-embed.html\"><span class=\"novi-icon rd-navbar-icon\"></span><span class=\"text-middle\">Responsive embed</span></a></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!--RD Navbar Search-->
                  <div class=\"rd-navbar-search\"><a class=\"rd-navbar-search-toggle mdi\" data-rd-navbar-toggle=\".rd-navbar-inner,.rd-navbar-search\" href=\"#\"><span></span></a>
                    <form class=\"rd-navbar-search-form search-form-icon-right rd-search\" action=\"search-results.html\" method=\"GET\">
                      <div class=\"form-group\">
                        <label class=\"form-label\" for=\"rd-navbar-search-form-control\">Type and hit enter...</label>
                        <input class=\"rd-navbar-search-form-control form-control form-control-gray-lightest\" id=\"rd-navbar-search-form-control\" type=\"text\" name=\"s\" autocomplete=\"off\"/>
                      </div>
                    </form>
                  </div>
                  <!--RD Navbar shop-->
                  <div class=\"rd-navbar-cart-wrap\">
                  <a class=\"rd-navbar-cart mdi icon-user \"  href=\"#\" ><span></span><br> <p class=\"p-text\">Usuario</p></a>
                  <a class=\"rd-navbar-cart mdi icon-notification\" href=\"#\" ><span></span> <br> <p class=\"p-text\">Atender</p></a>
                  <a class=\"rd-navbar-cart mdi icon-ventas\"  href=\"#\" ><span></span><br> <p class=\"p-text\">Servicio</p></a>
                  <a class=\"rd-navbar-cart mdi icon-carrito \"  data-rd-navbar-toggle=\".rd-navbar-cart-dropdown\" href=\"#\" ><span></span><br> <p class=\"p-text\">Factura</p></a>
                  <a class=\"rd-navbar-cart mdi icon-texto\"  href=\"#\" ><span class=\"span-text\" style=\"width: 115px;\" >\$ 00.00</span><br> <p style=\"margin-top: -3px;\" class=\"p-text\">Valor Total</p></a>
                 
                    <div class=\"rd-navbar-cart-dropdown\">
                      <ul class=\"rd-navbar-list-products\">
                        <li>
                          <div class=\"rd-navbar-product-image\"><img src=\"images/shop/product-01-60x60.png\" alt=\"\"/></div>
                          <div class=\"rd-navbar-product-caption\">
                            <h6 class=\"rd-navbar-product-title\"><a href=\"shop-single-product-left-sidebar.html\">Fashion model new</a></h6>
                            <p class=\"rd-navbar-product-price\">\$129.99</p>
                          </div><a class=\"mdi mdi-window-close rd-navbar-product-remove\" href=\"#\"></a>
                        </li>
                        <li>
                          <div class=\"rd-navbar-product-image\"><img src=\"images/shop/product-01-60x60-3.png\" alt=\"\"/></div>
                          <div class=\"rd-navbar-product-caption\">
                            <h6 class=\"rd-navbar-product-title\"><a href=\"shop-single-product-left-sidebar.html\">Fashion model new 2</a></h6>
                            <p class=\"rd-navbar-product-price\">\$69.99</p>
                          </div><a class=\"mdi mdi-window-close rd-navbar-product-remove\" href=\"#\"></a>
                        </li>
                      </ul>
                      <div class=\"rd-navbar-cart-total\">
                        <h6 class=\"rd-navbar-cart-total-title\">Cart subtotal</h6><span class=\"rd-navbar-cart-total-price\">\$199.98</span>
                      </div>
                      <div class=\"text-center\"><a class=\"btn btn-rect btn-sm btn-primary btn-icon btn-icon-left\" href=\"shop-cart.html\"><span class=\"icon novi-icon mdi mdi-lock\"></span>Go to checkout</a></div>
                    </div>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </header>

        <div class=\"container section-34 section-sm-34\">
          <div class=\"row align-items-xl-center\">
            <div class=\"col-xl-5 d-none d-xl-block text-xl-left\">     
            </div>
            <div class=\"col-xl-2 d-none d-md-block\">       
            </div>
            <div class=\"offset-top-0 offset-md-top-10 col-xl-5 offset-xl-top-0 small text-xl-right\">
              <ul class=\"list-inline list-inline-dashed p\">
                <li class=\"list-inline-item\"><a href=\"index.html\">Home</a></li>
                <li class=\"list-inline-item\"><a href=\"#\">Pages</a></li>
                <li class=\"list-inline-item\">Services
                </li>
              </ul>
            </div>
          </div>
        </div>
      
    ", "layout/header.html", "/var/www/html/horizontes/templates/layout/header.html");
    }
}