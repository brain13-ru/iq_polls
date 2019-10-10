
<?php get_header(); ?>
    <section class="title">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h1><?php echo $post->post_title; ?></h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Главная</a> <span class="divider">/</span></li>
                        <li class="active"><?php echo $post->post_title; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->         

    <?php 
        
        global $wpdb;
        $cur_poll= get_the_ID();

        $cur_page=0;
        $total_page=0;
        if(isset($_GET['quest'])){
            $cur_page=$_GET['quest'];
        }
        
        if(isset($cur_poll)){   //if($cur_page<$total_page){
                $table_name=$wpdb->get_blog_prefix().'iqp_questions';
                $questions=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id=".$cur_poll." ORDER BY number");
                $total_page=count($questions);
                if(!isset($_GET['mode'])||($_GET['mode']!=="archive")){ //Обычный режим вывода теста
                    if($cur_page<$total_page){
                        $question=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$questions[$cur_page]->id,ARRAY_A);
                        $table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
                        $answer_vars=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE quest_id=".$question['id']);
                    }
                    else {
                        $table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
                        $answers_vars=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id=".$cur_poll);
                    }
                }
                else{
                    $table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
                    $answers_vars=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id=".$cur_poll);
                    $user_id=$_GET['user_id'];
                    $table_name=$wpdb->get_blog_prefix().'iqp_answers';
                    $answers=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id=".$cur_poll." AND user_id=".$user_id);
                }
                $path=ABSPATH;
       
        }

        
    ?>

    <section id="about-us" class="container main">
        <div class="row-fluid">
            <div class="span8">
                <div class="blog" style="font-size: 16px;">
                    <?php if($cur_page==0): ?>
                        <?php if (have_posts()): while (have_posts()): the_post(); ?>
                        <div class="blog-item well">
                            <a href="<?php the_permalink();?>"><h2><?php the_title(); ?></h2></a>
                            <div class="blog-meta clearfix">
                                <p class="pull-left">
                                  Категория: <a href="#"><?php echo get_the_term_list(get_the_ID(),'subject'); ?></a>
                              </p>                         
                            </div>
                            <?php if(!isset($_GET['mode'])||($_GET['mode']!=="archive")): //Обычный режим вывода теста ?>
                                <p><?php the_post_thumbnail(array(200,200)); ?></p>
                                <p><?php the_content(); ?></p>
                            <?php  endif; ?>
                        </div>
                        <?php endwhile; endif; ?>   
                    <?php endif; ?>
                    <?php 

                    if(!isset($_GET['mode'])||($_GET['mode']!=="archive")){ //Обычный режим вывода теста
                        if($cur_page<$total_page){
                           
                            
                            echo "<div>";
                                echo "<h4>Вопрос № ".($cur_page+1)."</h4>";
                               
                                echo "<h4>".$questions[$cur_page]->text."</h4>";
                                if(!empty($questions[$cur_page]->picture)){
                                    $picture_url=plugins_url()."/iq_polls/uploads/".$questions[$cur_page]->picture;
                                    echo "<img src='".$picture_url."' width='400px'/>";
                                }

                                echo "<div style='border: solid 1px grey; padding: 15px;'>";
                                echo "<h4>Варианты ответа:</h4>";
                               
                                    echo "<form action='".plugins_url()."/iq_polls/add-answer.php' method='POST'>";
                                    echo "<input type='hidden' name='quest' value='".$cur_page."'/>";
                                    echo "<input type='hidden' name='quest_id' value='".$question['id']."'/>";
                                    echo "<input type='hidden' name='iq_polls' value='".get_post_field( 'post_name', get_post($cur_poll))."'/>";
                                    echo "<div class ='form-group'>";
                                        foreach($answer_vars as $answer_var){
                                            echo "<input type='radio' name='answer_var' value='".$answer_var->id."'>&nbsp;".$answer_var->text."</input><br/>";
                                        }    
                                        echo "<input type='radio' name='answer_var' value='0' checked>&nbsp;Не знаю</input><br/>";
                                        echo "</div><br/>";
                                    echo "<div class ='form-group'>
                                        <button type='submit'>Ответить</button>
                                    </div>
                                    <input type='hidden' name='wp_load_path' value='".$path."/wp-load.php' />";
                                    echo "</form>";    
                                echo "</div>";
                            echo "</div>";
                        } 
                        else {
                            echo "<h2>Результаты теста</h2><ul>";
                            $total=0;
                            foreach($_SESSION['answers'] as $key=>$value){
                            
                                if(is_numeric($key)){
                                    $bonus=0;
                                    if(isset($_SESSION['bonus'][$key])){
                                        $bonus=$_SESSION['bonus'][$key];
                                    }

                                    $answ_text="Не знаю";
                                    $cur_answ=0;
                                    if($value>0){
                                        foreach($answers_vars as $an_var){
                                            if($an_var->quest_id!==$questions[$key]->id){
                                                continue;
                                            }
                                            if(($cur_answ+1)<$value){
                                                $cur_answ++;
                                                continue;                                        }
                                            $answ_text=$an_var->text;
                                            break;

                                        }
                                    }

                                    echo "<li> <b>Вопрос №".($key+1).":</b> '".$questions[$key]->text."'<br/>";
                                    echo " <b>Ваш ответ</b> - ".$value.": '".$answ_text."'<br/>";
                                    echo " Количество баллов: ".$bonus."</li>";
                                    $total+=$_SESSION['bonus'][$key];
                                }
                                
                            }
                            echo "</ul>";
                            echo "Итого набранных баллов: ".$total;
                            echo "<form action='".plugins_url()."/iq_polls/save-answers.php' method='POST'>";
                            echo "<input type='hidden' name='path_back' value='".get_permalink()."&quest=".$total_page."'/>";
                            echo "<input type='hidden' name='total' value='".$total."'/>";
                            echo "<input type='hidden' name='poll_id' value='".$cur_poll."'/>";
                            echo "<div class ='form-group'>

                                    <button type='submit'>Сохранить результат</button>
                                </div>
                                <input type='hidden' name='wp_load_path' value='".$path."/wp-load.php' />";
                            echo "</form>";
                        }
                    } else { // режим выдачи архивных результатов по пользователю
                        echo "<h2>Результаты теста</h2><ul>";
                        $total=0;
                        $key=0;
                        foreach($answers as $answ){
                        
                           
                            $bonus=0;
                            if(isset($answ->bonus)){
                                $bonus=$answ->bonus;
                            }

                            $answ_text="Не знаю";
                            $cur_answ=0;
                           
                            foreach($answers_vars as $an_var){
                                if($an_var->id!==$answ->answer_var_id){
                                    continue;
                                }
                                                        
                                $answ_text=$an_var->text;
                                break;

                            }
                           
                            echo "<li> <b>Вопрос №".($key+1).":</b> '".$questions[$key]->text."'<br/>";
                            echo " <b>Ваш ответ</b> - '".$answ_text."'<br/>";
                            echo " Количество баллов: ".$bonus."</li>";
                            $total+=$bonus;
                            $key++;
                            
                        }
                        echo "</ul>";
                        echo "Итого набранных баллов: ".$total;
                    }

                    ?>


                    <div class="gap"></div>             
                </div>
            </div>
    <?php get_sidebar(); ?>
</div>

</section>


<?php get_footer(); ?>