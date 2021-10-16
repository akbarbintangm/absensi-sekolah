<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NilaiRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Factories\Relationship;

/**
 * Class NilaiCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NilaiCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Nilai::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/nilai');
        CRUD::setEntityNameStrings('nilai', 'nilai');

        if (!backpack_user()->hasAnyRole('Guru')) {
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
        // CRUD::setFromDb(); // columns
        $columns = [
            [
                'name' => 'pengumpulanTugas.tugas',
                'type' => 'relationship',
                'label' => 'Tugas'
            ],
            [
                'name' => 'pengumpulanTugas.user',
                'type' => 'relationship',
                'label' => 'Siswa'
            ],
            [
                'name' => 'nilai',
                'type' => 'number',
                'label' => 'Nilai',
            ]
        ];
        $this->crud->setColumns($columns);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        $this->crud->removeButton('create');
    }

    public function setupShowOperation()
    {

        $columns = [
            [
                'name' => 'pengumpulanTugas.tugas',
                'type' => 'relationship',
                'label' => 'Tugas'
            ],
            [
                'name' => 'pengumpulanTugas.user',
                'type' => 'relationship',
                'label' => 'Siswa'
            ],
            [
                'name' => 'nilai',
                'type' => 'number',
                'label' => 'Nilai',
            ]
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
        CRUD::setValidation(NilaiRequest::class);
        if (!request()->input('pengumpulan_tugas', false)) {
            abort(404);
        }
        $fields = [
            [
                'name'  => 'nilai',
                'label' => 'Nilai',
                'type'  => 'number',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // Hidden
                'name'  => 'pengumpulan_tugas_id',
                'type'  => 'hidden',
                'value' => request()->input('pengumpulan_tugas', null),
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
        CRUD::setValidation(NilaiRequest::class);

        $fields = [
            [
                'name'  => 'nilai',
                'label' => 'Nilai',
                'type'  => 'number',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
        ];
        $this->crud->addFields($fields);
    }
}
