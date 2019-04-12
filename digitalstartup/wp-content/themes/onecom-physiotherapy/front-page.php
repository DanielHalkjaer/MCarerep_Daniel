<?php

get_header();

//START banner container 
get_template_part('template-parts/home/home', 'banner');
// END banner container

// Therapies section
get_template_part('template-parts/home/section', 'services');

//Benefits section
get_template_part('template-parts/home/section', 'facilities');
get_template_part('template-parts/home/section', 'about-us');
get_template_part('template-parts/home/section', 'pricing_plans');
get_template_part('template-parts/home/section', 'gallery');
get_footer();
