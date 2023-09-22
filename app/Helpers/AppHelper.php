<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class AppHelper
{

    public static function cek_menu_child($a) {
        return DB::table('menu')
        ->select('menu_id', 'menu_R')
        ->where('menu_parent_id', '=', $a)
        ->where('menu_display', '=',1)
        ->count();
    }
    
    public static function menu_child($a) {
        return DB::table('menu')
        ->where('menu_parent_id', '=', $a)
        ->where('menu_display', '=',1)
        ->orderBy('menu_menu_order', 'asc')->get();
    }
    
    public static function select_menu() {
        return DB::table('menu')
        ->where('menu_parent_id', '=', 0)
        ->where('menu_display', '=', 1)
        ->orderBy('menu_menu_order', 'asc')->get();

        // DB::table('menu as a')
        //         ->join('menu_access_member as b', 'a.menu_id', '=', 'b.menu_id')
        //         ->select('a.menu_id as menu_id', 'a.menu_faIcon as menu_faIcon', 'a.menu_title_ID as menu_title_ID'
        //         , 'a.menu_url as menu_url')
        //         ->where('a.menu_parent_id', '=', 0)
        //         ->where('a.menu_display', '=', 1)
        //         ->where('a.menu_R', '=', 'b.meac_R')
        //         ->where('b.memb_code', '=', session('memb_code'))
        //         ->orderBy('a.menu_menu_order', 'asc')->get();
    }
    
    public static function select_menu_akses($a, $b) {
        return DB::table('menu_access_member')
        ->where('menu_id', '=', $a)
        ->where('meac_R', '=', $b)
        ->where('memb_code', '=', session('memb_code'))->count('meac_id');;
    }
    
    public static function decode_image($a) {
        //return '<img src="'.base64_decode($a).'">';
    }
	
	public static function access_menu($menu_id)
    {	
        // session()->put('user_id', 1);
        // session()->put('memb_id', 21);
        // session()->put('memb_code', '2202181600430000005');
        // return DB::select("SELECT b.menu_faIcon AS menu_faIcon, b.menu_title_ID AS menu_title_ID, d.user_id AS user_id, a.meac_C AS meac_C, a.meac_R AS meac_R, a.meac_U AS meac_U, 
        // a.meac_D AS meac_D, a.meac_printing AS meac_printing, a.meac_detail AS meac_detail, b.menu_C AS menu_C, b.menu_R AS menu_R, b.menu_U AS menu_U, b.menu_D AS menu_D, 
        // b.menu_printing AS menu_printing, b.menu_detail AS menu_detail, b.menu_display AS menu_display FROM menu AS b join menu_access_member AS a ON 
        // a.menu_id = b.menu_id join member as d ON d.user_id = a.user_id WHERE a.menu_id = '$menu_id' AND b.menu_display = 1 AND 
        // d.memb_id = '".session('memb_id')."' limit 1"); 
        
        return DB::table('menu as b')
        ->join('menu_access_member as a', 'a.menu_id', '=', 'b.menu_id')
        ->join('member as d', 'd.user_id', '=', 'a.user_id')
        ->join('user as e', 'd.user_id', '=', 'e.user_id')
        ->select('d.memb_code as memb_code', 'b.menu_action3 as menu_action3', 'a.meac_action3 as meac_action3', 'b.menu_action2 as menu_action2', 'a.meac_action2 as meac_action2', 'b.menu_action1 as menu_action1', 'a.meac_action1 as meac_action1', 'e.user_name as user_name', 'b.menu_url as menu_url', 'b.menu_faIcon as menu_faIcon', 'b.menu_title_ID as menu_title_ID', 'd.user_id as user_id', 'a.meac_C as meac_C', 'a.meac_R as meac_R', 'a.meac_U as meac_U', 'a.meac_D as meac_D', 'a.meac_printing as meac_printing', 
        'a.meac_detail as meac_detail', 'b.menu_C as menu_C', 'b.menu_R as menu_R', 'b.menu_U as menu_U', 'b.menu_D as menu_D', 'b.menu_printing as menu_printing', 
        'b.menu_detail as menu_detail', 'b.menu_display as menu_display')
        ->where('a.menu_id', '=', $menu_id)
        ->where('b.menu_display', '=',1)
        ->where('d.memb_id', '=', session('memb_id'))->first();
    }
    
    public static function company_profile() {
        return DB::table('company_profile')->select("comp_colour_backend")->first();
    }
    
    public static function limit() {
        return 10;
    }
    
    public static function set_select($ID, $table, $var_name, $var_name_value, $var_name_value_edit){
        /*if($ID <> '' and $var_name_value <> ''){ 
            session()->put('session_input'.$table.$var_name, $var_name_value);
        }*/
        if($ID){ 
            if($var_name_value == $var_name_value_edit){ 
                echo 'selected'; 
            }
        } else if(session('session_input'.$table.$var_name)){ 
            if(session('session_input'.$table.$var_name) == $var_name_value){ 
                echo 'selected'; 
            }
        }
    }
    
    public static function set_select_empty($ID, $table, $var_name, $var_name_value, $var_name_value_edit){
        /*if($ID <> '' and $var_name_value <> ''){ 
            session()->put('session_input'.$table.$var_name, $var_name_value);
        }*/
        if($ID){ 
            if($var_name_value == $var_name_value_edit){ 
                echo 'selected'; 
            }
        } else if(session('session_input'.$table.$var_name)){ 
            if(session('session_input'.$table.$var_name) == $var_name_value){ 
                //echo 'selected'; 
            }
        }
    }
    
    public static function set_select_default($ID, $table, $var_name, $var_name_value, $var_name_value_edit){
        /*if($ID <> '' and $var_name_value <> ''){ 
            session()->put('session_input'.$table.$var_name, $var_name_value);
        }*/
        if($ID){ 
            if($var_name_value == $var_name_value_edit){ 
                echo 'selected'; 
            }
        } else if(session('session_input'.$table.$var_name)){ 
            if(session('session_input'.$table.$var_name) == $var_name_value){ 
                echo 'selected'; 
            } else if($var_name_value == $var_name_value){
                echo 'selected'; 
            }
        }
    }
    
    public static function set_input($ID, $table, $var_name, $var_name_value_edit){
         if($ID == ''){ 
            //session()->put('session_input'.$table.$var_name, $var_name_value);
            if(session('session_input'.$table.$var_name)){
                echo session('session_input'.$table.$var_name); 
            } else {
                echo $var_name_value_edit;
            }
        } else {
            echo $var_name_value_edit;
        }
    }
    
    public static function set_input_empty($ID, $table, $var_name, $var_name_value_edit){
         if($ID == ''){ 
            //session()->put('session_input'.$table.$var_name, $var_name_value);
            if(session('session_input'.$table.$var_name)){
                //echo session('session_input'.$table.$var_name); 
            } else {
                echo $var_name_value_edit;
            }
        } else {
            echo $var_name_value_edit;
        }
    }
	
	public static function translate_option($a)
	{
	    $txt = strpos($a, '/') + 2; 
        $txt2 = strlen($a);
        $judul = substr($a, $txt, $txt2);
        return $judul;
	}
	
	public static function encode($string)
	{
        $key = 'adgdsd224';
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
	}
	
	public static function decode($string)
	{
        $key = 'adgdsd224';
        $result = '';
        $string = base64_decode($string);
         
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
	}
    
    public static function paging($queryTable, $limit, $pages, $halaman, $menu, $show, $lastrow, $num2){
		$query = DB::select($queryTable);
		$row = $num2;
		$start = ($halaman-1)*$limit;
		$lpage = ceil($row/$limit);
		$last = ($lpage-1)*$limit;
		$previous = $halaman-1;
		$next = $halaman+1;
		
		$max = $row-$limit;
		$after = $start;
		$before = $start;
		$j=0;
		$k=2;
		$l=1;
		$m=0;
		$n=1;
		
		$color = \App\Helpers\AppHelper::company_profile();
		
		$html2 = '<input type="hidden" value='.$menu.' id="menus">
		<div style="float:left;padding-left:20px;color:#fff">Show <font color="#fff">'.$show.'</font> to <font color="#fff">'.$lastrow.'</font> from <font color="#fff">'.$num2.'</font> entries</div>
		<div style="float:right;color:#fff;padding-right:20px">
		<ul class="pagination" style="margin-top:-5px">';
		if($halaman>2){
		$html2 .='
		<li><button id="page_button" class="btn btn-default" value="1" onClick="paging(this.value)">First</button></li>
		';
		}
		
		if($halaman>1){
		$html2 .='
		<li><button id="page_button" class="btn btn-default" value="'.$previous.'" onClick="paging(this.value)">Previous</button></li>
		';
		}
		
		while(($halaman>($j+1)) && $k>0){
		  if($halaman==2){	
		  $page=$halaman-1;
		  }else{
		  $page=$halaman-$k;
		  }
		  $html2 .='
		  <li><button id="page_button" class="btn btn-default" value="'.$page.'" onClick="paging(this.value)">'.$page.'</button></li>
		  ';
		  $j++;
		  $k--;
		}
		
		$html2 .='
		<li><button id="page_current" style="background-color:'.$color->comp_colour_backend.';border:1px solid '.$color->comp_colour_backend.';color:#fff" class="btn btn-default" value="'.$halaman.'" onClick="paging(this.value)">'.$halaman.'</button></li>
		';
		
		while(($halaman<($lpage-$m)) && $m<2){
		  $page=$halaman+$n;
		  $html2 .='
		  <li><button id="page_button" class="btn btn-default" value="'.$page.'" onClick="paging(this.value)">'.$page.'</button></li>
		  ';
		  $m++;
		  $n++;
		}
		
		if($halaman<($lpage)){
		$html2 .='
		<li><button id="page_button" class="btn btn-default" value="'.$next.'" onClick="paging(this.value)">Next</button></li>
		';
		}
		
		if($halaman<($lpage-1)){
		$html2 .='
		<li><button id="page_button" class="btn btn-default" value="'.$lpage.'" onClick="paging(this.value)">Last</button></li>
		';	
		}
		$html2 .='</ul></div>';
		
		return $html2;
	}
}