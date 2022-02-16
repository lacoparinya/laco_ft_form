<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packaging;
use App\PackPaper;
use App\PackPaperD;
use App\PackPaperLot;
use App\PackPaperPackage;
use App\PackageInfo;
use App\ProductInfo;

use Maatwebsite\Excel\Facades\Excel;

class PackPapersController extends Controller
{
    public function index(){
        $paperpacks = PackPaper::paginate(25);
        return view('pack_papers.index', compact('paperpacks'));
    }

    public function generateOrder($id,$set=1,$lot=1){
        $packaging = Packaging::findOrFail($id);

        $productinfo = ProductInfo::where('packaging_id',$id)->first();

   // dd($productinfo);

        $packageexp = array();
        $packagelist = array();
        foreach ($packaging->packagestamptxt as $packagestampObj) {
           
            $packageexp[$packagestampObj->package_id] = $packagestampObj->stamp_type;
        }

        foreach($packaging->package as $packageObj){
            $packagelist[] = $packageObj->id;
        }

        $packageinforw = PackageInfo::whereIn('packaging_id', $packagelist)->get();
      
        $packageinfos =array();
        foreach($packageinforw as $packageinfoObj){
            $packageinfos[$packageinfoObj->packaging_id] = $packageinfoObj;
        }
        $cablecoverlist = array(
            'ไม่รัดสาย' => 'ไม่รัดสาย',
            'สายรัดสีแดง' => 'สายรัดสีแดง',
            'สายรัดสีน้ำเงิน' => 'สายรัดสีน้ำเงิน',
            'สายรัดสีบรอนซ์' => 'สายรัดสีบรอนซ์'
        );

        return view('pack_papers.generateorder', compact('packaging', 'packageexp', 'set', 'lot', 'packageinfos','productinfo', 'cablecoverlist'));
    }

