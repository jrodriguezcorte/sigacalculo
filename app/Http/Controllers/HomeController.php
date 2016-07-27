<?php namespace App\Http\Controllers;

use Input;
use Response;
use Request;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
            // Get the current year
            $year = date('y');
            $schema = "SIMA0".$year;
            
            $esquema = array();
            $codnom = array();
            $fecnom = array();
            $codemp = array(); 
            $codnomesp = array();       
                    
            for($i = $year; $i >= 14; $i--) {
                $esquema["SIMA0".$i]="SIMA0".$i;
               // array_unshift($esquema,"SIMA0".$i);                
            }
                    
            $codnom_query = \DB::connection('SIMA')->select( \DB::raw('SELECT distinct codnom FROM "'.$schema.'".npnomcal where length(codnom) > 0 order by codnom asc'));
            $fecnom_query = \DB::connection('SIMA')->select( \DB::raw('SELECT distinct fecnom FROM "'.$schema.'".npnomcal order by fecnom desc'));
            $codemp_query = \DB::connection('SIMA')->select( \DB::raw('SELECT distinct codemp FROM "'.$schema.'".npnomcal where length(codemp) > 0 order by codemp asc'));
            $codnomesp_query = \DB::connection('SIMA')->select( \DB::raw('SELECT distinct codnomesp FROM "'.$schema.'".npnomcal where length(codnomesp) > 0 order by codnomesp asc'));

            foreach ($codnom_query as $cod) {
                $codnom[$cod->codnom]=$cod->codnom;
            }
            
            foreach ($fecnom_query as $fec) {
                $fecnom[$fec->fecnom]=$fec->fecnom;
             //   array_push($fecnom,$fec->fecnom); 
            }

            foreach ($codemp_query as $cod) {
                $codemp[$cod->codemp]=$cod->codemp;
             //   array_push($codemp,$cod->codemp); 
            }

            foreach ($codnomesp_query as $cod) {
                $codnomesp[$cod->codnomesp]=$cod->codnomesp;
                // array_push($codnomesp,$cod->codnomesp); 
            }            
            
            $data = array(
                'esquema'  => $esquema,
                'codnom' => $codnom,
                'fecnom' => $fecnom,
                'codemp' => $codemp,
                'codnomesp' => $codnomesp,
            );
                
                        
		return view('home')->with('data', $data);
	}
        
        public function autocomplete(){
            $term = Input::get('term');

            $results = array();

            // Get the current year
            $year = date('y');
            $schema = "SIMA0".$year;        

            $queries = \DB::connection('SIMA')->select( \DB::raw('SELECT distinct codemp FROM "'.$schema.'".npnomcal where length(codemp) > 0 order by codemp asc'));

            foreach ($queries as $query)
            {
                $results[] = [ 'id' => $query->codemp, 'value' => $query->codemp ];
            }
            return Response::json($results);
        }
        
        public function search(){
            
            if(Request::ajax()) {
                
                $esquema = Input::get('esquema');
                $codnom = Input::get('codnom');
                $fecnom = Input::get('fecnom');
                $codemp = Input::get('q');
                $especial = Input::get('especial');
                $codnomesp = Input::get('codnomesp');
                
                $from  = "\"".$esquema."\".npnomcal";
                // especial = 0 NO es una nomina especial
                if ($especial == "0") {
                    $queries = \DB::connection('SIMA')->select( \DB::raw("SELECT '".$esquema."' as esquema, id, codcon, asided, nomcon, acumulado, saldo, codemp "
                        . "FROM ".$from
                        . " where codnom = '".$codnom."'"
                        . " and fecnom = '".$fecnom."'"
                        . " and codemp like '%".$codemp."%'"    
                            ));                    
                } else {
                    $queries = \DB::connection('SIMA')->select( \DB::raw("SELECT '".$esquema."' as esquema, id, codcon, asided, nomcon, acumulado, saldo, codemp "
                        . "FROM ".$from
                        . " where codnom = '".$codnom."'"
                        . " and fecnom = '".$fecnom."'"
                        . " and codnomesp = '".$codnomesp."'"    
                        . " and codemp like '%".$codemp."%'"    
                            ));                                    
                }
                
                return response()->json($queries);
            } 
        }     
        
        public function update(){
            
                $esquema = Input::get('esquema');
                $id = Input::get('id');
                $saldo = Input::get('saldo');
                $acumulado = Input::get('acumulado');
                
                $from  = "\"".$esquema."\".npnomcal";
                
                $queries = \DB::connection('SIMA')->select( \DB::raw("UPDATE ".$from." "
                        . "SET acumulado = ".$acumulado.", saldo = ".$saldo."  "
                        . "where id = ".$id));
                
                $result = \DB::connection('SIMA')->select( \DB::raw("SELECT '".$esquema."' as esquema, id, codcon, asided, nomcon, acumulado, saldo, codemp "
                        . "FROM ".$from
                        . " where id = '".$id."'"  
                            )); 
                
                
            return response()->json($result[0]);
 

        }

}
