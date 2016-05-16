<?php 

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;


class MainController extends BaseController {

	//In this particular example we wil always use the json provied, so we can 
	//initialize it on every request for being available on every function.
	public function __construct() {
		$this->raw_json = file_get_contents(storage_path() . '/prezis.json');
		$this->json = json_decode($this->raw_json, true);
	}

    //Skip flag is used for the load more feature, otherwise whe only return first 9 elements.
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

    //Sort by date DESC
    public function prezisOrdered($skip = null) {

		$prezis = new \Illuminate\Database\Eloquent\Collection();

		//json createdAt value is transformed into a timestamp then added as a new property
		foreach($this->json as $key => $prezi) {

			$unformatted_date = date_create_from_format('F j, Y', $prezi['createdAt']);
			$prezi['created_at'] = strtotime(date_format($unformatted_date, 'Y-m-d'));
		    
		    $prezis->add($prezi);	
		}

		$ordered = $prezis->sortByDesc('created_at')->slice($skip)->take(9)->values()->all();

		return response()->json([
				'status' => 'success',
				'prezis' => json_encode($ordered)
			]
		);
    }

    //Search by title
    public function search($string) {
    	if(!empty($string)) {
	    	$prezis = [];

			foreach ($this->json as $key => $prezi) {

				if (strlen(stristr($prezi['title'], $string)) > 0) {
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
