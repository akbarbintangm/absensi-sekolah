<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\KelasRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class KelasCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class KelasCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Kelas::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/kelas');
        CRUD::setEntityNameStrings('kelas', 'kelas');

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
        // CRUD::setFromDb(false); // columns
        $columns = [
            [
                'name'      => 'tingkatan', // The db column name
                'label'     => 'Tingkatan', // Table column heading
            ],
            [
                'name'      => 'jenis', // The db column name
                'label'     => 'Jenis', // Table column heading
            ],
            [
                'label'     => 'Siswa', // Table column heading
                'type'      => 'relationship_count',
                'name'      => 'users',
            ],
        ];
        $this->crud->setColumns($columns);
    }

    protected function setupShowOperation()
    {
        // CRUD::setFromDb(false); // columns
        $columns = [
            [
                'name'      => 'tingkatan', // The db column name
                'label'     => 'Tingkatan', // Table column heading
            ],
            [
                'name'      => 'jenis', // The db column name
                'label'     => 'Jenis', // Table column heading
            ],
            [
                'label'     => 'Siswa', // Table column heading
                'type'      => 'relationship',
                'name'      => 'users',
                'attribute' => 'name',
                // 'suffix'    => ' Orang',
            ],
        ];
        $this->crud->setColumns($columns);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(KelasRequest::class);

        // CRUD::setFromDb(false); // fields
        $fields = [
            [   // Number
                'name' => 'tingkatan',
                'label' => 'Tingkatan',
                'type' => 'number',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // Text
                'name'  => 'jenis',
                'label' => "Jenis",
                'type'  => 'text',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'users',
                'placeholder' => "Pilih siswa",
                'options'   => (function ($query) {
                    return $query->role('Siswa')->get();
                }),
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
