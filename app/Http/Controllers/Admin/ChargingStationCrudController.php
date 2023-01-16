<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChargingStationRequest;
use App\Http\Requests\ChargingStationUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use function PHPSTORM_META\type;

/**
 * Class ChargingStationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChargingStationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ChargingStation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/charging-station');
        CRUD::setEntityNameStrings('charging station', 'charging stations');
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
            'name' => 'charging_station_type_id',
            'label' => 'Charging station type',
            'type' => 'select',
            'entity' => 'chargingStationType',
        ]);
        $this->crud->addColumn([
            'name' => 'publish',
            'label' => 'Publish',
            'type' => 'boolean',
        ]);
        $this->crud->addColumn('created_at');

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
        CRUD::setValidation(ChargingStationRequest::class);

        $this->crud->addField('name');
        $this->crud->addField('working_time');
        $this->crud->addField([
            'name'  => 'latitude',
            'label' => 'Latitude',
            'type'  => 'number',
            'attributes' => ["step" => "any"],
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        $this->crud->addField([
            'name'  => 'longitude',
            'label' => 'Longitude',
            'type'  => 'number',
            'attributes' => ["step" => "any"],
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        $this->crud->addField([
            'name'  => 'charging_station_type_id',
            'label' => 'Charging station type',
            'type'  => 'select',
            'entity' => 'chargingStationType',
        ]);
        $this->crud->addField([
            'name'  => 'user_id',
            'label' => 'User',
            'type'  => 'select',
            'entity' => 'user',
            'attribute' => 'email'
        ]);
        $this->crud->addField([   // SelectMultiple = n-n relationship (with pivot table)
            'label'     => "Plug types",
            'type'      => 'select_multiple',
            'name'      => 'plugTypes', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'plugTypes', // the method that defines the relationship in your Model
            'model'     => "App\Models\PlugType", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            'multiple'     => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField([   // SelectMultiple = n-n relationship (with pivot table)
            'label'     => "Payment types",
            'type'      => 'select_multiple',
            'name'      => 'paymentTypes', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'paymentTypes', // the method that defines the relationship in your Model
            'model'     => "App\Models\PaymentType", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            'multiple'     => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField('description');
        $this->crud->addField([   // Upload
            'name'      => 'images',
            'label'     => 'Images',
            'type'      => 'upload_multiple',
            'upload'    => true,
            'disk'      => 'public',
            // 'attributes' => [
            //     'accept' => 'image/*',
            // ],
        ]);
        $this->crud->addField('publish');

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
        CRUD::setValidation(ChargingStationUpdateRequest::class);

        $this->crud->addField('name');
        $this->crud->addField('working_time');
        $this->crud->addField([
            'name'  => 'latitude',
            'label' => 'Latitude',
            'type'  => 'number',
            'attributes' => ["step" => "any"],
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        $this->crud->addField([
            'name'  => 'longitude',
            'label' => 'Longitude',
            'type'  => 'number',
            'attributes' => ["step" => "any"],
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        $this->crud->addField([
            'name'  => 'charging_station_type_id',
            'label' => 'Charging station type',
            'type'  => 'select',
            'entity' => 'chargingStationType',
        ]);
        $this->crud->addField([
            'name'  => 'user_id',
            'label' => 'User',
            'type'  => 'select',
            'entity' => 'user',
            'attribute' => 'email'
        ]);
        $this->crud->addField([   // SelectMultiple = n-n relationship (with pivot table)
            'label'     => "Plug types",
            'type'      => 'select_multiple',
            'name'      => 'plugTypes', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'plugTypes', // the method that defines the relationship in your Model
            'model'     => "App\Models\PlugType", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            'multiple'     => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField([   // SelectMultiple = n-n relationship (with pivot table)
            'label'     => "Payment types",
            'type'      => 'select_multiple',
            'name'      => 'paymentTypes', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'paymentTypes', // the method that defines the relationship in your Model
            'model'     => "App\Models\PaymentType", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            'multiple'     => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField([   // Upload
            'name'      => 'images',
            'label'     => 'Images',
            'type'      => 'upload_multiple',
            'upload'    => true,
            'disk'      => 'public',
            // 'attributes' => [
            //     'accept' => 'image/*',
            // ],
        ]);
        $this->crud->addField('description');
        $this->crud->addField('publish');
    }

    protected function setupShowOperation()
    {
        $this->crud->addColumn('name');
        $this->crud->addColumn('working_time');
        $this->crud->addColumn('latitude');
        $this->crud->addColumn('longitude');
        $this->crud->addColumn([
            'name' => 'charging_station_type_id',
            'label' => 'Charging station type',
            'type' => 'select',
            'entity' => 'chargingStationType',
        ]);
        $this->crud->addColumn([
            'name' => 'user_id',
            'label' => 'user',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'email'
        ]);
        $this->crud->addColumn([
            'name' => 'plugTypes',
            'label' => 'Plug types',
            'type' => 'select_multiple',
            'entity' => 'plugTypes',
            'attribute' => 'name',
            'model' => 'App\Models\PlugType',
        ]);
        $this->crud->addColumn([
            'name' => 'paymentTypes',
            'label' => 'Payment types',
            'type' => 'select_multiple',
            'entity' => 'paymentTypes',
            'attribute' => 'name',
            'model' => 'App\Models\PaymentType',
        ]);
        $this->crud->addColumn('description');
        $this->crud->addColumn([
            'name'    => 'images',
            'label'   => 'Images',
            'type'    => 'upload_multiple',
            'disk' => 'public',
        ]);
        $this->crud->addColumn([
            'name' => 'publish',
            'label' => 'Publish',
            'type' => 'boolean',
        ]);
        $this->crud->addColumn('created_at');
        $this->crud->addColumn('updated_at');
    }
}
