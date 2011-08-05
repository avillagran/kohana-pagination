<?php

/**
 * Pagination generator
 *
 * @author Stefan Florian Röthlisberger <sfroeth@gmail.com>
 */
class Pagination {
    
    /**
     * Current page number
     * @var int
     */
    private $page_nr;
    
    /**
     * Number of items displayed per page
     * @var int 
     */
    private $items_per_page;
    
    /**
     * Total number of items
     * @var int 
     */
    private $total_items;
    
    /**
     * Base URL: 'members/detail' in 'members/detail/page/1'
     * @var string 
     */
    private $base_url;
    
    /**
     * URI segment: 'page' in 'members/detail/page/1'
     * @var string 
     */
    private $uri_segment;
    
    /**
     * Style of the pagination
     * @var string 
     */
    private $style;
    
    /**
     * Creates a pagination object
     * @param array $config Configuration
     */
    public function __construct($config)
    {
        $this->page_nr = Arr::get($config, 'page_nr');
        $this->items_per_page = Arr::get($config, 'items_per_page');
        $this->total_items = Arr::get($config, 'total_items');
        $this->base_url = Arr::get($config, 'base_url');
        $this->uri_segment = Arr::get($config, 'uri_segment');
        $this->style = Arr::get($config, 'style', 'pagination/default');
    }
    
    /**
     * Queries the database
     * @param string $orm_model_name Name of the model to create
     * @return Database Result
     */
    public function query($orm_model_name)
    {
        return ORM::factory($orm_model_name)
                ->limit($this->items_per_page)
                ->offset($this->items_per_page * max(($this->page_nr-1), 0))
                ->find_all(); 
    }
    
    /**
     * Returns the view of the pagination
     * @return Kohana_View View of the pagination 
     */
    public function get_view()
    {
        return View::factory($this->style)
                ->set('num_pages', ceil($this->total_items / $this->items_per_page))
                ->bind('page_nr', $this->page_nr)
                ->bind('base_url', $this->base_url)
                ->bind('uri_segment', $this->uri_segment);
    }
    
}
