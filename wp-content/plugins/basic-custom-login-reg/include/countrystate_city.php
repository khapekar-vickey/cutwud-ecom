<?php
//Include database configuration file

if(isset($_POST["countryID"])) {
    global $wpdb;
//Get all state data
      $states = $wpdb->get_results("SELECT * FROM states WHERE country_id =" . $_POST['countryID']."  ORDER BY name ASC", ARRAY_A);
      //print_r($states);

//Display states list
    echo '<option value="">Select State</option>';
    foreach ($states as $state) {
        echo '<option value="' . $state['id'] . '">' . $state['name'] . '</option>';
    }
    wp_die();
}

if(isset($_POST["state_id"])) {
//Get all city data
    global $wpdb;
    $cities = $wpdb->get_results("SELECT * FROM cities WHERE state_id = " . $_POST['state_id'] . " ORDER BY name ASC", ARRAY_A);

//Display cities list
    echo '<option value="">Select City</option>';
    foreach ($cities as $city) {
        echo '<option value="' . $city['name'] . '">' . $city['name'] . '</option>';
    }
    //wp_die();
}

function get_allcities($state_id,$cityid)
{
    //Get all city data
    global $wpdb;
    $cities = $wpdb->get_results("SELECT * FROM cities WHERE state_id = " . $state_id. " ORDER BY name ASC", ARRAY_A);

//Display cities list
    echo '<option value="">Select City</option>';
    foreach ($cities as $city) {
        if($cityid==$city['name']){
             echo '<option selected="selected" value="' . $city['name'] . '">' . $city['name'] . '</option>';
        }else{
            echo '<option value="' . $city['name'] . '">' . $city['name'] . '</option>';
        }
    }
    
}

function get_allstates($user_country,$user_state){

    global $wpdb;
//Get all state data
      $states = $wpdb->get_results("SELECT * FROM states WHERE country_id =" . $user_country."  ORDER BY name ASC", ARRAY_A);
 
//Display states list
    echo '<option value="">Select State</option>';
    foreach ($states as $state) {
        if($user_state==$state['id']){
        echo '<option selected="selected" value="' . $state['id'] . '">' . $state['name'] . '</option>';
        }else{
            echo '<option value="' . $state['id'] . '">' . $state['name'] . '</option>';
        }
    }

}

//Get all country data
function get_allcountries($id)
{
    global $wpdb;
    //$counties = $wpdb->get_results("SELECT * FROM countries WHERE id=$id ORDER BY name ASC", ARRAY_A);
    $counties = $wpdb->get_results("SELECT * FROM countries ORDER BY name ASC", ARRAY_A);
    //print_r($counties);
//Display county lists
    echo '<option value="">Select County</option>';
    foreach ($counties as $county_single) {
        if($id==$county_single['id']){
        echo '<option selected="selected" value="' . $county_single['id'] . '">' . $county_single['name'] . '</option>';
        }else{
            echo '<option value="' . $county_single['id'] . '">' . $county_single['name'] . '</option>';
        }
    }
    //wp_die();
}

function get_wpum_country($id)
{
        global $wpdb;
        $thepost = $wpdb->get_row("SELECT name FROM countries WHERE id=".$id);
        return $thepost->name; 
}


function get_wpum_state($id)
{
        global $wpdb;
        $theposts = $wpdb->get_row("SELECT name FROM states WHERE id=".$id);
        return $theposts->name; 
}