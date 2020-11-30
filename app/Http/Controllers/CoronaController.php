<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\CoronaChart;
use App\Charts\StatChart;
use App\Contact;
use Illuminate\Support\Facades\Http;
use Datatables;
use Illuminate\Support\Facades\DB;

class CoronaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $suspect_indo = collect(Http::get('https://api.kawalcorona.com/indonesia')->json());
        $suspects_prov = collect(Http::get('https://api.kawalcorona.com/indonesia/provinsi')->json());
        $location_indo = collect(Http::get('https://services5.arcgis.com/VS6HdKS0VfIhv8Ct/arcgis/rest/services/COVID19_Indonesia_per_Provinsi/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json')->json());
        $stat_indo = collect(Http::get('https://services5.arcgis.com/VS6HdKS0VfIhv8Ct/arcgis/rest/services/Statistik_Perkembangan_COVID19_Indonesia/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json')->json());
        
        $labels = $suspects_prov->flatten(1)->pluck('Provinsi');
        $data   = $suspects_prov->flatten(1)->pluck('Kasus_Posi');
        $colors = $labels->map(function($item) {
            return $rand_color = '#' . substr(md5(mt_rand()), 0, 6);
        });

        $contacts=Contact::all();

        $chart = new CoronaChart;
        $chart->labels($labels);
        $chart->dataset('Kasus Positif', 'doughnut', $data)->backgroundColor($colors);

        $labels_stat = $stat_indo->flatten(2)->where('Jumlah_Kasus_Kumulatif', '!=', null)->pluck('Hari_ke');
        $data_stat  = $stat_indo->flatten(2)->where('Jumlah_Kasus_Kumulatif', '!=', null)->pluck('Jumlah_Kasus_Kumulatif');
        /*$colors_stat = $labels_stat->map(function($item) {
            return $rand_color = '#' . substr(md5(mt_rand()), 0, 6);
        });*/

        //dd($labels_stat);
        $chart_stat = new StatChart;
        $chart_stat->labels($labels_stat);
        $chart_stat->dataset('Jumlah Kumulatif', 'line', $data_stat)->backgroundColor('#EBF5FB'); 

        return view('welcome', [
            'chart' => $chart, 'chart_stat' => $chart_stat, 'suspect_indo' => $suspect_indo, 'location_indo' => $location_indo,'contacts'=>$contacts
        ]);
    }

    public function coronaList()
    {
        $response = Http::get('https://api.kawalcorona.com/indonesia/provinsi');
        $coronas = $response->json();
        return datatables()->of($coronas)->make(true);
        //dd($coronas);
    }

    public function provinceChart()
    {
        $per_province=array();
        $name_province=array();
        $y_province=array();
        $sembuh_province=array();
        $mati_province=array();
        $province=collect(Http::get('https://data.covid19.go.id/public/api/prov.json')->json());
        // dd($province['list_data']);
        for($i=0;$i<5;$i++){
            $per_province[]=$province['list_data'][$i];
            $name_province[]=$per_province[$i]['key'];
            $y_province[]=$per_province[$i]['jumlah_kasus'];
            $mati_province[]=$per_province[$i]['jumlah_meninggal'];
            $sembuh_province[]=$per_province[$i]['jumlah_sembuh'];
        }
        $chart_province = array(
            "nama_provinsi" => $name_province,
            "jumlah_kasus" => $y_province,
            "jumlah_mati" => $mati_province,
            "jumlah_sembuh" => $sembuh_province,
        );
        // dd(json_encode($chart_province));
        return response()->json([
            'data'=>$chart_province
        ]);
    }

    public function provinceLowestChart()
    {
        $per_province=array();
        $name_province=array();
        $y_province=array();
        $sembuh_province=array();
        $mati_province=array();
        $province=collect(Http::get('https://data.covid19.go.id/public/api/prov.json')->json());
        $n=0;
        for($i=count($province['list_data'])-5;$i<count($province['list_data']);$i++){
            $per_province[]=$province['list_data'][$i];
            $name_province[]=$per_province[$n]['key'];
            $y_province[]=$per_province[$n]['jumlah_kasus'];
            $mati_province[]=$per_province[$n]['jumlah_meninggal'];
            $sembuh_province[]=$per_province[$n]['jumlah_sembuh'];

            $n++;
        }
        $chart_province = array(
            "nama_provinsi" => $name_province,
            "jumlah_kasus" => $y_province,
            "jumlah_mati" => $mati_province,
            "jumlah_sembuh" => $sembuh_province,
        );
        return response()->json([
            'data'=>$chart_province
        ]);
    }

    public function storeContact (Request $request)
    {
        $contact=new Contact();
        $contact->provinsi=$request->provinsi;
        $contact->url=$request->url;
        $contact->no_telp=$request->telp;
        $contact->save();
        return redirect()->route('home');
    }

    public function delete($id)
    {
        DB::table('contacts')->where('id', $id)->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Sukses',
        ]);
    }
}
