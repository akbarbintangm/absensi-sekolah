<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TugasRequest;
use App\Models\MetodeBelajar;
use App\Models\Pembelajaran;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class TugasCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TugasCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
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
        CRUD::setModel(\App\Models\Tugas::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tugas');
        CRUD::setEntityNameStrings('tugas dan materi', 'tugas dan materi');

        if (!backpack_user()->hasAnyRole('Guru')) {
            $this->crud->denyAccess(['create', 'update', 'delete']);

            if (backpack_user()->hasAnyRole('Siswa', 'Ortu')) {
                $kelas = backpack_user()->kelas;
                // if (backpack_user()->hasAnyRole('Siswa')) {
                // } else {
                //     $kelas = backpack_user()->anak->kelas;
                // }
                $pembelajaran = [];
                foreach ($kelas as $kel) {
                    $pem = $kel->pembelajaran;
                    foreach ($pem as $p) {
                        $pembelajaran[] = $p;
                    }
                }
                // $pembelajaran = backpack_user()->kelas;
                // dd($pembelajaran);
                $pembelajaranId = [];
                foreach ($pembelajaran as $pel) {
                    $pembelajaranId[] = $pel->id;
                }

                $this->crud->addClause('whereIn', 'pembelajaran_id', $pembelajaranId);

                // Add clause untuk batas
                $this->crud->addClause('where', 'waktu_muncul', '<=', Carbon::now());
                $this->crud->addClause('where', 'batas', '>=', Carbon::now());
            }
        }

        if (backpack_user()->hasAnyRole('Guru')) {
            $this->crud->addClause('where', 'user_id', '=', backpack_user()->id);
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
                'name'  => 'nama',
                'label' => "Nama",
                'type'  => 'text',
            ],
            [
                'name'  => 'jenis',
                'label' => "Jenis",
                'type'  => 'text',
            ],
            // [
            //     'name'  => 'bobot',
            //     'label' => "Bobot",
            //     'type'  => 'number',
            //     'suffix' => ' Poin',
            // ],
            [
                'name'  => 'pembelajaran_id',
                'label' => "Pembelajaran",
                'type'  => 'relationship',
                'entity' => 'pembelajaran',
                'model' => Pembelajaran::class,
            ],
            [
                'name'  => 'batas',
                'label' => 'Batas',
                'type'  => 'dateTime',
            ],
            // [
            //     'name'         => 'metode_belajar_id', // name of relationship method in the model
            //     'type'         => 'relationship',
            //     'label'        => 'Metode', // Table column heading
            //     'entity' => 'metodeBelajar',
            //     'model' => MetodeBelajar::class,
            // ],
        ];
        if (backpack_user()->hasAnyRole('Siswa', 'Ortu')) {
            $columns[] =
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'url',
                    'label' => 'Pengumpulan', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'pengumpulanStatus', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    // 'limit' => 100, // Limit the number of characters shown
                ];
        }
        $this->crud->setColumns($columns);

        // $this->crud->addFilter(
        //     [
        //         'name'  => 'role',
        //         'type'  => 'dropdown',
        //         'label' => trans('backpack::permissionmanager.role'),
        //     ],
        //     config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
        //     function ($value) { // if the filter is active
        //         $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
        //             $query->where('role_id', '=',
        //                 $value
        //             );
        //         });
        //     }
        // );
    }

    protected function setupShowOperation()
    {
        // CRUD::setFromDb(); // columns
        $this->crud->set('show.setFromDb', false);
        $columns = [
            [
                'name'  => 'nama',
                'label' => "Nama",
                'type'  => 'text',
            ],
            [
                'name'  => 'jenis',
                'label' => "Jenis",
                'type'  => 'text',
            ],
            // [
            //     'name'  => 'bobot',
            //     'label' => "Bobot",
            //     'type'  => 'number',
            //     'suffix' => ' Poin',
            // ],
            [
                'name'  => 'pembelajaran_id',
                'label' => "Pembelajaran",
                'type'  => 'relationship',
                'entity' => 'pembelajaran',
                'model' => Pembelajaran::class,
            ],
            [
                'name'  => 'deskripsi',
                'label' => "Deskripsi",
                'type'  => 'markdown',
            ],
            // [
            //     'name'         => 'metode_belajar_id', // name of relationship method in the model
            //     'type'         => 'relationship',
            //     'label'        => 'Metode', // Table column heading
            //     'entity' => 'metodeBelajar',
            //     'model' => MetodeBelajar::class,
            // ],
            [
                'name'  => 'user_id',
                'label' => 'Guru',
                'type'  => 'relationship',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => User::class,
            ],
            [
                'name'  => 'batas',
                'label' => 'Batas',
                'type'  => 'dateTime',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'url',
                'label' => 'Metode', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getMetodeUrl', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                // 'limit' => 100, // Limit the number of characters shown
            ],
        ];

        $this->crud->setColumns($columns);
        // dd(Carbon::parse($this->crud->getCurrentEntry()->batas)->isPast());
        if (backpack_user()->hasAnyRole('Siswa')) {
            if ($this->crud->getCurrentEntry()->tugas) {
                if (!Carbon::parse($this->crud->getCurrentEntry()->batas)->isPast()) {
                    if (isset($this->crud->getCurrentEntry()->pengumpulanTugas)) {
                        $this->crud->addButtonFromModelFunction('line', 'editPengumpulan', 'editPengumpulanUrl', 'beginning');
                    } else {
                        $this->crud->addButtonFromModelFunction('line', 'pengumpulan', 'pengumpulanUrl', 'beginning');
                    }
                }
            }
        }
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TugasRequest::class);

        // CRUD::setFromDb(); // fields
        $fields = [
            [
                'name'  => 'nama',
                'label' => "Nama",
                'type'  => 'text',
                'attributes' => [
                    'required' => 'required',
                ],
                'tab' => 'Keterangan',
            ],
            [
                'type' => "relationship",
                'name' => 'pembelajaran_id',
                'label' => 'Pembelajaran',
                'entity' => 'pembelajaran',
                'model' => Pembelajaran::class,
                'attribute' => 'nama',
                'attributes' => [
                    'required' => 'required',
                ],
                'options'   => (function ($query) {
                    return $query->get()->where('guru_id', '=', backpack_user()->id);
                }),
                'tab' => 'Keterangan',
            ],
            [   // Checkbox
                'name'  => 'tugas',
                'label' => 'Tugas',
                'type'  => 'checkbox',
                'hint'       => 'Tandai jika ini adalah tugas.',
                'tab' => 'Keterangan',
            ],
            [
                'name'  => 'deskripsi',
                'label' => 'Deskripsi',
                'type'  => 'wysiwyg',
                'attributes' => [
                    'required' => 'required',
                ],
                'tab' => 'Keterangan',
            ],
            // [
            //     'name'  => 'bobot',
            //     'label' => 'Bobot',
            //     'type'  => 'number',
            //     'suffix' => 'Poin',
            //     'attributes' => [
            //         'required' => 'required',
            //     ],
            // ],
            [
                'name'  => 'waktu_muncul',
                'label' => 'Jadwal Post',
                'type'  => 'datetime_picker',
                'hint' => 'Jadwal Tugas/Materi Akan Ditampilkan.',
                'attributes' => [
                    'required' => 'required',
                ],
                'tab' => 'Waktu',
            ],
            [
                'name'  => 'batas',
                'label' => 'Batas Pengumpulan',
                'type'  => 'datetime_picker',
                'hint' => 'Jadwal Tugas/Materi Akan Dihilangkan.',
                'attributes' => [
                    'required' => 'required',
                ],
                'tab' => 'Waktu',
            ],
            [
                'name'  => 'membaca',
                'label' => "Membaca",
                'type'  => 'url',
                'tab' => 'Link',
            ],
            [
                'name'  => 'mendengar',
                'label' => "Mendengar",
                'type'  => 'url',
                'tab' => 'Link',
            ],
            [
                'name'  => 'menonton',
                'label' => "Menonton",
                'type'  => 'url',
                'tab' => 'Link',
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

    public function store()
    {
        $this->crud->addField(['type' => 'hidden', 'name' => 'user_id']);
        $this->crud->getRequest()->request->add(['user_id' => backpack_user()->id]);
        // dd($this->crud->getRequest()->request);
        $response = $this->traitStore();
        // do something after save
        return $response;
    }
}
