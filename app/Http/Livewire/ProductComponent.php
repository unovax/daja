<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
class ProductComponent extends Component
{
    use WithFileUploads;
    public $productModal = false;
    public $categoryModal = false;
    public $deleteProductModal = false;

    public $product = [
        'id' => null,
        'name' => '',
        'code' => '',
        'category_id' => '',
        'price' => '',
        'description' => '',
        'image' => null
    ];

    public $productImage = null;

    public $category = [
        'id' => '',
        'name' => '',
        'code' => ''
    ];

    protected $rules = [
        'product.id' => 'nullable',
        'product.name' => 'required|max:100',
        'product.code' => 'required|max:10',
        'product.category_id' => 'required',
        'product.price' => 'required',
        'product.description' => 'required|max:255',
        'product.image' => 'nullable|image|max:1024',
        'category.id' => 'nullable',
        'category.name' => 'required|max:255',
        'category.code' => 'required|max:10'
    ];

    public $size_page = 100;
    public $search = null;

    public $categories = [];

    public function render()
    {
        if($this->search){
            $products = Product::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('code', 'like', '%'.$this->search.'%')
                ->orWhere('price', 'like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%')
                ->orWhereHas('category', function($query){
                    $query->where('name', 'like', '%'.$this->search.'%');
                })
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $products = Product::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.product-component', [
            'products' => $products
        ]);
    }

    public function mount(){
        $this->categories = Category::all();
    }

    public function saveProduct(){
        if($this->product['id'] == ''){
            $this->createProduct();
        }else{
            $this->updateProduct();
        }
    }

    public function createProduct(){
        $this->validate([
            'product.name' => 'required|max:255',
            'product.code' => 'required|unique:products,code|max:10',
            'product.category_id' => 'required',
            'product.price' => 'required',
            'product.description' => 'required|max:255',
        ]);
        try {
            if($this->productImage){
                $this->product['image'] = $this->productImage->store('products', 'public');
            }
            Product::create($this->product);
            $this->emit('showNotification', 'Producto guardado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function updateProduct(){
        $this->validate([
            'product.name' => 'required|max:255',
            'product.code' => 'required|max:10|unique:products,code,'.$this->product['id'],
            'product.category_id' => 'required',
            'product.price' => 'required',
            'product.description' => 'required|max:255',
        ]);
        try {
            if( gettype($this->productImage) == 'object' ){
                $this->product['image'] = $this->productImage->store('products', 'public');
            }
            Product::find($this->product['id'])->update($this->product);
            $this->emit('showNotification', 'Producto guardado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function setProductToEdit($id){
        $this->productModal = true;
        $this->product = Product::find($id)->toArray();
        $this->productImage = $this->product['image'];
    }

    public function setProductToDelete($id){
        $this->deleteProductModal = true;
        $this->product = Product::find($id)->toArray();
    }

    public function deleteProduct(){
        try {
            Product::destroy($this->product['id']);
            $this->emit('showNotification', 'Producto eliminado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function erase(){
        $this->productModal = false;
        $this->deleteProductModal = false;
        $this->categoryModal = false;
        $this->product = [
            'id' => '',
            'name' => '',
            'code' => '',
            'category_id' => '',
            'price' => '',
            'description' => '',
            'image' => '',
        ];
        $this->productImage = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function eraseCategoryData(){
        $this->category = [
            'id' => '',
            'name' => '',
            'code' => ''
        ];
        $this->categoryModal = false;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function createCategory(){
        $this->validate([
            'category.name' => 'required|max:255',
            'category.code' => 'required|unique:categories,code|max:10',
        ]);
        try {
            $category = Category::create($this->category);
            $this->emit('showNotification', 'Unidad guardada correctamente', 'success');
            $this->categories = Category::all();
            $this->eraseCategoryData();
            $this->product['category_id'] = $category->id;
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }
}
