<?php

namespace App\Http\Controllers\Backend;
 
use App\Models\Brand;
use Illuminate\Http\Request;
use App\BrandService;
use App\BrandRepositoryInterface;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandController extends Controller
{
    protected $brandRepo;
    protected $brandService;

    public function __construct(BrandRepositoryInterface $brandRepo, BrandService $brandService)
    {
        $this->brandRepo = $brandRepo;
        $this->brandService = $brandService;
    }

    public function index()
    {
        $brand = $this->brandRepo->all();
        return view('admin.brand.index', compact('brand'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(BrandRequest $request)
    {
        $data = ['name' => $request->name];

        if ($request->file('image')) {
            $data['image'] = $this->brandService->handleImage($request->file('image'));
        }

        $this->brandRepo->create($data);

        return redirect()->route('brand.index')->with('message', 'Brand Inserted Successfully');
    }

    public function edit($id)
    {
        $brand = $this->brandRepo->find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(BrandRequest $request, $id)
    {
        $brand = $this->brandRepo->find($id);
        $data = ['name' => $request->name];

        if ($request->file('image')) {
            $data['image'] = $this->brandService->handleImage($request->file('image'), $brand->image);
        }

        $this->brandRepo->update($id, $data);

        return redirect()->route('brand.index')->with('message', 'Brand Updated Successfully');
    }

    public function destroy($id)
    {
        $brand = $this->brandRepo->find($id);

        if ($brand->image && file_exists(public_path($brand->image))) {
            unlink(public_path($brand->image));
        }

        $this->brandRepo->delete($brand);

        return redirect()->back()->with('message', 'Brand Deleted Successfully');
    }
  

}