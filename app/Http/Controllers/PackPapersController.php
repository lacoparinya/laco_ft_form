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
use App\Models\Package;

use Maatwebsite\Excel\Facades\Excel;

class PackPapersController extends Controller
{
    public function index(Request $request){
        // dd($request->get('search'));
        $search = "";
        $paperpacks = new PackPaper;
        $paperpacks = $paperpacks->join('package_db.dbo.packagings', 'pack_papers.packaging_id', '=', 'package_db.dbo.packagings.id');
        $paperpacks = $paperpacks->join('package_db.dbo.products', 'package_db.dbo.packagings.product_id', '=', 'package_db.dbo.products.id');
        $paperpacks = $paperpacks->where('pack_papers.status','Active');
        if(!empty($request->get('search'))){
            $search = $request->get('search');
            $paperpacks = $paperpacks->where('pack_papers.packaging_id', '=', $request->get('search'));
        }
        $paperpacks = $paperpacks->select('pack_papers.id', 'package_db.dbo.products.name', 'pack_papers.order_no', 'pack_papers.revise_version', 'pack_papers.created_at');
        $paperpacks = $paperpacks->groupBy('pack_papers.id', 'package_db.dbo.products.name', 'pack_papers.order_no', 'pack_papers.revise_version', 'pack_papers.created_at');
        $paperpacks = $paperpacks->orderBy('pack_papers.created_at', 'DESC');
        $paperpacks = $paperpacks->paginate(25);

        $to_search = new PackPaper;
        $to_search = $to_search->join('package_db.dbo.packagings', 'pack_papers.packaging_id', '=', 'package_db.dbo.packagings.id');
        $to_search = $to_search->join('package_db.dbo.products', 'package_db.dbo.packagings.product_id', '=', 'package_db.dbo.products.id');
        $to_search = $to_search->where('pack_papers.status','Active');
        $to_search = $to_search->select('pack_papers.packaging_id', 'package_db.dbo.products.name');
        $to_search = $to_search->groupBy('pack_papers.packaging_id', 'package_db.dbo.products.name');
        $to_search = $to_search->get();
        // dd($to_search);        

        return view('pack_papers.index', compact('paperpacks', 'to_search','search'));
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
            '???????????????????????????' => '???????????????????????????',
            '?????????????????????????????????' => '?????????????????????????????????',
            '?????????????????????????????????????????????' => '?????????????????????????????????????????????',
            '??????????????????????????????????????????' => '??????????????????????????????????????????'
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
        if(isset($requestData['pack_thai_year'])){
            $tmppaperpack['pack_thai_year'] = $requestData['pack_thai_year'];
        }else{
            $tmppaperpack['pack_thai_year'] = null;
        }
        $tmppaperpack['plan_version'] = $requestData['plan_version'];
        $tmppaperpack['revise_version'] = 0;
        $tmppaperpack['status'] = 'Active';        
        
        $tmpproductinfo = array();
        $tmpproductinfo['packaging_id'] = $id;
        $tmpproductinfo['product_fac'] = $requestData['product_fac'];
        $tmpproductinfo['pallet_base'] = $requestData['pallet_base'];
        $tmpproductinfo['pallet_low'] = $requestData['pallet_low'];
        $tmpproductinfo['pallet_height'] = $requestData['pallet_height'];
        if(isset($requestData['pack_thai_year'])){
            $tmpproductinfo['pack_thai_year'] = $requestData['pack_thai_year'];
        }else{
            $tmpproductinfo['pack_thai_year'] = null;
        }


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
        if ($request->hasFile('artwork_file')) {
            $image = $request->file('artwork_file');
            $name = "aw_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/packaging/' . $id);
            $image->move($destinationPath, $name);

            $tmpproductinfo['artwork_img'] = 'images/packaging/' . $id  . "/" . $name;
            $tmppaperpack['artwork_img'] = 'images/packaging/' . $id  . "/" . $name;
        }else{
            if (isset($productinfo->artwork_img)) {
                $tmppaperpack['artwork_img'] = $productinfo->artwork_img;
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
        // dd($packpaper);
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

        // return view('pack_papers.view', compact('packpaper'));
        return view('pack_papers.generateorder_pdf', compact('packpaper', 'tbl_2','p_date'));
    }
    
    public function edit_genOrder($id,$lot){
        $packpaper = PackPaper::findOrFail($id);

        // $productinfo = ProductInfo::where('packaging_id',$packpaper->packaging_id)->first();
        $productinfo = ProductInfo::where('packaging_id',$packpaper->id)->first();
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
            '???????????????????????????' => '???????????????????????????',
            '?????????????????????????????????' => '?????????????????????????????????',
            '?????????????????????????????????????????????' => '?????????????????????????????????????????????',
            '??????????????????????????????????????????' => '??????????????????????????????????????????'
        );
        $relate_id = array();
        if(!empty($packpaper->relation_id)){
            $relate_id = PackPaper::WhereNotIn('id',[$id])->where('relation_id',$packpaper->relation_id)->orWhere('id',$packpaper->relation_id)->orderBy('revise_version','DESC')->get();
        }
        return view('pack_papers.edit', compact('lot','packpaper','cablecoverlist','package_lot','packageexp','relate_id'));
    }

    public function update_genOrder(Request $request, $id, $lot){
        $requestData = $request->all();

        // dd($requestData);  
        $packpaper = PackPaper::findOrFail($id);
        $tmpstatus['status'] = 'Inactive';
        $packpaper->update($tmpstatus);

        $packaging_id = $packpaper->packaging_id;
        $packaging = Packaging::findOrFail($packaging_id);

        // ??????????????????????????????????????????????????????????????????????????????????????????????????????????????????
        //???????????????????????????????????????????????????
        $pd = Product::findOrFail($packaging->product_id);
        $tmppd['weight_with_bag'] = $requestData['weight_with_bag'];
        $pd->update($tmppd);
        // dd($packaging_id);
        $tmppaperpack = array();
        $tmppaperpack['packaging_id'] = $packaging_id;
        $tmppaperpack['order_no'] = $requestData['order_no'];
        $tmppaperpack['exp_month'] = $requestData['exp_month'];
        $tmppaperpack['weight_with_bag'] = $requestData['weight_with_bag'];
        $tmppaperpack['loading_date'] = $requestData['loading_date'];
        $tmppaperpack['product_fac'] = $requestData['product_fac'];         
        $tmppaperpack['pallet_base'] = $requestData['pallet_base'];
        $tmppaperpack['pallet_low'] = $requestData['pallet_low'];
        $tmppaperpack['pallet_height'] = $requestData['pallet_height'];            
        if(isset($requestData['pack_thai_year'])){
            $tmppaperpack['pack_thai_year'] = $requestData['pack_thai_year'];
        }else{
            $tmppaperpack['pack_thai_year'] = null;
        }
        // dd($requestData['revise_version']);
        if(!empty($packpaper->relation_id)){
            $tmppaperpack['relation_id'] = $packpaper->relation_id;
        }else{
            $tmppaperpack['relation_id'] = $id;
        }        
        $tmppaperpack['revise_version'] = $requestData['revise_version'];        
        $tmppaperpack['plan_version'] = $requestData['plan_version'];  
        $tmppaperpack['status'] = 'Active';
        
        //??????????????????????????????????????????????????????????????????????????????????????????????????????????????????
        //ProductInfo update img
        $tmpproductinfo = array();
        // $tmpproductinfo['packaging_id'] = $id;   
        $tmpproductinfo['product_fac'] = $requestData['product_fac'];
        $tmpproductinfo['pallet_base'] = $requestData['pallet_base'];
        $tmpproductinfo['pallet_low'] = $requestData['pallet_low'];
        $tmpproductinfo['pallet_height'] = $requestData['pallet_height'];         
        if(isset($requestData['pack_thai_year'])){
            $tmpproductinfo['pack_thai_year'] = $requestData['pack_thai_year'];
        }else{
            $tmpproductinfo['pack_thai_year'] = null;
        }          
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
        if ($request->hasFile('artwork_file')) {
            $image = $request->file('artwork_file');
            $name = "aw_" . md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/packaging/' . $id);
            $image->move($destinationPath, $name);

            $tmpproductinfo['artwork_img'] = 'images/packaging/' . $id  . "/" . $name;
            $tmppaperpack['artwork_img'] = 'images/packaging/' . $id  . "/" . $name;
        }else{
            if (isset($productinfo->artwork_img)) {
                $tmppaperpack['artwork_img'] = $productinfo->artwork_img;
            }
        }
        // dd($tmppaperpack);
        $new_id = PackPaper::create($tmppaperpack)->id;
        // $packpaper->update($tmppaperpack);
        // dd($new_id);
        // $productinfo = ProductInfo::where('packaging_id', $packaging_id)->first();
        $productinfo->update($tmpproductinfo);

        // PackPaperD::where('pack_paper_id', $id)->delete();
        for ($lotloop=0; $lotloop < $lot; $lotloop++) {
            $tmppaperpackd = array();
            $tmppaperpackd['pack_paper_id'] = $new_id; 
            $tmppaperpackd['pack_date'] = $requestData['packdate'. $lotloop]; 
            $tmppaperpackd['exp_date'] = $requestData['expdate' . $lotloop]; 
            $all_bpack = $requestData['tbox' . $lotloop]-$requestData['fbox' . $lotloop];
            $all_weight = $packaging->outer_weight_kg * $all_bpack;
            $tmppaperpackd['all_weight'] = $all_weight; 
            $tmppaperpackd['all_bpack'] = $all_bpack; 
            $tmppaperpackd['cablecover'] = $requestData['cablecover' . $lotloop];

            PackPaperD::create($tmppaperpackd);
        }

        // PackPaperLot::where('pack_paper_id', $id)->delete();
        for ($lotloop = 0; $lotloop < $lot; $lotloop++) {
            $tmppaperpacklot = array();
            $tmppaperpacklot['pack_paper_id'] = $new_id;
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
            $tmppackpaperpackage['pack_paper_id'] = $new_id;
            $tmppackpaperpackage['packaging_id'] = $packageObj->packaging_id;
            // dd($packageObj->front_img);
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
                // if(isset($packageinfos[$packageObj->id]->front_img)){
                if(isset($packageObj->front_img)){
                    $tmppackpaperpackage['front_img'] = $packageObj->front_img;
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
                // if (isset($packageinfos[$packageObj->id]->back_img)) {
                if (isset($packageObj->back_img)) {
                    $tmppackpaperpackage['back_img'] = $packageObj->back_img;
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
            // $pack_paper_package = PackPaperPackage::where('id', $packageObj->id)->first();
            // $pack_paper_package->update($tmppackpaperpackage);
            PackPaperPackage::create($tmppackpaperpackage);
        }
        return redirect('/pack_papers');
    }
    
    public function delete_genOrder($id){        
        // $packpaper = PackPaperD::where('pack_paper_id',$id)->delete();
        // $packpaper = PackPaperLot::where('pack_paper_id',$id)->delete();     
        // $packpaper = PackPaperPackage::where('pack_paper_id',$id)->delete();
        // $packpaper = PackPaper::where('id',$id)->delete();
        
        $packpaper = PackPaper::where('id',$id);
        $tmpstatus['status'] = 'Inactive';
        $packpaper->update($tmpstatus);

        return redirect('/pack_papers')->with('flash_message', ' deleted!');
    }

    public static function extract_int($str){   //?????????????????? static ????????????????????????????????????????????????
        $to_s = "";
        // $str = $packageObj->pack_date_format;
        // // // echo $str.'--';
        $patt = '/[^0-9]*([0-9]+)[^0-9]*/';
        $a = preg_match($patt,$str,$regs);
        // // // $a = trim(str_replace(range(0,9),'',$arr_pack[($i+$p)]->pack_date_format)); //??????????????????????????????????????????
        // // // echo $regs[1].'--'; //????????????????????????????????????????????????????????????????????????????????????
        // // // print_r($regs);   //0=$str, 1=??????????????????????????????????????????
        if(!empty($regs[1])){
            $reg_len = strlen($regs[1]);
            $b = substr($str, $reg_len, strlen($str));
            // echo $b.'--';
            // for($i=0; $i<$reg_len; $i++){
            //     $to_s .='X';
            // }
            $to_s = 'X'.$b;
        }else{
            $to_s = $str;
        }
        // preg_match('/[^0-9]*([0-9]+)[^0-9]*/', $str, $regs);
        return $to_s;
    }

    public static function format_date($fdate,$date,$ythai){   //?????????????????? static ????????????????????????????????????????????????
        // dd($fdate.', '.$date.', '.$ythai.'--');
        // $replace = str_replace('No.','' ,str_replace('LOT','' ,$fdate));
        // $replace1 = str_replace('No.','' ,str_replace('LOT','' ,str_replace('DD','*', str_replace('MM','*', str_replace('YY','*' ,$fdate)))));   

        $replace = str_replace('No.','' ,str_replace('LOT','' ,$fdate));
        $replace1 = str_replace('No.','' ,str_replace('LOT','' ,str_replace('DD','*', str_replace('MM','*', str_replace('YY','*' ,$fdate)))));

        $first_d = strpos($replace1,'*');
        $last_d = strrpos($replace1,'*');
        $replace2 = explode('*',$replace1); //????????????????????? YYYY ?????????????????? * 2 ?????????
        $first_text = substr($replace1,0,$first_d);
        $last_text = substr($replace1,($last_d+1),strlen($replace1));
        $point_len = strlen($replace)-(strlen($first_text)+strlen($last_text));
        $date_text = substr($replace,strlen($first_text),$point_len); 
        // $date_text = 'MM.DD.YY'; 
        $replace_d = date("d", strtotime($date));
        $replace_m = date("m", strtotime($date));
        $ex_y = explode('Y',$date_text);
        if(count($ex_y)==5){
            if(empty($ythai)){
                $replace_y = date("Y", strtotime($date));
            }else{
                $replace_y = date("Y", strtotime($date))+543;
            }
            $phpformat = str_replace('No.','' ,str_replace('LOT','' ,str_replace('DD',$replace_d ,str_replace('MM',$replace_m ,str_replace('YYYY',$replace_y ,$fdate)))));
        }elseif(count($ex_y)==3){
            if(empty($ythai)){
                $replace_y = substr(date("Y", strtotime($date)),2,2);
            }else{
                $replace_y = substr((date("Y", strtotime($date))+543),2,2);
            }
            $phpformat = str_replace('No.','' ,str_replace('LOT','' ,str_replace('DD',$replace_d ,str_replace('MM',$replace_m ,str_replace('YY',$replace_y ,$fdate)))));
        }else{
            $phpformat = '????????????????????????????????????????????????';  //?????????????????????????????? DD, ???????????????????????????????????? MM, ?????? ????????????????????? YYYY ???????????? YY
        }
        return $phpformat;
    }

    public static function check_null($chk){   //?????????????????? static ????????????????????????????????????????????????
        if(empty($chk)){
            $check_val = '';
        }else{
            $check_val = $chk;
        }
        return $check_val;
    }
}
