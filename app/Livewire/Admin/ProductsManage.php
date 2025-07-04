<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;

class ProductsManage extends Component
{
    public $name, $description, $price, $image, $productId;
    public $showForm = false, $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:100',
        'description' => 'nullable|string|max:500',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|string|max:255',
    ];

    public function showAddForm()
    {
        $this->resetFields();
        $this->showForm = true;
        $this->isEdit = false;
    }

    public function showEditForm($id)
    {
        $product = Product::where('id', $id)
            ->where('tenant_id', tenant('id'))
            ->firstOrFail();

        $this->productId   = $product->id;
        $this->name        = $product->name;
        $this->description = $product->description;
        $this->price       = $product->price;
        $this->image       = $product->image;
        $this->showForm    = true;
        $this->isEdit      = true;
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->isEdit && $this->productId) {
            $product = Product::where('id', $this->productId)
                ->where('tenant_id', tenant('id'))
                ->firstOrFail();
            $product->update($data);
            session()->flash('message', 'Product updated successfully!');
        } else {
            $data['tenant_id'] = tenant('id');
            Product::create($data);
            session()->flash('message', 'Product created successfully!');
        }

        $this->resetFields();
        $this->showForm = false;
    }

    public function delete($id)
    {
        $product = Product::where('id', $id)
            ->where('tenant_id', tenant('id'))
            ->firstOrFail();
        $product->delete();
        session()->flash('message', 'Product deleted!');
    }

    public function resetFields()
    {
        $this->productId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = '';
        $this->showForm = false;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.admin.products-manage', [
            'products' => Product::where('tenant_id', tenant('id'))->get(),
        ]);
    }
}
