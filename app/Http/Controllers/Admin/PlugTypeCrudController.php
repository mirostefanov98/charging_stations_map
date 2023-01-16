<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlugTypeRequest;
use App\Http\Requests\PlugTypeUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlugTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlugTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PlugType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plug-type');
        CRUD::setEntityNameStrings('plug type', 'plug types');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn('name');
        $this->crud->addColumn([
            'name'  => 'power',
            'label' => 'Power',
            'type'  => 'number',
            'suffix'        => ' kW',
            'thousands_sep' => '',
        ]);
        $this->crud->addColumn([
            'name'      => 'image_path', // The db column name
            'label'     => 'Image', // Table column heading
            'type'      => 'image',
            'disk'   => 'public',
            'height' => '50px',
            'width'  => '50px',
        ],);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PlugTypeRequest::class);

        $this->crud->addField('name');
        $this->crud->addField([
            'name' => 'power',
            'label' => 'Power',
            'type' => 'number',
            'suffix'     => "kW",
        ]);
        $this->crud->addField([
            'name'      => 'image_path',
            'label'     => 'Image',
            'type'      => 'upload',
            'upload'    => true,
            'disk'    => 'public',
            'attributes' => [
                'accept' => 'image/*',
            ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(PlugTypeUpdateRequest::class);

        $this->crud->addField('name');
        $this->crud->addField([
            'name' => 'power',
            'label' => 'Power',
            'type' => 'number',
            'suffix'     => "kW",
        ]);
        $this->crud->addField([
            'name'      => 'image_path',
            'label'     => 'Image',
            'type'      => 'upload',
            'upload'    => true,
            'disk'    => 'public',
            'attributes' => [
                'accept' => 'image/*',
            ],
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->addColumn('name');
        $this->crud->addColumn([
            'name'  => 'power',
            'label' => 'Power',
            'type'  => 'number',
            'suffix'        => ' kW',
            'thousands_sep' => '',
        ]);
        $this->crud->addColumn([
            'name'      => 'image_path', // The db column name
            'label'     => 'Image', // Table column heading
            'type'      => 'image',
            'disk'   => 'public',
            'height' => '50px',
            'width'  => '50px',
        ]);
        $this->crud->addColumn('created_at');
        $this->crud->addColumn('updated_at');
    }
}
