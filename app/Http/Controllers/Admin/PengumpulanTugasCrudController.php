<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PengumpulanTugasRequest;
use App\Models\Tugas;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;
use Symfony\Component\Routing\Route;

/**
 * Class PengumpulanTugasCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PengumpulanTugasCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PengumpulanTugas::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pengumpulan-tugas');
        CRUD::setEntityNameStrings('pengumpulan tugas', 'pengumpulan tugas');

        $this->crud->denyAccess(['delete']);
        if (backpack_user()->hasAnyRole('Guru', 'Admin')) {
            $this->crud->denyAccess(['update', 'create']);
        }
        if (backpack_user()->hasAnyRole('Guru')) {
            $tugas = backpack_user()->tugas;
            $tugasId = [];
            foreach ($tugas as $t) {
                $tugasId[] = $t->id;
            }
            $this->crud->addClause('whereIn', 'tugas_id', $tugasId);
        }
        if (backpack_user()->hasAnyRole('Siswa')) {
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
        $this->crud->removeButton('create');
        // CRUD::setFromDb(); // columns

        $columns = [
            [
                'name'  => 'tugas_id',
                'label' => "Tugas",
                'type'  => 'relationship',
                'entity' => 'tugas',
                'model' => Tugas::class,
            ],
            // [
            //     'name'  => 'deskripsi',
            //     'label' => 'Deskripsi',
            //     'type'  => 'text',
            // ],
            [
                'name'  => 'nilai',
                'label' => 'Nilai',
                'type'  => 'relationship',
                // 'entity' => 'user',
                // 'model' => User::class,
                // 'attribute' => 'name',
            ],
            [
                'name'  => 'created_at',
                'label' => 'Pengumpulan',
                'type'  => 'dateTime',
            ],
        ];
        if (backpack_user()->hasAnyRole('Guru')) {
            $columns[] =
                [
                    'name'  => 'user_id',
                    'label' => "User",
                    'type'  => 'relationship',
                    'entity' => 'user',
                    'model' => User::class,
                    'attribute' => 'name',
                ];
        }
        $this->crud->setColumns($columns);

        $this->crud->removeButton('update');
    }

    protected function setupShowOperation()
    {
        $columns = [
            [
                'name'  => 'tugas_id',
                'label' => "Tugas",
                'type'  => 'relationship',
                'entity' => 'tugas',
                'model' => Tugas::class,
            ],
            [
                'name'  => 'deskripsi',
                'label' => 'Deskripsi',
                'type'  => 'text',
            ],
            [
                'name'  => 'nilai',
                'label' => 'Nilai',
                'type'  => 'relationship',
            ],
            [
                'name'  => 'created_at',
                'label' => 'Pengumpulan',
                'type'  => 'dateTime',
            ],
        ];
        $this->crud->setColumns($columns);

        if (backpack_user()->hasAnyRole('Guru')) {
            if (isset($this->crud->getCurrentEntry()->nilai)) {
                $this->crud->addButtonFromModelFunction('line', 'nilai', 'editNilaiUrl', 'beginning');
            } else {
                $this->crud->addButtonFromModelFunction('line', 'nilai', 'nilaiUrl', 'beginning');
            }
        }
        if (Carbon::parse($this->crud->getCurrentEntry()->tugas->waktu_muncul)->isFuture()) {
            $this->crud->denyAccess(['update']);
        }
        if (Carbon::parse($this->crud->getCurrentEntry()->tugas->batas)->isPast()) {
            $this->crud->denyAccess(['update']);
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
        if ($this->crud->actionIs('create')) {
            if (!request()->input('tugas', false)) {
                abort(404);
            }
            $tugas = Tugas::find(request()->input('tugas', false));
            if ($tugas === null) {
                abort(404);
            } else {
                if (Carbon::parse($tugas->batas)->isPast()) {
                    abort(404);
                }
                if (Carbon::parse($tugas->waktu_muncul)->isFuture()) {
                    abort(404);
                }
                if (!$tugas->tugas) {
                    abort(404);
                }
            }
        }

        CRUD::setValidation(PengumpulanTugasRequest::class);

        // CRUD::setFromDb();
        $fields = [
            // [
            //     'type' => "relationship",
            //     'name' => 'tugas_id',
            //     'default' => request()->input('tugas', ''),
            //     'attributes' => [
            //         'readonly'    => 'readonly',
            //         'disabled'    => 'disabled',
            //     ],
            //     'label' => 'Tugas',
            //     'entity' => 'tugas',
            //     'model' => Tugas::class,
            //     'attribute' => 'nama'
            // ],
            [
                'name'  => 'deskripsi',
                'label' => 'Deskripsi',
                'type'  => 'easymde',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // Hidden
                'name'  => 'user_id',
                'type'  => 'hidden',
                'value' => backpack_user()->id,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // Hidden
                'name'  => 'tugas_id',
                'type'  => 'hidden',
                'value' => request()->input('tugas', ''),
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

        if (Carbon::parse($this->crud->getCurrentEntry()->tugas->waktu_muncul)->isFuture()) {
            abort(404);
        }
        if (Carbon::parse($this->crud->getCurrentEntry()->tugas->batas)->isPast()) {
            abort(404);
        }

        CRUD::setValidation(PengumpulanTugasRequest::class);

        // CRUD::setFromDb();
        $fields = [
            [
                'name'  => 'deskripsi',
                'label' => 'Deskripsi',
                'type'  => 'easymde',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [   // Hidden
                'name'  => 'user_id',
                'type'  => 'hidden',
                'value' => backpack_user()->id,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
        ];
        $this->crud->addFields($fields);
    }
}
