<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JadwalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class JadwalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class JadwalCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Jadwal::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/jadwal');
        CRUD::setEntityNameStrings('jadwal', 'jadwal');

        if (!backpack_user()->hasAnyRole('Admin')) {
            abort(404);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(JadwalRequest::class);


        $fields = [
            [   // select2_from_array
                'name'        => 'hari',
                'label'       => "Hari",
                'type'        => 'select2_from_array',
                'options'     => [
                    'senin' => 'Senin',
                    'selasa' => 'Selasa',
                    'rabu' => 'Rabu',
                    'kamis' => 'Kamis',
                    'jumat' => 'Jumat',
                    'sabtu' => 'Sabtu',
                    'minggu' => 'Minggu',
                ],
                'allows_null' => false,
                'default'     => 'senin',
                'attributes' => [
                    'required' => 'required',
                ],
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ],
            [   // Time
                'name'  => 'mulai',
                'label' => 'Mulai',
                'type'  => 'time',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // Time
                'name'  => 'berakhir',
                'label' => 'Akhir',
                'type'  => 'time',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
        ];
        $this->crud->addFields($fields);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
