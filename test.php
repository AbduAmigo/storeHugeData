<?php

// *********************************
// This function is in PHP to allow
// to store huge records of data all
// in the DB - will grap first 100
// records and insert them then next
// 100 till the end.
// Objective: will reduce memory time
// *********************************
// Author: Hisham
// Email: mailto:hishamabbasi124@gmail.com
// Author: Abdalla A
// TW: https://twitter.com/abdu_amigo
// *********************************
function test()
{
    // 1) to get data from DB as in rows
    $num_rows = $this->db->get('test')->num_rows();
    
    // 2) devide data by 100 as limit    
    $count = $num_rows / 100;
    
    // 3) to check for decimal
    if(is_numeric( $count ) && floor( $count ) != $count){
        $is_decimal = true;
        $count = ceil($count);
    }else{
        $is_decimal = false;
        $count = $count;
    }
    
    // 3) to use foreach loop
    for($i = 0; $i < $count; $i++){

        // 4) to grap first 100 and insert the data into DB
        if($i == 0){
            $this->db->limit(100, $i);
            $query = $this->db->select('test_text as text')->get('test')->result_array();
            for($j = 0; $j < count($query); $j++){
                $this->db->insert('test_2', $query[$j]);
            }
            
            
        }else{
            // 5) to grap the next 100 records and insert into DB
            $this->db->limit(100, $i * 100);
            $query = $this->db->select('test_text as text')->get('test')->result_array();
            for($j = 0; $j < count($query); $j++){
                $this->db->insert('test_2', $query[$j]);
            }
            
        };
        // 6) to check for decimal point and add the last remaining records with the last 100 records
        if($is_decimal){
            if($i === $count - 1){
                $remaining =  $num_rows - $i * 100; // 3
                $this->db->limit(100 + $remaining, $i * 100);
                $query = $this->db->select('test_text as text')->get('test')->result_array();
                for($j = 0; $j < count($query); $j++){
                    $this->db->insert('test_2', $query[$j]);
                }
                
            }
        }    
        
    }
}

?>