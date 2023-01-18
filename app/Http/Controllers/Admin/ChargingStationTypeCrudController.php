<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChargingStationTypeRequest;
use App\Http\Requests\ChargingStationTypeUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ChargingStationTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChargingStationTypeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ChargingStationType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/charging-station-type');
        CRUD::setEntityNameStrings('charging station type', 'charging station types');
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
            'name'      => 'image_path', // The db column name
            'label'     => 'Image', // Table column heading
            'type'      => 'image',
            'disk'   => 'public',
            'height' => '45px',
            'width'  => '28px',
        ],);

        // CRUD::column('created_at');
        // CRUD::column('updated_at');

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
        CRUD::setValidation(ChargingStationTypeRequest::class);

        $this->crud->addField('name');
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
        CRUD::setValidation(ChargingStationTypeUpdateRequest::class);

        $this->crud->addField('name');
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
            'name'      => 'image_path', // The db column name
            'label'     => 'Image', // Table column heading
            'type'      => 'image',
            'disk'   => 'public',
            'height' => '45px',
            'width'  => '28px',
        ]);
        $this->crud->addColumn('created_at');
        $this->crud->addColumn('updated_at');
    }
}
