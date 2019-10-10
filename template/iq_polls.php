
<?php get_header(); ?>
    <section class="title">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h1><?php echo __('Tests and polls','iq_polls'); ?></h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Главная</a> <span class="divider">/</span></li>
                        <li class="active">Тесты и опросы</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->         

    <section class="container main">
        <div class="row-fluid">
            <div class="span8">
                <div class="blog" style="font-size: 16px;">
                    <?php if (have_posts()): while (have_posts()): the_post(); ?>
                        <div class="blog-item well" >
                            <a href="<?php the_permalink();?>"><h2><?php the_title(); ?></h2></a>
                            <div class="blog-meta clearfix" style="font-size: 16px;">
                                <p class="pull-left">
                                   <?php echo get_the_term_list(get_the_ID(),'subject','Темы тестов:'); ?> 
                                </p>
                              
                            </div>
                            <p><?php the_post_thumbnail(array(200,200)); ?></p>
                            <p><?php the_excerpt(); ?></p>
                            <a class="btn btn-link" href="<?php the_permalink();?>">Подробнее <i class="icon-angle-right"></i></a>

                        </div>                 
                    <?php endwhile; endif; ?>                      
                    <div class="gap">
                        
                    </div>

                    <div class="pagination">
                        
                        <?php echo paginate_links( array(
                            'type' =>'list' , 
                            'prev_text'    => '<i class="icon-angle-left"></i>',
                            'next_text'    => '<i class="icon-angle-right"></i>'
                        ) ); ?>
                    </div>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </section>



<?php get_footer(); ?>