function etiquetas_del_term($term){
    $post_ids = get_posts(array(
        'numberposts'   => -1, // get all posts.
        'tax_query'     => array(
            array(
                'taxonomy'  => 'category',
                'field'     => 'name',
                'terms'     => $term,
            ),
        ),
        'fields'        => 'ids', // Only get post IDs
    ));
      
      foreach ($post_ids as $post_id) {
        $term_list = wp_get_post_terms($post_id, 'post_tag', array("fields" => "ids"));

            foreach ($term_list as $term_solo) {
                $todos_terms[]= $term_solo;
            }
        
      }
      
      $terminos_finales = array_unique($todos_terms);

      $tags_array = get_tags(array( 'orderby' => 'count','order' => 'DESC' ));
      $biggest_tag= array_shift(array_values($tags_array));
      $biggest_tag_num = $biggest_tag->count;

      $spread = $biggest_tag_num - 1;
      $max_num= 26;
      $min_num = 12;

        $font_spread = $max_num - $min_num;

        $font_step = $font_spread / $spread;
     

      foreach ($terminos_finales as $termino_final) {
        $termino = get_term_by(id,$termino_final, 'category');
        $nombre_termino =$termino->name;
        $slug_termino = $termino->slug;
        $count_termino = $termino->count;

        $total= $min_num + ( $count_termino - 1 ) * $font_step;

        echo '<a href="'. get_home_url().'/tag/'.$slug_termino.'" class="tag-cloud-link" style="font-size:'.$total.'pt;">'.$nombre_termino.' </a>';
      } 
}