function avon_api(){
    
    $URL = 'http://154.113.7.82/AvonHMOGlobalAPI/Api/listofplanbyprovider';
    
    $arguments = array(
        'method' => 'GET'
        );
        
    $response = wp_remote_get($URL, $arguments);
    if(is_wp_error($response)){
        $error_message = $response->get_error_message();
        return "Something went wrong. Contact the developer of the plugin: $error_message";
    }
    
    $results = json_decode(Wp_remote_retrieve_body($response));
    
   // var_dump($results);
    
    $form = '';
    
    
    $form .= '<div id ="form-search">';
    
   $form  .= '<form novalidate="" name="searchForm" id="searchForm" class="hidden md:flex flex space-x-4 media-hero-inps max-width mx-2">
    <input name="searchKey" type="text" placeholder="Search here" class="text-primary rounded px-10">
    
    <select _ngcontent-qvm-c54="" name="selectedCategory" class="form_input contact_select block text-primary px-10 rounded bg-grey border-grey w-full">
    <option value="">Categories</option>
    <option value="74">Boss Life</option>
    <option  value="75">Premium Life</option>
    <option  value="76">Life Plus</option>
    <option  value="162">Life Starter</option>
    <option  value="161">Couples Plan</option>
    </select>
    
    <button type="button" class="text-primary px-[44px] cus-color hover:border-[1px] py-2 rounded hover:border-purple flex justify-center hover:bg-lilac hover:text-purple transition-all duration-500 ease-in-out mr-5 bg-white opacity-7">Search</button>
    </form>';
    
    return $form;
    