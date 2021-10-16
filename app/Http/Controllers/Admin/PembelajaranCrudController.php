<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PembelajaranRequest;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MetodeBelajar;
use App\Models\Pelajaran;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PembelajaranCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PembelajaranCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Pembelajaran::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pembelajaran');
        CRUD::setEntityNameStrings('pembelajaran', 'pembelajaran');

        if (!backpack_user()->hasAnyRole('Admin')) {
            $this->crud->denyAccess(['create', 'update', 'delete']);

            if (backpack_user()->hasAnyRole('Guru')) {
                $this->crud->addClause('where', 'guru_id', '=', backpack_user()->id);
            }
            if (backpack_user()->hasAnyRole('Siswa')) {
                $kelas = backpack_user()->kelas;
                $kelasId = [];
                foreach ($kelas as $k) {
                    $kelasId[] = $k->id;
                }

                $this->crud->addClause('whereIn', 'kelas_id', $kelasId);
            }
        }
    }
    public function showDetailsRow($id)
    {
        return 'test';
    }
    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // $this->crud->enableDetailsRow();
        // CRUD::setFromDb(); // columns
        $columns = [
            [
                'name'         => 'pelajaran_id', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Pelajaran', // Table column heading
                'entity' => 'pelajaran',
                'model' => Pelajaran::class,
            ],
            [
                'name'         => 'jadwal_id', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Jadwal', // Table column heading
                'entity' => 'jadwal',
                'model' => Jadwal::class,
            ],
            // [
            //     'name'         => 'metode_belajar_id', // name of relationship method in the model
            //     'type'         => 'relationship',
            //     'label'        => 'Metode', // Table column heading
            //     'entity' => 'metodeBelajar',
            //     'model' => MetodeBelajar::class,
            // ],
        ];
        if (backpack_user()->hasAnyRole('Guru')) {
            $columns[] =
                [
                    'name'         => 'kelas_id', // name of relationship method in the model
                    'type'         => 'relationship',
                    'label'        => 'Kelas', // Table column heading
                    'entity' => 'kelas',
                    'model' => Kelas::class,
                ];
        }
        if (backpack_user()->hasAnyRole('Admin')) {
            $columns[] =
                [
                    'name'         => 'guru_id', // name of relationship method in the model
                    'type'         => 'relationship',
                    'label'        => 'Guru', // Table column heading
                    'entity' => 'guru',
                    'model' => User::class,
                    'attribute' => 'name'
                ];
        }
        $this->crud->setColumns($columns);
    }

    protected function setupShowOperation()
    {

        // CRUD::setFromDb(); // columns
        $columns = [
            [
                'name'         => 'pelajaran_id', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Pelajaran', // Table column heading
                'entity' => 'pelajaran',
                'model' => Pelajaran::class,
            ],
            [
                'name'         => 'jadwal_id', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Jadwal', // Table column heading
                'entity' => 'jadwal',
                'model' => Jadwal::class,
            ],
            [
                'name'         => 'guru_id', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Guru', // Table column heading
                'entity' => 'guru',
                'model' => User::class,
                'attribute' => 'name'
            ],
            // [
            //     'name'         => 'metode_belajar_id', // name of relationship method in the model
            //     'type'         => 'relationship',
            //     'label'        => 'Metode', // Table column heading
            //     'entity' => 'metodeBelajar',
            //     'model' => MetodeBelajar::class,
            // ],
        ];
        // if (backpack_user()->hasAnyRole('Admin')) {
        //     $columns[] =
        //         [
        //             'name'         => 'guru_id', // name of relationship method in the model
        //             'type'         => 'relationship',
        //             'label'        => 'Guru', // Table column heading
        //             'entity' => 'guru',
        //             'model' => User::class,
        //             'attribute' => 'name'
        //         ];
        // }
        // dd();
        // $kelas = $this->crud->getCurrentEntry()->kelas;
        // dd($kelas->users);
        if (backpack_user()->hasAnyRole('Admin', 'Guru')) {
            $columns[] =
                [
                    'name'         => 'kelas_id', // name of relationship method in the model
                    'type'         => 'relationship',
                    'label'        => 'Kelas', // Table column heading
                    'entity' => 'kelas',
                    'model' => Kelas::class,
                ];
            $columns[] =
                [
                    'name'         => 'kelas.users', // name of relationship method in the model
                    'type'         => 'relationship',
                    'label'        => 'Siswa', // Table column heading
                    // 'entity' => '',
                    'model' => User::class,
                    'attribute' => 'name'
                ];
        }
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
        CRUD::setValidation(PembelajaranRequest::class);


        $fields = [
            [   // relationship
                'type' => "relationship",
                'name' => 'pelajaran_id',
                'placeholder' => "Pilih pelajaran",
                'label' => 'Pelajaran',
                'entity' => 'pelajaran',
                'model' => Pelajaran::class,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'jadwal_id',
                'placeholder' => "Pilih jadwal",
                'label' => 'Jadwal',
                'entity' => 'jadwal',
                'model' => Jadwal::class,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'guru_id',
                'placeholder' => "Pilih guru",
                'options'   => (function ($query) {
                    return $query->role('Guru')->get();
                }),
                'label' => 'Guru',
                'entity' => 'guru',
                'model' => User::class,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            // [   // relationship
            //     'type' => "relationship",
            //     'name' => 'metode_belajar_id',
            //     'placeholder' => "Pilih metode",
            //     'label' => 'Metode Belajar',
            //     'entity' => 'metodeBelajar',
            //     'model' => MetodeBelajar::class,
            //     'attributes' => [
            //         'required' => 'required',
            //     ],
            // ],
            [   // relationship
                'type' => "relationship",
                'name' => 'kelas_id',
                'attribute' => "nama", // foreign key attribute that is shown to user (identifiable attribute)
                'placeholder' => "Pilih kelas",
                'label' => 'Kelas',
                'entity' => 'kelas',
                'model' => Kelas::class,
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
