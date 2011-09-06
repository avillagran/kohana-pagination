<?php 
    define('BASE_URL', $base_url);
    define('URI_SEGMENT', $uri_segment);
    
    function url($page, $description, $active, $base_url=BASE_URL, 
            $uri_segment=URI_SEGMENT)
    {
        if($active)
        {
        	$url = URL::site($base_url.'/'.$uri_segment.'/'.$page);
			$url .= URL::query();
            return '<span class="page"><a href="' . $url . '" rel="next">'.$description.'</a></span>' . "\n";
        }
        else
        {
            return '<span class="page current">'.$description.'</span>' . "\n";
        }
    }
    
    $pagination = '';
    $first = 1;
    $last = $num_pages;
    $previous = max(1, $page_nr - 1);
    $next = min($num_pages, $page_nr + 1);
    $diff = 2;

    $pagination .= url($first, 'First', $page_nr != $first);
    $pagination .= url($previous, '<', $page_nr != $first);       

    if($page_nr > $diff + 1)
    {
        $pagination .= "...\n";
    }   
    
    $from = max($page_nr - $diff, 1);      
    $to = min($page_nr + $diff, $num_pages);
    if($page_nr <= $diff) $to += $diff - $page_nr + 1;
    if($page_nr > $num_pages - $diff) $from -= $diff - $num_pages + $page_nr ;

    foreach(range($from, $to) as $page)
    {
        if($page == $page_nr || ($page == 1 && $page_nr == 0))
            $pagination .= url($page, $page, false);
        else 
            $pagination .= url($page, $page, true);
    }
    
    if($page_nr < $num_pages-$diff)
    {
        $pagination .= "...\n";
    }
        
    $pagination .= url($next, '>', $page_nr != $last);
    $pagination .= url($last, 'Last', $page_nr != $last);
    if($num_pages > 1)
    echo $pagination;
    
?>