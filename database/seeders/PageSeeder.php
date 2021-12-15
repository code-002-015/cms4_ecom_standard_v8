<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $homeHTML = '
            <div class="section mb-0 pt-3 pb-0" style="background-color: #F4F4F4; margin-top: 150px; overflow: visible;">
                    <div class="shape-divider" data-shape="wave" data-height="150" data-outside="true" data-flip-vertical="true" data-fill="#F4F4F4"></div>
                    <div class="container">
                        <div class="row justify-content-center text-center mt-5">
                            <div class="col-lg-6">
                                <div>
                                    <h3 class="fw-bolder h1 mb-4">Graphics Designer & Frontend Developer, Based in <span class="gradient-text gradient-horizon">Germany</span></h3>
                                    <p class="mb-5 lead text-black-50 fw-extralight">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum, atque. Minus, harum porro unde quisquam! Minima vitae neque hic vel porro quidem totam.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center position-relative">
                        <div class="parallax min-vh-75" style="background-image: url("'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/me.jpg"); background-size: cover; background-position: center center;" data-bottom-top="width: 40vw" data-center-top="width: 100vw;">
                            <div class="row align-items-center justify-content-center h-100">
                                <div class="col-auto text-center">
                                    <a href="#" class="display-4 fw-bolder text-white d-inline-block mx-4 h-op-08 op-ts"><u>#dribbble</u></a>
                                    <a href="#" class="display-4 fw-bolder text-white d-inline-block mx-4 h-op-08 op-ts"><u>#behance</u></a>
                                </div>
                            </div>
                        </div>
                        <div class="shape-divider" data-shape="wave" data-position="bottom"></div>
                    </div>
                </div>

                <div class="container" style="max-width: 1000px">
                    <div class="row col-mb-30 mt-5">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="counter counter-xlarge text-dark fw-bolder"><span data-from="1" data-to="15" data-refresh-interval="2" data-speed="600"></span></div>
                                <span>+ Years Of<br>Experience.</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="counter counter-xlarge text-dark fw-bolder"><span data-from="4" data-to="83" data-refresh-interval="50" data-speed="1500"></span></div>
                                <span>% of Works <br>Completed.</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="counter counter-xlarge text-dark fw-bolder"><span data-from="5" data-to="100" data-refresh-interval="30" data-speed="1200"></span></div>
                                <span>% Satisfied<br>Customers.</span>
                            </div>
                        </div>
                    </div>
                    <div class="line line-sm mb-0"></div>
                </div>

                <div class="section bg-transparent py-5">
                    <div class="container">
                        <div class="row align-items-center justify-content-around">
                            <div class="col-lg-4">
                                <h3 class="fw-bolder h1 mb-4">What Some of my Clients Say</h3>

                                <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget mt-5" data-margin="0" data-items="1" data-pagi="true" data-nav="false">

                                    <div class="oc-item">
                                        <div class="testimonial border-0 shadow-none bg-transparent">
                                            <div class="testi-content">
                                                <p>Quickly redefine resource sucking web services after exceptional customer service. Professionally coordinate focused platforms before visionary architectures.</p>
                                                <div class="testi-meta d-flex align-items-center">
                                                    <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/testi/face.jpg" alt="Face" width="30">
                                                    <div>
                                                        John Doe
                                                        <span class="ps-0">XYZ Inc.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="oc-item">
                                        <div class="testimonial border-0 shadow-none bg-transparent">
                                            <div class="testi-content">
                                                <p>Dramatically mesh user friendly solutions whereas sticky human capital. Assertively fashion impactful "outside the box".</p>
                                                <div class="testi-meta d-flex align-items-center">
                                                    <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/testi/face2.jpg" alt="Face" width="30">
                                                    <div>
                                                        John Doe
                                                        <span class="ps-0">XYZ Inc.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="oc-item">
                                        <div class="testimonial border-0 shadow-none bg-transparent">
                                            <div class="testi-content">
                                                <p>Progressively productivate customer directed meta-services without magnetic bandwidth.</p>
                                                <div class="testi-meta d-flex align-items-center">
                                                    <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/testi/face3.jpg" alt="Face" width="30">
                                                    <div>
                                                        John Doe
                                                        <span class="ps-0">XYZ Inc.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/testi/bg.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="section m-0">
                    <div class="container">
                        <div class="row align-items-end justify-content-between mb-5">
                            <div class="col-lg-5 offset-lg-1">
                                <div>
                                    <h3 class="fw-bolder h1 mb-4">Latest Creative Works,<br>and Selected Projects</h3>
                                    <p class="lead mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="demo-freelancer-works.html" class="button button-dark button-border rounded-pill">View All Works <i class="icon-line-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="row justify-content-center col-mb-50">
                            <div class="col-lg-6 h-translatey-3 tf-ts">
                                <a href="demo-store.html" class="portfolio-item" target="_blank">
                                    <div class="portfolio-image">
                                        <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/works/1.jpg" alt="Portfoio Item">
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content align-items-start justify-content-start flex-column px-5 py-4">
                                                <h3 class="mb-0 mt-1">Niche Demo Store</h3>
                                                <h5>Media, Icons</h5>
                                            </div>
                                            <div class="bg-overlay-content align-items-start justify-content-end p-4">
                                                <div class="overlay-trigger-icon bg-dark text-white" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350"><i class="icon-line-link"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6 h-translatey-3 tf-ts">
                                <a href="demo-yoga.html" class="portfolio-item" target="_blank">
                                    <div class="portfolio-image">
                                        <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/works/2.jpg" alt="Portfoio Item">
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content align-items-start justify-content-start flex-column px-5 py-4">
                                                <h3 class="mb-0 mt-1">Niche Demo Yoga</h3>
                                                <h5>Media, Icons</h5>
                                            </div>
                                            <div class="bg-overlay-content align-items-start justify-content-end p-4">
                                                <div class="overlay-trigger-icon bg-dark text-white" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350"><i class="icon-line-link"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6 h-translatey-3 tf-ts">
                                <a href="demo-hostel.html" class="portfolio-item" target="_blank">
                                    <div class="portfolio-image">
                                        <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/works/3.jpg" alt="Portfoio Item">
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content align-items-start justify-content-start flex-column px-5 py-4">
                                                <h3 class="mb-0 mt-1">Niche Demo Hostel</h3>
                                                <h5>Media, Icons</h5>
                                            </div>
                                            <div class="bg-overlay-content align-items-start justify-content-end p-4">
                                                <div class="overlay-trigger-icon bg-dark text-white" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350"><i class="icon-line-link"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6 h-translatey-3 tf-ts">
                                <a href="demo-conference.html" class="portfolio-item" target="_blank">
                                    <div class="portfolio-image">
                                        <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/works/4.jpg" alt="Portfoio Item">
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content align-items-start justify-content-start flex-column px-5 py-4">
                                                <h3 class="mb-0 mt-1">Niche Demo Conference</h3>
                                                <h5>Media, Icons</h5>
                                            </div>
                                            <div class="bg-overlay-content align-items-start justify-content-end p-4">
                                                <div class="overlay-trigger-icon bg-dark text-white" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350"><i class="icon-line-link"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="clear"></div>

                <div class="section bg-transparent py-5">

                    <div class="container">
                        <div class="row align-items-end mb-5">
                            <div class="col-lg-5 offset-lg-1">
                                <h3 class="fw-bolder h1">The ways I can help you</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam minima error ducimus recusandae sed ipsam, cumque optio reiciendis nihil labore!</p>
                            </div>
                        </div>

                        <div  class="row gutter-50 mb-5 align-items-stretch">
                            <div class="col-md-4">
                                <div class="card d-flex align-items-end flex-column p-4 border-0" style="background-color: #E2E8D8;">
                                    <div class="mt-5"></div>
                                    <div class="mt-auto">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/icons/sketch.svg" height="50" alt="Image">
                                                <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/icons/xd.png" height="50" alt="Image" class="ms-3">
                                            </div>
                                            <h3 class="card-title fw-bolder">Website Design</h3>
                                            <p class="card-text mb-0 mt-2 fw-light">Objectively productivate interoperable process improvements after team building testing procedures. Distinctively architect resource-leveling portals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card d-flex align-items-end flex-column p-4 border-0" style="background-color: #C2DFEC;">
                                    <div class="mt-5"></div>
                                    <div class="mt-auto">
                                        <div class="card-body">
                                            <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/icons/social.svg" alt="Image" class="mb-4" height="50">
                                            <h3 class="card-title fw-bolder">Responsive Website</h3>
                                            <p class="card-text mb-0 mt-2 fw-light">Objectively productivate interoperable process improvements after team building testing procedures. Distinctively architect resource-leveling portals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card d-flex align-items-end flex-column p-4 border-0" style="background-color: #FADCE4">
                                    <div class="mt-5"></div>
                                    <div class="mt-auto">
                                        <div class="card-body">
                                            <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/icons/wp.png" height="50" alt="Image" class="mb-4">
                                            <h3 class="card-title fw-bolder">WordPress Website</h3>
                                            <p class="card-text mb-0 mt-2 fw-light">Objectively productivate interoperable process improvements after team building testing procedures. Distinctively architect resource-leveling portals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card d-flex align-items-end flex-column p-4 border-0" style="background-color: #E4E4E4">
                                    <div class="mt-5"></div>
                                    <div class="mt-auto">
                                        <div class="card-body">
                                            <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/icons/seo.svg" height="50" alt="Image" class="mb-4">
                                            <h3 class="card-title fw-bolder">SEO Optimised</h3>
                                            <p class="card-text mb-0 mt-2 fw-light">Objectively productivate interoperable process improvements after team building testing procedures. Distinctively architect resource-leveling portals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card d-flex align-items-end flex-column p-4 border-0" style="background-color: #E5E3CE;">
                                    <div class="mt-5"></div>
                                    <div class="mt-auto">
                                        <div class="card-body">
                                            <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/icons/hosting.svg" height="50" alt="Image" class="mb-4">
                                            <h3 class="card-title fw-bolder">Web Hosting</h3>
                                            <p class="card-text mb-0 mt-2 fw-light">Objectively productivate interoperable process improvements after team building testing procedures. Distinctively architect resource-leveling portals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card d-flex align-items-end flex-column p-4 border-0" style="background-color: #C9D6CF">
                                    <div class="mt-5"></div>
                                    <div class="mt-auto">
                                        <div class="card-body">
                                            <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/icons/plugins.png" height="50" alt="Image" class="mb-4">
                                            <h3 class="card-title fw-bolder">Plugin Development</h3>
                                            <p class="card-text mb-0 mt-2 fw-light">Objectively productivate interoperable process improvements after team building testing procedures. Distinctively architect resource-leveling portals.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <div class="container mt-6">
                        <div class="row align-items-end">
                            <div class="col-lg-6 offset-lg-1">
                                <h3 class="fw-bolder h1">We value our relationships</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam minima error ducimus recusandae sed ipsam, cumque optio reiciendis nihil labore!</p>
                            </div>
                        </div>
                        <div class="section rounded-10 p-6 my-4" style="background-color: #F1F1F1;">
                            <div class="row justify-content-between align-items-center col-mb-50">
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/amazon.svg" alt="Clients"></div>
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/netflix.svg" alt="Clients"></div>
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/google.svg" alt="Clients"></div>
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/paypal.svg" alt="Clients"></div>
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/skype.svg" alt="Clients"></div>
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/ps.svg" alt="Clients"></div>
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/slack.svg" alt="Clients"></div>
                                <div class="col-md-3 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/applemusic.svg" alt="Clients"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section m-0" style="background: #f1efe5 url("'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/bg.svg") no-repeat right center; padding-top: 240px">
                    <div class="shape-divider" data-shape="wave-4" data-height="150" id="shape-divider-6017"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 140" preserveAspectRatio="none"><path class="shape-divider-fill" fill="#F8F7F2" d="M0 51.76c36.21-2.25 77.57-3.58 126.42-3.58 320 0 320 57 640 57 271.15 0 312.58-40.91 513.58-53.4V0H0z" opacity="0.3"></path><path class="shape-divider-fill" d="M0 24.31c43.46-5.69 94.56-9.25 158.42-9.25 320 0 320 89.24 640 89.24 256.13 0 307.28-57.16 481.58-80V0H0z" opacity="0.5"></path><path class="shape-divider-fill" d="M0 0v3.4C28.2 1.6 59.4.59 94.42.59c320 0 320 84.3 640 84.3 285 0 316.17-66.85 545.58-81.49V0z"></path></svg></div>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <h3 class="fw-bolder h1 my-5">A few things clients<br>normally ask me</h3>
                                <div class="accordion" data-collapsible="true">

                                    <div class="accordion-header">
                                        <div class="accordion-icon">
                                            <i class="accordion-closed icon-line-plus color gradient-text gradient-red-yellow"></i>
                                            <i class="accordion-open icon-line-minus color gradient-text gradient-red-yellow"></i>
                                        </div>
                                        <div class="accordion-title">
                                            Design &amp; Development Process
                                        </div>
                                    </div>
                                    <div class="accordion-content">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

                                    <div class="accordion-header">
                                        <div class="accordion-icon">
                                            <i class="accordion-closed icon-line-plus color gradient-text gradient-red-yellow"></i>
                                            <i class="accordion-open icon-line-minus color gradient-text gradient-red-yellow"></i>
                                        </div>
                                        <div class="accordion-title">
                                            What is Our Refund Policy
                                        </div>
                                    </div>
                                    <div class="accordion-content">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>

                                    <div class="accordion-header" id="id-accordion-3">
                                        <div class="accordion-icon">
                                            <i class="accordion-closed icon-line-plus color gradient-text gradient-red-yellow"></i>
                                            <i class="accordion-open icon-line-minus color gradient-text gradient-red-yellow"></i>
                                        </div>
                                        <div class="accordion-title">
                                            Our Processing Time
                                        </div>
                                    </div>
                                    <div class="accordion-content">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>

                                    <div class="accordion-header" id="id-accordion-4">
                                        <div class="accordion-icon">
                                            <i class="accordion-closed icon-line-plus color gradient-text gradient-red-yellow"></i>
                                            <i class="accordion-open icon-line-minus color gradient-text gradient-red-yellow"></i>
                                        </div>
                                        <div class="accordion-title">
                                            How do I Pay and Payment Method
                                        </div>
                                    </div>
                                    <div class="accordion-content">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>

                                </div>
                            </div>

                            <div class="col-lg-7">
                                <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/ask.svg" alt="FAQs" class="px-5">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>';


        $aboutHTML = '
            <div class="mw-md container mb-5">
                <h2 class="display-4 fw-light" style="line-height: 1.5;">I am a Freelancer, <span class="gradient-text gradient-horizon">Graphics Designer</span> & <span class="gradient-text gradient-horizon">Frontend Developer</span>, Based in <span class="gradient-text gradient-horizon">Germany</span>. Successful Designer with more than <span class="gradient-text gradient-horizon">10 years</span> of professional experience &amp; with lots of <span class="gradient-text gradient-horizon">Satisfied</span> Customers.</h2>
            </div>

            <div class="clear"></div>

            <div class="section mb-0 p-0" style="background-color: #F4F4F4; overflow: visible;">
                <div class="d-flex justify-content-center position-relative">
                    <div class="parallax min-vh-75" style="background-image: url("'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/me.jpg"); background-size: cover; background-position: center center;" data-bottom-top="width: 40vw" data-center-top="width: 100vw;">
                        <div class="row align-items-center justify-content-center h-100">
                            <div class="col-auto text-center">
                                <a href="#" class="display-4 fw-bolder text-white d-inline-block mx-4 h-op-08 op-ts"><u>#dribbble</u></a>
                                <a href="#" class="display-4 fw-bolder text-white d-inline-block mx-4 h-op-08 op-ts"><u>#behance</u></a>
                            </div>
                        </div>
                    </div>
                    <div class="shape-divider" data-shape="wave" data-position="bottom"></div>
                </div>
            </div>

            <div class="container mb-5">
                <div class="row col-mb-30 mt-5">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="counter counter-xlarge text-dark fw-bolder"><span data-from="1" data-to="15" data-refresh-interval="2" data-speed="600"></span></div>
                            <span>+ Years Of<br>Experience.</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="counter counter-xlarge text-dark fw-bolder"><span data-from="4" data-to="83" data-refresh-interval="50" data-speed="1500"></span></div>
                            <span>% of Works <br>Completed.</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="counter counter-xlarge text-dark fw-bolder"><span data-from="5" data-to="100" data-refresh-interval="30" data-speed="1200"></span></div>
                            <span>% Satisfied<br>Customers.</span>
                        </div>
                    </div>
                </div>
                <div class="line line-sm mb-0"></div>
            </div>

            <div class="clear"></div>

            <div class="container mw-md mt-5">
                <h2 class="display-3 fw-bolder text-uppercase">What we Do <span class="gradient-text gradient-horizon">&amp;</span><br> How we Do</h2>
                <div class="row mt-4">
                    <div class="col-md-8 offset-1">
                        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque tempora porro hic provident accusamus nam molestias id architecto, temporibus consectetur dolor repellat doloremque dignissimos eum asperiores amet officiis reiciendis libero.</p>
                        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque tempora porro hic provident accusamus nam molestias id architecto, temporibus consectetur dolor repellat doloremque dignissimos eum asperiores amet officiis reiciendis libero.</p>
                    </div>
                </div>

                <div class="row align-wide-xxl my-5 text-center">
                    <div class="col-sm-6">
                        <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/about/1.jpg" alt="Image" class="img-fluid">
                    </div>
                    <div class="col-sm-6">
                        <img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/about/2.jpg" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="section text-center mb-0">
                <div class="mw-xs mx-auto ">
                    <h3 class="display-4 fw-bolder text-uppercase">We Do It for <span class="gradient-text gradient-horizon">Them</span></h3>
                    <p class="mt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam necessitatibus quaerat, rem delectus</p>

                    <div class="clear"></div>

                    <div class="row justify-content-center align-items-center mt-4 col-mb-30">
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/amazon.svg" alt="Clients"></div>
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/netflix.svg" alt="Clients"></div>
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/google.svg" alt="Clients"></div>
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/paypal.svg" alt="Clients"></div>
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/skype.svg" alt="Clients"></div>
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/ps.svg" alt="Clients"></div>
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/slack.svg" alt="Clients"></div>
                        <div class="col-md-4 col-6 center"><img src="'.\URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/clients/applemusic.svg" alt="Clients"></div>
                    </div>
                </div>
            </div>';


        $contactUsHTML = '';

        $footerHTML = '
            <div class="container">
                <div class="footer-widgets-wrap  m-0">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="widget">

                                <h3 class="h1 mb-5">Got a Project?<br>Lets Talk!</h3>
                                <span class="text-black-50">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quisquam aspernatur vero voluptas.</span>
                                <a href="mailto:noreply@canvas.com" class="h4 text-dark mt-5 mb-4 d-block"><u>noreply@canvas.com</u> <i class="icon-line-arrow-right position-relative ms-2" style="top: 3px"></i></a>
                                <div>
                                    <a href="http://facebook.com/semicolonweb" class="social-icon si-small si-colored si-facebook" target="_blank">
                                        <i class="icon-facebook"></i>
                                        <i class="icon-facebook"></i>
                                    </a>
                                    <a href="http://instagram.com/semicolonweb" class="social-icon si-small si-colored si-instagram" target="_blank">
                                        <i class="icon-instagram"></i>
                                        <i class="icon-instagram"></i>
                                    </a>
                                    <a href="http://youtube.com/semicolonweb" class="social-icon si-small si-colored si-youtube" target="_blank">
                                        <i class="icon-youtube"></i>
                                        <i class="icon-youtube"></i>
                                    </a>
                                    <a href="#" class="social-icon si-small si-colored si-flattr">
                                        <i class="icon-flattr"></i>
                                        <i class="icon-flattr"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

      
        $pages = [
            [
                'parent_page_id' => 0,
                'album_id' => 1,
                'slug' => 'home',
                'name' => 'Home',
                'label' => 'Home',
                'contents' => $homeHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'default',
                'image_url' => '',
                'meta_title' => 'Home',
                'meta_keyword' => 'home',
                'meta_description' => 'Home page',
                'user_id' => 1,
                'template' => 'home',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'about-us',
                'name' => 'About Us',
                'label' => 'About Us',
                'contents' => $aboutHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/subbanner.jpg',
                'meta_title' => 'About Us',
                'meta_keyword' => 'About Us',
                'meta_description' => 'About Us page',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'contact-us',
                'name' => 'Contact Us',
                'label' => 'Contact Us',
                'contents' => $contactUsHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => '',
                'meta_title' => 'Contact Us',
                'meta_keyword' => 'Contact Us',
                'meta_description' => 'Contact Us page',
                'user_id' => 1,
                'template' => 'contact-us',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'news',
                'name' => 'News and Updates',
                'label' => 'News and Updates',
                'contents' => '',
                'status' => 'PUBLISHED',
                'page_type' => 'customize',
                'image_url' => '',
                'meta_title' => 'News',
                'meta_keyword' => 'news',
                'meta_description' => 'News page',
                'user_id' => 1,
                'template' => 'news',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'footer',
                'name' => 'Footer',
                'label' => 'footer',
                'contents' => $footerHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'default',
                'image_url' => '',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('pages')->insert($pages);
    }
}
