# Laravel Crud #



### Description ###

This package was created to help you build a CRUD system

### Run Command On Your Terminal ###

```php
   composer require benahmetcelik/laravel-crud
```



```php
   php artisan vendor:publish --tag="crud-views"
```



### Examples ###
Let's first consider creating a **Controller**

```php
php artisan make:controller BlogController
```

Now we need to create a **model**

```php
php artisan make:model Blog

php artisan make:model Category
```

Now let's go into our controller file and replace it with the following code

```php
<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;

use Crud\Traits\BaseCrud;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use BaseCrud;
    public function __construct()
    {
        $this->base_dir = 'backend.pages.blog.';
        $this->base_model = 'App\Models\Blog';
        $this->base_resource ='backend.blog.';
        $this->tableColumns = [
            'id' => ['title'=>'ID',
                'class'=>'text-center',
                'width'=>'5%',
                'sortable'=>true,
                'searchable'=>true,
                'type'=>'number',
                ],
            'name' => ['title'=>'Name',
                'class'=>'text-center',
                'width'=>'5%',
                'sortable'=>true,
                'searchable'=>true,
                'custom_html'=>false,
                'type'=>'text',
            ],
            'slug' => ['title'=>'Slug',
                'class'=>'text-center',
                'width'=>'5%',
                'sortable'=>true,
                'searchable'=>true,
                'custom_html'=>false,
                'type'=>'text',
            ],
            'status' => ['title'=>'Status',
                'class'=>'text-center',
                'width'=>'5%',
                'sortable'=>true,
                'searchable'=>false,
                'type'=>'boolean',
            ],
            'created_at' => ['title'=>'Created At',
                'class'=>'text-center',
                'width'=>'5%',
                'sortable'=>true,
                'searchable'=>true,
                'type'=>'date',
            ],
            'updated_at' => ['title'=>'Updated At',
                'class'=>'text-center',
                'width'=>'5%',
                'sortable'=>true,
                'searchable'=>true,
                'type'=>'date',
            ],
        ];
        $this->tableActions = [
          'edit'=>[
              'type'=>'link',
                'route'=>'backend.blog.edit',
                'icon'=>'fa fa-edit',
                'class'=>'btn btn-primary btn-sm',
            ],
            'delete'=>[
                'type'=>'form',
                'method'=>'delete',
                'route'=>'backend.blog.destroy',
                'icon'=>'fa fa-trash',
                'class'=>'btn btn-danger btn-sm',
            ],
            'show'=>[
                'type'=>'link',

                'route'=>'backend.blog.show',
                'icon'=>'fa fa-eye',
                'class'=>'btn btn-success btn-sm',
            ],
        ];
        $this->formInputs = [
            'name' => [
                'type' => 'text',
                'label' => 'Name',
                'placeholder' => 'Enter Name',
                'required' => 'required',
            ],
            'slug' => [
                'type' => 'text',
                'label' => 'Slug',
                'placeholder' => 'Enter Slug',
                'required' => 'required',
            ],
            'status' => [
                'type' => 'select',
                'label' => 'Status',
                'placeholder' => 'Select Status',
                'required' => 'required',
                'options' => [
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ],
            ],
            'image'=>[
                'type' => 'file',
                'label' => 'Image',
                'placeholder' => 'Select Image',
                'required' => 'required',
                'multiple' => 'multiple',
            ],
            'parent_id'=>[
                'type' => 'select',
                'label' => 'Parent Category',
                'placeholder' => 'Select Category',
                'required' => 'required',
                'options' => [
                    '0' => 'No Category'
                ],
                'relation'=>[
                    'model'=>'App\Models\Category',
                    'key'=>'id',
                    'value'=>'name',
                ],


            ],
            'content' => [
                'type' => 'textarea',
                'label' => 'Content',
                'placeholder' => 'Enter Content',
                'required' => 'required',
            ],
           
        ];
        $this->formDetails = [
            'create'=>[
                'title'=>'Create Blog',
                'action'=>route('backend.blog.store'),
                'method'=>'POST',
                'submit'=>'Create',
                'formName'=>'create',
                'formCancelText' => 'Cancel',
                'formCancelRoute' => route('backend.blog.index'),
                'formCancelClass' => 'btn btn-danger',
                'formSubmitClass' => 'btn btn-primary',
                'formSubmitIcon' => 'fa fa-save',
                'formCancelIcon' => 'fa fa-times',
                'formTitleIcon' => 'fa fa-plus',
                'formTitleClass' => 'text-primary',
                'formClass' => 'form-horizontal',
                'formId' => 'form',
                'formEnctype' => 'multipart/form-data',
            ],
            'edit'=>[
                'formName'=>'create',
                'title'=>'Edit Blog',
                'action'=>route('backend.blog.update',1),
                'method'=>'put',
                'submit'=>'Update',
                'cancel'=>'Cancel',
                'formCancelText' => 'Cancel',
                'formCancelRoute' => route('backend.blog.index'),

                'formCancelClass' => 'btn btn-danger',
                'formSubmitClass' => 'btn btn-primary',
                'formSubmitIcon' => 'fa fa-save',
                'formCancelIcon' => 'fa fa-times',
                'formTitleIcon' => 'fa fa-edit',
                'formTitleClass' => 'text-primary',
                'formClass' => 'form-horizontal',
                'formId' => 'form',
                'formEnctype' => 'multipart/form-data',
            ],
            ];

    }

}


```


Now let's go into our index.blade.php file and add the following code:

```php
  @include('vendor.crud.table')
```

Now let's go into our create.blade.php file and add the following code:

```php
     {!!  \Crud\Classes\FormGenerate::generateForm($model_details) !!}
```

And you finished. Now you can go to your browser and test it out.
