<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;

use App\Models\Packaging;
use App\Models\PackageType;
use App\Models\Package;
use App\Models\Product;
use App\Models\Stamp;
use App\Models\PackMachine;
use App\Models\ProductGroup;
use App\Models\PackageExp;
use Illuminate\Http\Request;

class PackagingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */


	public function __construct()
	{
	    $this->middleware('auth');
	}

    public function index(Request $request)
    {
        $txtversion = $request->get('txtversion');
        $txtproductgroup = $request->get('txtproductgroup');
        $txtproduct = $request->get('txtproduct');
        $txtpackage = $request->get('txtpackage');
        $txtweight = $request->get('txtweight');
        $perPage = 25;

        $packagingObj = new Packaging(); 
        $packagingObj = $packagingObj->where('packagings.status','Active');

        

        if (!empty($txtpackage)) {
            $packagingObj = $packagingObj->with('package')->whereHas('package', function ($query) use ($txtpackage)  {
                $query->where('packages.name','like', '%' . $txtpackage . '%');
            });
        }

        if (!empty($txtversion)) {
            $packagingObj = $packagingObj->where('packagings.version', 'like', '%' . $txtversion . '%');
        }

        if (!empty($txtweight)) {
            $packagingsub = Packaging::where('packagings.inner_weight_g', $txtweight)
                ->orWhere('packagings.number_per_pack', $txtweight)
                ->orWhere('packagings.outer_weight_kg', $txtweight)->pluck('id');
            $packagingObj = $packagingObj->whereIn('packagings.id', $packagingsub);    
        }

        if (!empty($txtproduct)) {
            $productlist = Product::where('name', 'like', '%' . $txtproduct . '%')->pluck('id');
            $packagingObj = $packagingObj->whereIn('packagings.product_id', $productlist);
        }

        if (!empty($txtproductgroup)) {
            $productgrouplist = ProductGroup::where('name', 'like', '%' . $txtproductgroup . '%')->pluck('id');
            $productlistingroup = Product::whereIn('product_group_id',  $productgrouplist)->pluck('id');
            $packagingObj = $packagingObj->whereIn('packagings.product_id', $productlistingroup);
        }
        $packagings = $packagingObj->latest()->paginate($perPage);

        return view('packagings.index', compact('packagings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $productlist = Product::pluck('name', 'id');
        $packagetypelist = PackageType::all();
        $packageraw = Package::where('status','Active')->orderBy('name')->get();
        $packagearr = array();

        $stamplist = Stamp::pluck('name', 'id');
        $packmachinelist = PackMachine::pluck('name', 'id');

        foreach ($packageraw as $packageObj) {
            $packagearr[$packageObj->package_type_id][$packageObj->id] = $packageObj->name;
        }
        return view('packagings.create',compact('productlist', 'packagetypelist', 'packagearr', 'stamplist', 'packmachinelist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();

        $packageObj = Packaging::create($requestData);

        $packagetypelist = PackageType::all();        

        foreach ($packagetypelist as $packagetypeObj) {
            if(isset($requestData['package_id-' . $packagetypeObj->id])){
                $packageObj->package()->attach($requestData['package_id-' . $packagetypeObj->id]);
            }            
        }

        foreach ($requestData['stamp_id'] as $stampid) {
            $packageObj->stamp()->attach($stampid);
        }

        foreach ($requestData['pack_machine_id'] as $packmachineid) {
            $packageObj->packmachine()->attach($packmachineid);
        }

        return redirect('packagings')->with('flash_message', ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $packaging = Packaging::findOrFail($id);

        $packageexp = array();
        foreach ($packaging->packagestamptxt as $packagestampObj) {
            $packageexp[$packagestampObj->package_id] = $packagestampObj->stamp_type;
        }

        

        return view('packagings.show', compact('packaging', 'packageexp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $packaging = Packaging::findOrFail($id);
        $packageid = array();

        foreach ($packaging->package()->get() as $packageObj) {
            $packageid[$packageObj->package_type_id] = $packageObj->id;
        }

        $stampid = $packaging->stamp->pluck('id')->toArray();
        $packmachineid = $packaging->packmachine->pluck('id')->toArray();

        $productlist = Product::pluck('name', 'id');
        $packagetypelist = PackageType::all();
        $packageraw = Package::orderBy('name')->get();
        $packagearr = array();

        $stamplist = Stamp::pluck('name', 'id');
        $packmachinelist = PackMachine::pluck('name', 'id');

        foreach ($packageraw as $packageObj) {
            $packagearr[$packageObj->package_type_id][$packageObj->id] = $packageObj->name;
        }

        return view('packagings.edit', compact('packaging', 'productlist', 'packagetypelist', 'packagearr', 'stamplist', 'packmachinelist', 'packageid', 'stampid', 'packmachineid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();

        $requestData['inner_weight_g'] = floatval(str_replace(',','',$requestData['inner_weight_g']));
        $requestData['outer_weight_kg'] = floatval(str_replace(',', '', $requestData['outer_weight_kg']));
        $requestData['number_per_pack'] = intval(str_replace(',', '', $requestData['number_per_pack']));

        $packaging = Packaging::findOrFail($id);
        $packaging->update($requestData);

        $packaging->package()->detach();
        $packaging->stamp()->detach();
        $packaging->packmachine()->detach();

        $packagetypelist = PackageType::all();       

        foreach ($packagetypelist as $packagetypeObj) {
            if(isset($requestData['package_id-' . $packagetypeObj->id])){
                $packaging->package()->attach($requestData['package_id-' . $packagetypeObj->id]);
            }               
        }

        if (isset($requestData['stamp_id'])) {
            foreach ($requestData['stamp_id'] as $stampid) {
                $packaging->stamp()->attach($stampid);
            }
        }

        if(isset($requestData['pack_machine_id'])){
            foreach ($requestData['pack_machine_id'] as $packmachineid) {
                $packaging->packmachine()->attach($packmachineid);
            }
        }
        

        return redirect('packagings')->with('flash_message', ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Packaging::destroy($id);

        return redirect('packagings')->with('flash_message', ' deleted!');
    }

    public function clonedata($id){
        $clonedata = array();        

        $packaging = Packaging::findOrFail($id);
        $countproduct = Packaging::where('product_id', $packaging->product_id)->count();
        $clonedata['product_id'] = $packaging->product_id;
        $clonedata['start_date'] = $packaging->start_date;
        $clonedata['end_date'] = $packaging->end_date;
        $clonedata['version'] = date('ymd').'_'. str_pad($countproduct + 1, 4, '0', STR_PAD_LEFT);
        $clonedata['desc'] = $packaging->desc;
        $clonedata['inner_weight_g'] = $packaging->inner_weight_g;
        $clonedata['number_per_pack'] = $packaging->number_per_pack;
        $clonedata['outer_weight_kg'] = $packaging->outer_weight_kg;
        $clonedata['status'] = $packaging->status;

        $newid = Packaging::create($clonedata)->id;

        return redirect('packagings/' . $newid.'/edit')->with('flash_message', 'Clone Complete');
        
    }

    public function showfile($id){

        $package = Package::where('id',$id)->first();

        $files = array();

        if(!empty($package)){
            $path = $package->image;
            $files = Storage::disk('package')->allFiles($path);
        }
        return view('packagings.showfile',compact('files', 'id', 'package')); 
    }

    public function downloadfile($id,$key)
    {
        $package = Package::where('id', $id)->first();

        $files = array();

        if (!empty($package)) {
            $path = $package->image;
            $files = Storage::disk('package')->allFiles($path);

            if(isset($files[$key])){
                return Storage::disk('package')->download($files[$key]);
            }

        }
    }

    public function createwithadd()
    {
        $productlist = Product::orderBy('name', 'asc')->pluck('name', 'id');
        $packagetypelist = PackageType::all();
        $packagetypelist2 = PackageType::pluck('name', 'id');
        $packageraw = Package::where('status', 'Active')->orderBy('name')->get();
        $packagearr = array();

        $stamplist = Stamp::pluck('name', 'id');
        $packmachinelist = PackMachine::pluck('name', 'id');

        foreach ($packageraw as $packageObj) {
            $packagearr[$packageObj->package_type_id][$packageObj->id] = $packageObj->name;
        }
        return view('packagings.createwithadd', compact('productlist', 'packagetypelist', 'packagearr', 'stamplist', 'packmachinelist', 'packagetypelist2'));
    }

    public function createwithaddAction(Request $request)
    {
        $requestData = $request->all();
        $packageObj = Packaging::create($requestData);

        $loop = 0;
        foreach ($requestData['new-package-type'] as $newpackagetypeid) {
            
            $packageObj->package()->attach($newpackagetypeid);

            $tmppackagestamp = array();
            $tmppackagestamp['packaging_id'] = $packageObj->id;
            $tmppackagestamp['package_id'] = $newpackagetypeid;
            $tmppackagestamp['stamp_type'] = $requestData['exp-type'][$loop];

            PackageExp::create($tmppackagestamp);
            $loop++;
        }

        foreach ($requestData['stamp_id'] as $stampid) {
            $packageObj->stamp()->attach($stampid);
        }

        foreach ($requestData['pack_machine_id'] as $packmachineid) {
            $packageObj->packmachine()->attach($packmachineid);
        }

        return redirect('packagings')->with('flash_message', 'Add New Package Complete');
    }

    public function editwithadd($id)
    {
        $packaging = Packaging::findOrFail($id);
        $packageid = array();
        $packagetypelist2 = PackageType::pluck('name', 'id');
        $stampid = $packaging->stamp->pluck('id')->toArray();
        $packmachineid = $packaging->packmachine->pluck('id')->toArray();

        $productlist = Product::orderBy('name','asc')->pluck('name', 'id');
        $packagetypelist = PackageType::all();
        $packageraw = Package::orderBy('name')->get();
        $packagearr = array();
        $packageexp = array();
        foreach($packaging->packagestamptxt as $packagestampObj){
            $packageexp[$packagestampObj->package_id] = $packagestampObj->stamp_type;
        }



        $stamplist = Stamp::pluck('name', 'id');
        $packmachinelist = PackMachine::pluck('name', 'id');

        foreach ($packageraw as $packageObj) {
            $packagearr[$packageObj->package_type_id][$packageObj->id] = $packageObj->name;
        }

        return view('packagings.editwithadd', compact('id', 'packagetypelist2','packaging', 'productlist', 'packagetypelist', 'packagearr', 'stamplist', 'packmachinelist', 'packageid', 'stampid', 'packmachineid', 'packageexp'));
    }

    public function editwithaddAction(Request $request,$id)
    {
        $requestData = $request->all();

        $requestData['inner_weight_g'] = floatval(str_replace(',', '', $requestData['inner_weight_g']));
        $requestData['outer_weight_kg'] = floatval(str_replace(',', '', $requestData['outer_weight_kg']));
        $requestData['number_per_pack'] = intval(str_replace(',', '', $requestData['number_per_pack']));

        $packaging = Packaging::findOrFail($id);
        $packaging->update($requestData);

        $packaging->stamp()->detach();
        $packaging->packmachine()->detach();

        if(isset($requestData['new-package-type'])){
            $loop = 0;
            foreach ($requestData['new-package-type'] as $newpackagetypeid) {
                if(!empty($newpackagetypeid)){
                    $packaging->package()->attach($newpackagetypeid);

                    $tmppackagestamp = array();
                    $tmppackagestamp['packaging_id'] = $packaging->id;
                    $tmppackagestamp['package_id'] = $newpackagetypeid;
                    $tmppackagestamp['stamp_type'] = $requestData['exp-type'][$loop];

                    PackageExp::create($tmppackagestamp);
                   

                }
                $loop++;
            }
        }

        

        if (isset($requestData['stamp_id'])) {
            foreach ($requestData['stamp_id'] as $stampid) {
                $packaging->stamp()->attach($stampid);
            }
        }

        if (isset($requestData['pack_machine_id'])) {
            foreach ($requestData['pack_machine_id'] as $packmachineid) {
                $packaging->packmachine()->attach($packmachineid);
            }
        }
        

        return redirect('packagings')->with('flash_message', 'Add New Package Complete');
    }

    public function deletepackage($packaging_id,$package_type_id,$package_id){

        $packaging = Packaging::findOrFail($packaging_id);
        PackageExp::where('packaging_id', $packaging_id)->where('package_id', $package_id)->delete();
        $packaging->package()->detach($package_id);
        

        return redirect('packagings/editwithadd/' . $packaging_id )->with('flash_message', 'Clone Complete');
    }

    public function exportdoc($id){
        $packaging = Packaging::findOrFail($id);

        $packageexp = array();
        foreach ($packaging->packagestamptxt as $packagestampObj) {
            $packageexp[$packagestampObj->package_id] = $packagestampObj->stamp_type;
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

        $headerLStyleName = 'plStyle';
        $phpWord->addParagraphStyle($headerLStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spaceAfter' => 100));
        $headerRStyleName = 'pRStyle';
        $phpWord->addParagraphStyle($headerRStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT, 'spaceAfter' => 100));
        $headerCStyleName = 'pCStyle';
        $phpWord->addParagraphStyle($headerCStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));     
        // Adding an empty Section to the document...
        $section = $phpWord->addSection();

        $header = $section->addHeader();
        $header->firstPage();

        // Adding Text element to the Section having font styled by default...
        $header->addText('LACO.                                                                                                          Issue Date 12/05/16', array('name' => 'Tahoma', 'size' => 10), $headerLStyleName);
    //    / $header->addText('', array('name' => 'Tahoma', 'size' => 10), $headerRStyleName);
        $header->addText('Confirmation of Packing and Stamping of the Package', array('name' => 'Tahoma', 'size' => 12, 'bold' => true), $headerCStyleName);
        $header->addText('การยืนยันรูปแบบการบรรจุ และการพิมพ์บรรจุภัณฑ์', array('name' => 'Tahoma', 'size' =>12, 'bold' => true), $headerCStyleName);
        $header->addText('Document No. : F-QP-07/1                                                                                      Issue No.: 01', array('name' => 'Tahoma', 'size' => 10), $headerLStyleName);
        //$section->addText('', array('name' => 'Tahoma', 'size' => 10), $headerRStyleName);

        // Define table style arrays
        $styleTable = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 80, 'tblHeader' => true);
        $styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '000000', 'bgColor' =>'BFC9CA', 'tblHeader' => true);

        // Define cell style arrays
        $styleCell = array('valign' => 'center');
        $styleCellBTLR = array('valign' => 'center');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellColSpan3 = array('gridSpan' => 3, 'valign' => 'center');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue  = array('vMerge' => 'continue');

        // Define font style for first row
        $fontStyle = array('name' => 'Tahoma', 'bold' => true, 'align' => 'center');

        // Add table style
        $phpWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

        // Add table
        $table = $section->addTable('myOwnTableStyle');

        // Add row
        $rowheight = 200;
        $rowstyle = array('tblHeader' => true);
        $table->addRow($rowheight, $rowstyle);
        $col1 = 100;
        $col2 = 3500;
        $col3 = 5500;

        // Add cells
        $table->addCell($col1, $styleCell)->addText('No.', $fontStyle);
        $table->addCell($col2, $styleCell)->addText('Topic', $fontStyle);
        $table->addCell($col3, $styleCell)->addText('Description', $fontStyle);

        $fontstylecol1 = array('name' => 'Tahoma', 'size' => 10, 'bold' => true);
        $fontstylecol2 = array('name' => 'Tahoma', 'size' => 10, 'bold' => true);
        $fontstylecol3 = array('name' => 'Tahoma', 'size' => 10);

        $counter = 1;
        $table->addRow();
        $table->addCell($col1)->addText($counter.".", $fontstylecol1);
        $table->addCell($col2)->addText("Product Code SAP /โค้ดผลิตภัณฑ์", $fontstylecol2);
        $table->addCell($col3)->addText($packaging->product->name, $fontstylecol3);
        $counter++;

        $table->addRow();
        $table->addCell($col1)->addText($counter . ".", $fontstylecol1);
        $table->addCell($col2)->addText("Customer/ลูกค้า", $fontstylecol2);
        $table->addCell($col3)->addText($packaging->product->customer->desc, $fontstylecol3);
        $counter++;

        $table->addRow();
        $table->addCell($col1)->addText($counter . ".", $fontstylecol1);
        $table->addCell($col2)->addText(
        "Customer Code/ลูกค้า", $fontstylecol2);
        $table->addCell($col3)->addText($packaging->product->customer->
        name, $fontstylecol3);
        $counter++;

        $table->addRow();
        $table->addCell($col1)->addText($counter . ".", $fontstylecol1);
        $table->addCell($col2)->addText("Shelf Life/อายุการจัดเก็บ", $fontstylecol2);
        $table->addCell($col3)->addText($packaging->product->shelf_life, $fontstylecol3);

        $counter++;

        $table->addRow();
        $table->addCell($col1)->addText($counter . ".", $fontstylecol1);
        $table->addCell($col2)->addText("Weight/Package / น้ำหนักบรรจุต่อถุง (กรัม)", $fontstylecol2);
        $table->addCell($col3)->addText(round($packaging-> inner_weight_g, 2), $fontstylecol3);
        $counter++;

        $table->addRow();
        $table->addCell($col1)->addText($counter . ".", $fontstylecol1);
        $table->addCell($col2)->addText("Quantity/Carton / จำนวนถุงต่อกล่อง", $fontstylecol2);
        $table->addCell($col3)->addText($packaging->number_per_pack, $fontstylecol3);
        $counter++;

        $table->addRow();
        $table->addCell($col1)->addText($counter . ".", $fontstylecol1);
        $table->addCell($col2)->addText("Weight/Carton / น้ำหนักบรรจุต่อกล่อง (กิโลกรัม)", $fontstylecol2);
        $table->addCell($col3)->addText(round($packaging->outer_weight_kg,2), $fontstylecol3);
        
        foreach ($packaging->package()->get() as $subitem) {
            $counter++;
            $table->addRow();
            $table->addCell($col1)->addText($counter.".", $fontstylecol1);
            $table->addCell($col2)->addText("Code SAP ".$subitem->packagetype->name, $fontstylecol2);
            $table->addCell($col3)->addText($subitem->name, $fontstylecol3);
        
            //$counter++;
            //$table->addRow();
            //$table->addCell($col1)->addText($counter .".", $fontstylecol1);
            //$table->addCell($col2)->addText("Material &amp; Description/วัสดุ และรายละเอียด", $fontstylecol2);
            //$table->addCell($col3)->addText($subitem->desc, $fontstylecol3);
           $counter++;
             $table->addRow();
            $table->addCell($col1)->addText($counter .   ".", $fontstylecol1);
            $table->addCell($col2)->addText($subitem->packagetype->name." Size/ขนาด", $fontstylecol2);
            $table->addCell($col3)->addText($subitem->
            size, $fontstylecol3);
            $counter++;
            $table->addRow();
            $table->addCell($col1)->addText($counter .".", $fontstylecol1);
            $table->addCell($col2)->addText($subitem->packagetype->name . " Format of EXP.date or MFG.date / รูปแบบการพิมพ์วันผลิตหรือวันหมดอายุ", $fontstylecol2);
            if(isset($packageexp[$subitem->id])){
                $table->addCell($col3)->addText($packageexp[$subitem->id], $fontstylecol3);
            }else{
                $table->addCell($col3)->addText('-', $fontstylecol3);
            }   
            
            $counter++;

            
            //$files = Storage::disk('package')->allFiles($path);
           // dd($fileurl);
            $table->addRow();
            $table->addCell($col1)->addText($counter .
            ".", $fontstylecol1);
            $table->addCell($col2 +$col3, $cellColSpan)->addText(
                $subitem->packagetype->name . " Picture of packaging artwork and stamping position and style
/รูปภาพและตำแหน่งการพิมพ์บนบรรจุภัณฑ์: ",
                $fontstylecol2
            );

            $path = $subitem->image;
            $isexists = Storage::disk('package')->exists($path . '\\pattern.jpg');
            if($isexists ){
            $filecontent = Storage::disk('package')->get($path . '\\pattern.jpg');

           
                Storage::put('public\\images\\' . $path . '.jpg', $filecontent);

                $table->addRow();
                $table->addCell($col1+$col2+$col3, $cellColSpan3)->addImage(
                'storage\\images\\'.$path.'.jpg',
                array(
                    'width'         => 450,
                    'marginTop'     => -2,
                    'marginLeft'    => -2,
                    'wrappingStyle' => 'behind'
                ));
            }
            $counter++;

            
        }
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(10);
        $myTextElement = $section->addText(' ');
        $myTextElement->setFontStyle($fontStyle);
        $myTextElement = $section->addText(' ');
        $myTextElement->setFontStyle($fontStyle);
        $myTextElement = $section->addText(' ');
        $myTextElement->setFontStyle($fontStyle);
        $myTextElement = $section->addText(' ');
        $myTextElement->setFontStyle($fontStyle);
        $myTextElement = $section->addText('                                                                         Approve By _______________________________');
        $myTextElement->setFontStyle($fontStyle);

        $myTextElement = $section->addText('                                                                         Date:_____'.date('d/m/Y').'________________');
        $myTextElement->setFontStyle($fontStyle);
        $myTextElement = $section->addText('                                                                                      Customer or Representative      ');
        $myTextElement->setFontStyle($fontStyle);

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        //dd(public_path('storage/doc/' . $packaging->version . '_' . $packaging->product->name . '.docx'));
        $objWriter->save('storage\\docs\\' . $packaging->version.'_'.$packaging->product->name.'.docx');

        return Storage::disk('public')->download('docs/' . $packaging->version . '_' . $packaging->product->name . '.docx');
    }

    public function exportexcel($id)
    {
        $packaging = Packaging::findOrFail($id);

        return view('packagings.exportexcel',compact('packaging'));
    }
}
