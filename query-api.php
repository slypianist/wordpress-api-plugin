<?php
/*
Plugin name: Custom WordPress Plugin
plugin URL: https://symoletech.com.ng
Description: Developed to connect to external api data source to fetch data.
Version: 1.0.1
Author: Sylvester Umole
Author URI: https://symoletech.com.ng
License: GPL2 or later
License URI:

*/

defined('ABSPATH')|| die('Unauthorised Access');


//Create short code
add_shortcode('external_data', 'avon_api_shortcode');

function avon_api_shortcode(){
    
   wp_enqueue_script('rest-api-scripts', plugins_url('asset/js/scripts.js', __FILE__), ['jquery'], '0.1.0', true );
   
   wp_enqueue_script('map-scripts', plugins_url('asset/js/map.js', __FILE__), ['jquery'], '0.1.0', true );
   
  wp_enqueue_style('style', plugin_dir_url(__FILE__).'asset/css/style.css');
   
    
    
    $form = '';
    
    
    $form .= '<form name="searchForm" id="searchForm" class="hidden md:flex flex space-x-4 media-hero-inps max-width mx-2 form">
    
    <input name="searchKey" id="user_input" type="text" placeholder="Search here..." class="text-primary rounded px-10  w-full">
    
    <select name="selectedCategory" id="categoryPlan" class="form_input contact_select block text-primary px-10 rounded bg-grey border-grey">
        <option value="">Categories</option>
        <option  value="74">Boss Life</option>
        <option  value="75">Premium Life</option>
        <option value="76">Life Plus</option>
        <option value="162">Life Starter</option>
        <option value="161">Couples Plan</option>
        <!----></select>
    <button type="button" id="searchButton" class="text-primary px-[44px] cus-color hover:border-[1px] py-2 rounded hover:border-purple flex justify-center hover:bg-lilac hover:text-purple transition-all duration-500 ease-in-out mr-5 bg-white opacity-7">Search</button>
    
    <button type="button" id="searchProgress" class="text-primary px-[44px] cus-color hover:border-[1px] py-2 rounded hover:border-purple flex justify-center hover:bg-lilac hover:text-purple transition-all duration-500 ease-in-out mr-5 bg-white opacity-7"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true show"></span> Search...</button>
    
    <!----><!----></form>';
    
   
    
    
    return $form;

}

//Add action hook
add_action('rest_api_init', 'avon_api_ajax_endpoint');
//add_action('wp_enqueue_scripts', 'add_style');

function avon_api_ajax_endpoint(){
    register_rest_route(
        'avon',
        'avon-provider',
        [
            'methods'=>'GET',
            'permission_callback' => '__return_true',
            'callback' => 'avon_api_ajax_callback',
            'args'=>[
                'page'=>[
                    
                    'required' =>false,
                    'type' => 'number',
                    ]
                
                
                ] 
           
            ]
        );
}

// Call API

function avon_api_ajax_callback(WP_REST_Request $request ){
    
  // $data = $_POST['pageNumber'];
   
   //    $pageNumber = $request->get_body_params();
     $page =  $request->get_param('page');
     
     $size = $request->get_param('size');
    
    
     //   $pageSize = $request->get_param('pageSize');
   $parameters =  $parameters = $request->get_params();
     
    // $parameters = $request->get_params();
   // var_dump($page);
   if(empty($page)){
        $page = "";
    }else{
         $page =  $request->get_param('page');
    }
   if(empty($size)){
        $size = "";
    }else{
        $size =  $request->get_param('size');
    }
    
    
        $category = $request->get_param('category');
    
    
        $searchKey =$request->get_param('search');
    
   // $category = get_param['selectedCategory'];
   // 
    
    
    
     $URL = 'https://xxxxxxxxxxxxxx?PageNumber='.$page.'&PageSize='.$size.'&category='.$category.'&searchKey='.$searchKey;;
    
    $arguments = array(
        'method' => 'GET'
        );
        
    $response = wp_remote_get($URL, $parameters);
    if(is_wp_error($response)){
        $error_message = $response->get_error_message();
        return "Something went wrong. Contact support for assistance : $error_message";
    }
    
    $response = Wp_remote_retrieve_body($response);
    $response = json_decode($response);
  //  var_dump($response->totalrecords);
   
    
    return $response;
   
   
}

