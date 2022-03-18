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
use App\Models\Product;

use Maatwebsite\Excel\Facades\Excel;

class PackPapersController extends Controller
{
    public function index(){
        $paperpacks = PackPaper::paginate(25);
        return view('pack_papers.index', compact('paperpacks'));
    }

    public function generateOrder($id,$lot){
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

    public function generateOrderAction(Request $request, $id,$lot)
    {
        $requestData = $request->all();
        // dd($requestData);          

        $packaging = Packaging::findOrFail($id);

        // dd($packaging->product_id);
        $pd = Product::findOrFail($packaging->product_id);
        $tmppd['weight_with_bag'] = $requestData['weight_with_bag'];
        $ck = $pd->update($tmppd);
        // if($ck) dd('T');
        // else dd('F');


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
        $tmppaperpack['pallet_base'] = $requestData['pallet_base'];
        $tmppaperpack['pallet_low'] = $requestData['pallet_low'];
        $tmppaperpack['pallet_height'] = $requestData['pallet_height'];
        $tmppaperpack['status'] = 'Active';
        
        $tmpproductinfo = array();
        $tmpproductinfo['packaging_id'] = $id;
        $tmpproductinfo['product_fac'] = $requestData['product_fac'];
        $tmpproductinfo['pallet_base'] = $requestData['pallet_base'];
        $tmpproductinfo['pallet_low'] = $requestData['pallet_low'];
        $tmpproductinfo['pallet_height'] = $requestData['pallet_height'];



        if ($request->hasFile('cable_file')) {
            $image = $request->file('cable_file');
            $name = "cb_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/packaging/' . $id);
            $image->move($destinationPath, $name);

            $tmpproductinfo['cable_img'] = 'images/packaging/' . $id  . "/" . $name;
            $tmppaperpack['cable_img'] = 'images/packaging/' . $id  . "/" . $name;
        }else{
            if(isset($productinfo->cable_img)){
                if(isset($requestData['img_cable'])){
                    // dd('save img');
                    $tmppaperpack['cable_img'] = $productinfo->cable_img;
                
                }
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

        // dd($tmppaperpack);

        $packpaperObj = PackPaper::create($tmppaperpack);

        $productinfo = ProductInfo::where('packaging_id', $id)->first();
        if (empty($productinfo)) {
            ProductInfo::create($tmpproductinfo);
        } else {
            $productinfo->update($tmpproductinfo);
        }

        // for ($setloop=1; $setloop <= $set; $setloop++) {
        //     $tmppaperpackd = array();
        //     $tmppaperpackd['pack_paper_id'] = $packpaperObj->id; 
        //     $tmppaperpackd['pack_date'] = $requestData['pack_date'. $setloop]; 
        //     $tmppaperpackd['exp_date'] = $requestData['exp_date' . $setloop]; 
        //     $tmppaperpackd['all_weight'] = $requestData['all_weight' . $setloop]; 
        //     $tmppaperpackd['all_bpack'] = $requestData['all_bpack' . $setloop]; 
        //     $tmppaperpackd['cablecover'] = $requestData['cablecover' . $setloop];

        //     PackPaperD::create($tmppaperpackd);
        // }

        for ($lotloop=1; $lotloop <= $lot; $lotloop++) {
            $tmppaperpackd = array();
            $tmppaperpackd['pack_paper_id'] = $packpaperObj->id; 
            $tmppaperpackd['pack_date'] = $requestData['packdate'. $lotloop]; 
            $tmppaperpackd['exp_date'] = $requestData['expdate' . $lotloop]; 
            $all_bpack = $requestData['tbox' . $lotloop]-$requestData['fbox' . $lotloop];
            $all_weight = $packaging->outer_weight_kg * $all_bpack;
            $tmppaperpackd['all_weight'] = $all_weight; 
            $tmppaperpackd['all_bpack'] = $all_bpack; 
            $tmppaperpackd['cablecover'] = $requestData['cablecover' . $lotloop];

            PackPaperD::create($tmppaperpackd);
        }

        for ($lotloop = 1; $lotloop <= $lot; $lotloop++) {
            $tmppaperpacklot = array();
            $tmppaperpacklot['pack_paper_id'] = $packpaperObj->id;
            $tmppaperpacklot['pack_date'] = $requestData['packdate' . $lotloop];
            $tmppaperpacklot['exp_date'] = $requestData['expdate' . $lotloop];
            $tmppaperpacklot['lot'] = $requestData['lot' . $lotloop];            
            $tmppaperpacklot['pattern_pallet'] = $requestData['pattern_pallet' . $lotloop];
            $tmppaperpacklot['frombox'] = $requestData['fbox' . $lotloop];
            $tmppaperpacklot['tobox'] = $requestData['tbox' . $lotloop];
            $tmppaperpacklot['nbox'] = $requestData['nbox' . $lotloop];
            $tmppaperpacklot['nbag'] = $requestData['nbag' . $lotloop];
            $tmppaperpacklot['pweight'] = $requestData['pweight' . $lotloop];
            $tmppaperpacklot['fweight'] = $requestData['fweight' . $lotloop];
            $tmppaperpacklot['pallet'] = $requestData['pallet' . $lotloop];
            $tmppaperpacklot['pbag'] = $requestData['pbag' . $lotloop];
            $tmppaperpacklot['note'] = $requestData['note' . $lotloop];             
            $tmppaperpacklot['cablecover'] = $requestData['cablecover' . $lotloop];

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
                // echo 'front_img';
                $image = $request->file('front_img' . $packageObj->id);
                $name = "fr_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/package/'. $packageObj->id);
                $image->move($destinationPath, $name);

                $tmppackageinfo['front_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
                $tmppackpaperpackage['front_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
            }else{
                // echo 'no front_img';
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

            // dd($tmppackpaperpackage);
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
        $weight_per_box = $packpaper->packaging->outer_weight_kg;
        $p_date = array();
        $paked = array();
        // $packpaper->exp_month;
        foreach($packpaper->packpaperdlots as $pack_lot){
            if(empty($tbl_2[$pack_lot->pack_date][$pack_lot->exp_date]['num_box']))
                $tbl_2[$pack_lot->pack_date][$pack_lot->exp_date]['num_box'] = $pack_lot->nbox;
            else
                $tbl_2[$pack_lot->pack_date][$pack_lot->exp_date]['num_box'] += $pack_lot->nbox;
                
            if(empty($tbl_2[$pack_lot->pack_date][$pack_lot->exp_date]['lot']))
                $tbl_2[$pack_lot->pack_date][$pack_lot->exp_date]['lot'] = $pack_lot->lot;
            else
                $tbl_2[$pack_lot->pack_date][$pack_lot->exp_date]['lot'] .= ','.$pack_lot->lot;
            
            array_push($paked,$pack_lot->pack_date);
        }   
        $paked = array_unique($paked); 
        // dd($p_date);
        foreach($paked as $packd){
            $p_date[] = $packd;
        }    
        // dd($p_date);

        // return view('pack_papers.view', compact('packpaper'));
        return view('pack_papers.generateorder_pdf', compact('packpaper', 'tbl_2','p_date'));
    }
    
    public function edit_genOrder($id,$lot){
        $packpaper = PackPaper::findOrFail($id);

        $productinfo = ProductInfo::where('packaging_id',$packpaper->packaging_id)->first();
        $packageexp = array();
        $packagelist = array();
        foreach ($packpaper->packaging->packagestamptxt as $packagestampObj) {           
            $packageexp[$packagestampObj->package_id] = $packagestampObj->stamp_type;
        }

        $package_lot = array();
        foreach($packpaper->packpaperdlots as $packageObj){
            $package_lot[] = $packageObj;
        }
        
        $cablecoverlist = array(
            'ไม่รัดสาย' => 'ไม่รัดสาย',
            'สายรัดสีแดง' => 'สายรัดสีแดง',
            'สายรัดสีน้ำเงิน' => 'สายรัดสีน้ำเงิน',
            'สายรัดสีบรอนซ์' => 'สายรัดสีบรอนซ์'
        );
        
        return view('pack_papers.edit', compact('lot','packpaper','cablecoverlist','package_lot','packageexp'));
    }

    public function update_genOrder(Request $request, $id, $lot){
        $requestData = $request->all();

        // dd($requestData);  
        $packpaper = PackPaper::findOrFail($id);
        $packaging_id = $packpaper->packaging_id;
        $packaging = Packaging::findOrFail($packaging_id);

        // แก้ไขแล้วให้มีผลต่อการเพิ่มในครั้งหน้า
        //น้ำหนักชั่งรวมถุง
        $pd = Product::findOrFail($packaging->product_id);
        $tmppd['weight_with_bag'] = $requestData['weight_with_bag'];
        $pd->update($tmppd);
        
        $tmppaperpack = array();
        // $tmppaperpack['packaging_id'] = $id;
        $tmppaperpack['order_no'] = $requestData['order_no'];
        $tmppaperpack['exp_month'] = $requestData['exp_month'];
        $tmppaperpack['weight_with_bag'] = $requestData['weight_with_bag'];
        $tmppaperpack['loading_date'] = $requestData['loading_date'];
        $tmppaperpack['product_fac'] = $requestData['product_fac'];         
        $tmppaperpack['pallet_base'] = $requestData['pallet_base'];
        $tmppaperpack['pallet_low'] = $requestData['pallet_low'];
        $tmppaperpack['pallet_height'] = $requestData['pallet_height'];    
        // $tmppaperpack['status'] = 'Active';
        
        //แก้ไขแล้วให้มีผลต่อการเพิ่มในครั้งหน้า
        //ProductInfo update img
        $tmpproductinfo = array();
        // $tmpproductinfo['packaging_id'] = $id;   
        $tmpproductinfo['product_fac'] = $requestData['product_fac'];
        $tmpproductinfo['pallet_base'] = $requestData['pallet_base'];
        $tmpproductinfo['pallet_low'] = $requestData['pallet_low'];
        $tmpproductinfo['pallet_height'] = $requestData['pallet_height'];  
        $productinfo = ProductInfo::where('packaging_id', $packaging_id)->first();


        
        if ($request->hasFile('cable_file')) {
            $image = $request->file('cable_file');
            $name = "cb_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/packaging/' . $id);
            $image->move($destinationPath, $name);

            $tmpproductinfo['cable_img'] = 'images/packaging/' . $id  . "/" . $name;
            $tmppaperpack['cable_img'] = 'images/packaging/' . $id  . "/" . $name;
        }else{
            if(isset($productinfo->cable_img)){
                if(isset($requestData['img_cable'])){
                    // dd('save img');
                    $tmppaperpack['cable_img'] = $productinfo->cable_img;
                }else{
                    $tmppaperpack['cable_img'] = null;
                }
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

        $packpaper->update($tmppaperpack);

        // $productinfo = ProductInfo::where('packaging_id', $packaging_id)->first();
        $productinfo->update($tmpproductinfo);

        PackPaperD::where('pack_paper_id', $id)->delete();
        for ($lotloop=0; $lotloop < $lot; $lotloop++) {
            $tmppaperpackd = array();
            $tmppaperpackd['pack_paper_id'] = $id; 
            $tmppaperpackd['pack_date'] = $requestData['packdate'. $lotloop]; 
            $tmppaperpackd['exp_date'] = $requestData['expdate' . $lotloop]; 
            $all_bpack = $requestData['tbox' . $lotloop]-$requestData['fbox' . $lotloop];
            $all_weight = $packaging->outer_weight_kg * $all_bpack;
            $tmppaperpackd['all_weight'] = $all_weight; 
            $tmppaperpackd['all_bpack'] = $all_bpack; 
            $tmppaperpackd['cablecover'] = $requestData['cablecover' . $lotloop];

            PackPaperD::create($tmppaperpackd);
        }

        PackPaperLot::where('pack_paper_id', $id)->delete();
        for ($lotloop = 0; $lotloop < $lot; $lotloop++) {
            $tmppaperpacklot = array();
            $tmppaperpacklot['pack_paper_id'] = $id;
            $tmppaperpacklot['pack_date'] = $requestData['packdate' . $lotloop];
            $tmppaperpacklot['exp_date'] = $requestData['expdate' . $lotloop];
            $tmppaperpacklot['lot'] = $requestData['lot' . $lotloop];
            $tmppaperpacklot['pattern_pallet'] = $requestData['pattern_pallet' . $lotloop];
            $tmppaperpacklot['frombox'] = $requestData['fbox' . $lotloop];
            $tmppaperpacklot['tobox'] = $requestData['tbox' . $lotloop];
            $tmppaperpacklot['nbox'] = $requestData['nbox' . $lotloop];
            $tmppaperpacklot['nbag'] = $requestData['nbag' . $lotloop];
            $tmppaperpacklot['pweight'] = str_replace(',', '', $requestData['pweight' . $lotloop]);
            $tmppaperpacklot['fweight'] = str_replace(',', '',$requestData['fweight' . $lotloop]);
            $tmppaperpacklot['pallet'] = $requestData['pallet' . $lotloop];
            $tmppaperpacklot['pbag'] = $requestData['pbag' . $lotloop];
            if(!empty($requestData['note' . $lotloop]))     $tmppaperpacklot['note'] = $requestData['note' . $lotloop]; 
            $tmppaperpacklot['cablecover'] = $requestData['cablecover' . $lotloop];
            // dd($tmppaperpacklot);
            PackPaperLot::create($tmppaperpacklot);
        }
        
        foreach ($packpaper->packpaperpackages as $packageObj){            
            $tmppackpaperpackage = array();
            // $tmppackpaperpackage['pack_paper_id'] = $packpaperObj->id;
            // $tmppackpaperpackage['packaging_id'] = $packageObj->id;
            $tmppackpaperpackage['lot'] = $requestData['lottxt' . $packageObj->id];
            
            $tmppackageinfo = array();

            // $tmppackageinfo['packaging_id'] = $packageObj->id;
            $tmppackageinfo['pack_date_format'] = $requestData['starttxtpack' . $packageObj->id];
            $tmppackageinfo['exp_date_format'] = $requestData['exptxtpack' . $packageObj->id];
            $tmppackageinfo['extra_stamp'] = $requestData['extrastamp' . $packageObj->id];

            $tmppackpaperpackage['pack_date_format'] = $requestData['starttxtpack' . $packageObj->id];
            $tmppackpaperpackage['exp_date_format'] = $requestData['exptxtpack' . $packageObj->id];
            $tmppackpaperpackage['extra_stamp'] = $requestData['extrastamp' . $packageObj->id];

            if ($request->hasFile('front_img' . $packageObj->id)) {
                // echo 'front_img';
                $image = $request->file('front_img' . $packageObj->id);
                $name = "fr_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/package/'. $packageObj->id);
                $image->move($destinationPath, $name);

                $tmppackageinfo['front_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
                $tmppackpaperpackage['front_img'] = 'images/package/' . $packageObj->id  . "/" . $name;
            }else{
                // echo 'no front_img';
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

            // dd($tmppackpaperpackage);
            $packageinfo = PackageInfo::where('packaging_id', $packageObj->packaging_id)->first();
            $packageinfo->update($tmppackageinfo);
            // PackPaperPackage::create($tmppackpaperpackage);
            $pack_paper_package = PackPaperPackage::where('id', $packageObj->id)->first();
            $pack_paper_package->update($tmppackpaperpackage);
        }
        return redirect('/pack_papers');
    }
    
    public function delete_genOrder($id){
        $packpaper = PackPaperD::where('pack_paper_id',$id)->delete();
        $packpaper = PackPaperLot::where('pack_paper_id',$id)->delete();     
        $packpaper = PackPaperPackage::where('pack_paper_id',$id)->delete();
        $packpaper = PackPaper::where('id',$id)->delete();

        return redirect('/pack_papers')->with('flash_message', ' deleted!');
    }
}