    public function generateOrderAction(Request $request, $id,$set,$lot)
    {
        $requestData = $request->all();

        //dd($requestData);

        $packaging = Packaging::findOrFail($id);
        $productinfo = ProductInfo::where('packaging_id', $id)->first();
        foreach ($packaging->package as $packageObj) {
            $packagelist[] = $packageObj->id;
        }

        $packageinforw = PackageInfo::whereIn('packaging_id', $packagelist)->get();

        $packageinfos = array();
        foreach ($packageinforw as $packageinfoObj) {
            $packageinfos[$packageinfoObj->packaging_id] = $packageinfoObj;
        }

        $tmppaperpack = array();
        $tmppaperpack['packaging_id'] = $id;
        $tmppaperpack['order_no'] = $requestData['order_no'];
        $tmppaperpack['exp_month'] = $requestData['exp_month'];
        $tmppaperpack['weight_with_bag'] = $requestData['weight_with_bag'];
        $tmppaperpack['loading_date'] = $requestData['loading_date'];
        $tmppaperpack['product_fac'] = $requestData['product_fac'];
        $tmppaperpack['status'] = 'Active';
        
        $tmpproductinfo = array();
        $tmpproductinfo['packaging_id'] = $id;



        if ($request->hasFile('cable_file')) {
            $image = $request->file('cable_file');
            $name = "cb_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/packaging/' . $id);
            $image->move($destinationPath, $name);

            $tmpproductinfo['cable_img'] = 'images/packaging/' . $id  . "/" . $name;
            $tmppaperpack['cable_img'] = 'images/packaging/' . $id  . "/" . $name;
        }else{
            if(isset($productinfo->cable_img)){
                $tmppaperpack['cable_img'] = $productinfo->cable_img;
            }
        }   
        if ($request->hasFile('inbox_file')) {
            $image = $request->file('inbox_file');
            $name = "ib_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/packaging/' . $id);
            $image->move($destinationPath, $name);

            $tmpproductinfo['inbox_img'] = 'images/packaging/' . $id  . "/" . $name;
            $tmppaperpack['inbox_img'] = 'images/packaging/' . $id  . "/" . $name;
        }else{
            if (isset($productinfo->inbox_img)) {
                $tmppaperpack['inbox_img'] = $productinfo->inbox_img;
            }
        }
        if ($request->hasFile('pallet_file')) {
            $image = $request->file('pallet_file');
            $name = "pl_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/packaging/' . $id);
            $image->move($destinationPath, $name);

            $tmpproductinfo['pallet_img'] = 'images/packaging/' . $id  . "/" . $name;
            $tmppaperpack['pallet_img'] = 'images/packaging/' . $id  . "/" . $name;
        }else{
            if (isset($productinfo->pallet_img)) {
                $tmppaperpack['pallet_img'] = $productinfo->pallet_img;
            }
        }

        $packpaperObj = PackPaper::create($tmppaperpack);

        $productinfo = ProductInfo::where('packaging_id', $id)->first();
        if (empty($productinfo)) {
            ProductInfo::create($tmpproductinfo);
        } else {
            $productinfo->update($tmpproductinfo);
        }

        for ($setloop=1; $setloop <= $set; $setloop++) {
            $tmppaperpackd = array();
            $tmppaperpackd['pack_paper_id'] = $packpaperObj->id; 
            $tmppaperpackd['pack_date'] = $requestData['pack_date'. $setloop]; 
            $tmppaperpackd['exp_date'] = $requestData['exp_date' . $setloop]; 
            $tmppaperpackd['all_weight'] = $requestData['all_weight' . $setloop]; 
            $tmppaperpackd['all_bpack'] = $requestData['all_bpack' . $setloop]; 
            $tmppaperpackd['cablecover'] = $requestData['cablecover' . $setloop];

            PackPaperD::create($tmppaperpackd);
        }

        for ($lotloop = 1; $lotloop <= $lot; $lotloop++) {
            $tmppaperpacklot = array();
            $tmppaperpacklot['pack_paper_id'] = $packpaperObj->id;
            $tmppaperpacklot['pack_date'] = $requestData['packdate' . $lotloop];
            $tmppaperpacklot['exp_date'] = $requestData['expdate' . $lotloop];
            $tmppaperpacklot['lot'] = $requestData['lot' . $lotloop];
            $tmppaperpacklot['frombox'] = $requestData['fbox' . $lotloop];
            $tmppaperpacklot['tobox'] = $requestData['tbox' . $lotloop];
            $tmppaperpacklot['nbox'] = $requestData['nbox' . $lotloop];
            $tmppaperpacklot['nbag'] = $requestData['nbag' . $lotloop];
            $tmppaperpacklot['pweight'] = $requestData['pweight' . $lotloop];
            $tmppaperpacklot['fweight'] = $requestData['fweight' . $lotloop];
            $tmppaperpacklot['pallet'] = $requestData['pallet' . $lotloop];
            $tmppaperpacklot['pbag'] = $requestData['pbag' . $lotloop];
            $tmppaperpacklot['note'] = $requestData['note' . $lotloop]; 

            PackPaperLot::create($tmppaperpacklot);
        }

        foreach ($packaging->package as $packageObj){
            $tmppackpaperpackage = array();
            $tmppackpaperpackage['pack_paper_id'] = $packpaperObj->id;
            $tmppackpaperpackage['packaging_id'] = $packageObj->id;
            $tmppackpaperpackage['lot'] = $requestData['lottxt' . $packageObj->id];
            
            $tmppackageinfo = array();

            $tmppackageinfo['packaging_id'] = $packageObj->id;
            $tmppackageinfo['pack_date_format'] = $requestData['starttxtpack' . $packageObj->id];
            $tmppackageinfo['exp_date_format'] = $requestData['exptxtpack' . $packageObj->id];
            $tmppackageinfo['extra_stamp'] = $requestData['extrastamp' . $packageObj->id];

            $tmppackpaperpackage['pack_date_format'] = $requestData['starttxtpack' . $packageObj->id];
            $tmppackpaperpackage['exp_date_format'] = $requestData['exptxtpack' . $packageObj->id];
            $tmppackpaperpackage['extra_stamp'] = $requestData['extrastamp' . $packageObj->id];

            if ($request->hasFile('front_img' . $packageObj->id)) {
                $image = $request->file('front_img' . $packageObj->id);
                $name = "fr_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/package/'. $packageObj->id);
                $image->move($destinationPath, $name);

                $tmppackageinfo['front_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
                $tmppackpaperpackage['front_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
            }else{
                if(isset($packageinfos[$packageObj->id]->front_img)){
                    $tmppackpaperpackage['front_img'] = $packageinfos[$packageObj->id]->front_img;
                }
            }

            if ($request->hasFile('back_img' . $packageObj->id)) {
                $image = $request->file('back_img' . $packageObj->id);
                $name = "bk_".md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/package/' . $packageObj->id);
                $image->move($destinationPath, $name);

                $tmppackageinfo['back_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
                $tmppackpaperpackage['back_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
            } else {
                if (isset($packageinfos[$packageObj->id]->back_img)) {
                    $tmppackpaperpackage['back_img'] = $packageinfos[$packageObj->id]->back_img;
                }
            }

            $tmppackpaperpackage['front_stamp'] = $requestData['front_stamp' . $packageObj->id];
            $tmppackpaperpackage['front_locstamp'] = $requestData['front_locstamp' . $packageObj->id];
            $tmppackpaperpackage['back_stamp'] = $requestData['back_stamp' . $packageObj->id];
            $tmppackpaperpackage['back_locstamp'] = $requestData['back_locstamp' . $packageObj->id];
            
            $tmppackageinfo['front_stamp'] = $requestData['front_stamp' . $packageObj->id];
            $tmppackageinfo['front_locstamp'] = $requestData['front_locstamp' . $packageObj->id];
            $tmppackageinfo['back_stamp'] = $requestData['back_stamp' . $packageObj->id];
            $tmppackageinfo['back_locstamp'] = $requestData['back_locstamp' . $packageObj->id];

            $packageinfo = PackageInfo::where('packaging_id', $packageObj->id)->first();
            if(empty($packageinfo)){
                PackageInfo::create($tmppackageinfo);
            }else{
                $packageinfo->update($tmppackageinfo);
            }

            PackPaperPackage::create($tmppackpaperpackage);
        }
        return redirect('/pack_papers');
    }

    public function view($id){
        $packpaper = PackPaper::findOrFail($id);

        // return view('pack_papers.view', compact('packpaper'));
        return view('pack_papers.generateorder_pdf', compact('packpaper'));
    }
    
}
