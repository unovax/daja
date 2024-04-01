<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryComponent extends Component
{
    public $categoryModal = false;
    public $deleteCategoryModal = false;
    public $category = [
        'id' => '',
        'name' => '',
        'code' => ''
    ];

    protected $rules = [
        'category.id' => 'nullable',
        'category.name' => 'required|max:255',
        'category.code' => 'required|max:10'
    ];

    public $size_page = 100;
    public $search = null;

    public function render()
    {
        if($this->search){
            $categories = Category::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('code', 'like', '%'.$this->search.'%')
                ->paginate($this->size_page)->onEachSide(-1);
        }
        else{
            $categories = Category::paginate($this->size_page)->onEachSide(-1);
        }
        return view('livewire.category-component', [
            'categories' => $categories
        ]);
    }

    public function saveCategory(){
        if($this->category['id'] == ''){
            $this->createCategory();
        }else{
            $this->updateCategory();
        }
    }

    public function createCategory(){
        $this->validate([
            'category.name' => 'required|max:255',
            'category.code' => 'required|unique:categories,code|max:10',
        ]);
        try {
            Category::create($this->category);
            $this->emit('showNotification', 'Unidad guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function updateCategory(){
        $this->validate([
            'category.name' => 'required|max:255',
            'category.code' => 'required|max:10|unique:categories,code,'.$this->category['id'],
        ]);
        try {
            Category::find($this->category['id'])->update($this->category);
            $this->emit('showNotification', 'Unidad guardada correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function setCategoryToEdit($id){
        $this->categoryModal = true;
        $this->category = Category::find($id)->toArray();
    }

    public function setCategoryToDelete($id){
        $this->deleteCategoryModal = true;
        $this->category = Category::find($id)->toArray();
    }

    public function deleteCategory(){
        try {
            Category::destroy($this->category['id']);
            $this->emit('showNotification', 'Unidad eliminado correctamente', 'success');
            $this->erase();
        } catch (\Throwable $th) {
            $this->emit('showNotification', $th->getMessage(), 'fail');
        }
    }

    public function erase(){
        $this->categoryModal = false;
        $this->deleteCategoryModal = false;
        $this->category = [
            'id' => '',
            'name' => '',
            'code' => ''
        ];
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
