<?php get_header(); ?>

    <section class="section intro" style="padding:0;">

        <div class="wrap">

            <div class="intro_text">
            
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Menu Text") ) : ?>

                <?php endif;?>
                
                Visit my <a title="Webdevelopment and Design Portfolio of Sjoerd Koelewijn" href="https://sjoerdkoelewijn.com">portfolio</a>.
            
            </div>

        </div>

    </section>

<?php get_footer(); ?>