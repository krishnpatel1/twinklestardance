<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client;
use Geocoder\Provider\GoogleMaps;

class StudiosController extends Controller
{
    public function index(){
        $studios = DB::select('select * from studios');
        
        $states = DB::select('select * from states where id IN (select distinct(state) from studios)');
        
        $countries = DB::select('select * from countries');

        /*$geocoder = new \Geocoder\Provider\GoogleMaps(
            new \Ivory\HttpAdapter\CurlHttpAdapter(),
            "en", "en", true,
            "AIzaSyBc4NZox6nQaB35rOr7ls1HyLt5DpzoJV4"
        );
        $geocoder_results=array();
        $counter = 0;*/
        /*foreach ($states as $studio){
            if($studio->latitude==null and $counter<100){
                $results = $geocoder->limit(1)->geocode($studio->name);                
                foreach($results as $result){
                    $geocoder_results[]=$result;
                    DB::update('update states set latitude = ? where id = ?',[$result->getLatitude(),$studio->id]);
                    DB::update('update states set longitude = ? where id = ?',[$result->getLongitude(),$studio->id]);
                }
                $counter++;
            }
        }        */
        
        //$result=$geocoder->limit(1)->geocode("California");
        //$geocoder_results=$result;
        //getCoordinates()
        $zip_list = $this->zipCodeRadius(37.7,-122.45,10);
        return view('welcome',['studios'=>$studios,'states'=>$states,'countries'=>$countries,'zip_list'=>$zip_list]);
    }
    
    public function edit(Request $request,$id) {
        $name = $request->input('stud_name');
        DB::update('update studios set name = ? where id = ?',[$name,$id]);
        echo "Record updated successfully.<br/>";
        echo '<a href = "/">Click Here</a> to go back.';
    }

    public function getCloseStudiosByZip(Request $request)
    {
        if ($request->isMethod('post')){    
            $data = $request->all();
            $request_zip_db = DB::select('select * from zip_codes where country='.$data['country'].' and zip="'.$data['zip'].'"');
            foreach($request_zip_db as $request_zip_db_hit){
                $request_zip = $request_zip_db_hit;
            }
            $zips = $this->zipCodeRadius($request_zip->latitude,$request_zip->longitude,20);
            //array_push($zips, $data['zip']);
            return response()->json(['response' => $zips,'country'=> $data['country']]); 
        }

        return response()->json(['response' => 'This is get method']);
    }
    
    function zipCodeRadius($lat, $lon, $radius)
    {
        $radius = $radius ? $radius : 20;
        $sql = 'SELECT distinct(zip) FROM zip_codes  WHERE (3958*3.1415926*sqrt((latitude-'.$lat.')*(latitude-'.$lat.') + cos(latitude/57.29578)*cos('.$lat.'/57.29578)*(longitude-'.$lon.')*(longitude-'.$lon.'))/180) <= '.$radius.';';
        $result = DB::select($sql);
        // get each result
        $zipcodeList = array();
        foreach ($result as $zip){        
            array_push($zipcodeList, $zip->zip);
        }
        return $zipcodeList;
    }
    
}
