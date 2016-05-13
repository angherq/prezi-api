<?php 

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;


class MainController extends BaseController {

	public function __construct() {
		$this->raw_json = file_get_contents(storage_path() . '/prezis.json');
		$this->json = json_decode($this->raw_json);
	}

    
    public function prezis($skip = null) {

		$prezis = [];

		foreach ($this->json as $key => $prezi) {
			
			if(!$skip) {
				if($key < 9)
					$prezis[] = $prezi; 
			}
			
			else {
				if(($key >= $skip)  && ($key < $skip+9))
					$prezis[] = $prezi; 
			}
		}

		return response()->json([
				'status' => 'success',
				'prezis' => json_encode($prezis)
			]
		);
    }

    public function search($string) {
    	if(!empty($string)) {
	    	$prezis = [];

			foreach ($this->json as $key => $prezi) {

				if (strlen(stristr($prezi->title, $string)) > 0) {
					$prezis[] = $prezi;
				}
			}

			return response()->json([
					'status' => 'success',
					'prezis' => json_encode($prezis)
				]
			);
		} 
		else {
			return response()->json([
					'status' => 'warning',
					'message' => 'no string received'
				]
			);
		}
    }
}
