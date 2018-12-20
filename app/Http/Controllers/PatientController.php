<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientCreateRequest;
use App\Http\Requests\PatientDeleteRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Requests\PatientViewRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class PatientController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Repositories\PatientRepository
     */
    protected $patient;

    /**
     * Visit repository
     *
     * @var \App\Repositories\VisitRepository
     */
    protected $visit;

    /**
     * Create the controller instance
     *
     * @param \App\Repositories\PatientRepository $patient
     * @param \App\Repositories\VisitRepository $vist
     */
    public function __construct(PatientRepository $patient, VisitRepository $visit)
    {
        $this->patient = $patient;
        $this->visit = $visit;
    }

    /**
     * Get patients
     *
     * @param  \App\Place\Http\Requests\PatientViewRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(PatientViewRequest $request)
    {
        $patients = QueryBuilder::for(Patient::class)
            ->allowedFilters(
                'full_name',
                Filter::exact('phone'),
                Filter::exact('identity_no'),
                Filter::exact('code'),
                Filter::exact('email')
            )
            ->latest();

        return PatientResource::collection(
            $request->per_page == 'all' ? $patients->get() : $patients->paginate($request->per_page)
        );
    }

    /**
     * Show a patient
     *
     * @param  \App\Place\Http\Requests\PatientViewRequest $request
     * @param  \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function show(PatientViewRequest $request, Patient $patient)
    {
        return new PatientResource($patient);
    }

    /**
     * Register a new patient.
     *
     * @param  \App\Place\Http\Requests\PatientCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientCreateRequest $request)
    {
        $patient = $this->patient->create($request->all());
        $this->visit->generateGueue($patient, $request->progress ?? 1);

        return $patient;
    }

    /**
     * Update a new patient.
     *
     * @param  \App\Place\Http\Requests\PatientUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientUpdateRequest $request, $id)
    {
        $patient = $this->patient->update($id, $request->all());
        $this->visit->generateGueue($patient, $request->progress ?? 1);

        return $patient;
    }

    /**
     * Delete patients
     *
     * @param  \App\Http\Requests\PatientDeleteRequest $request
     * @param  \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientDeleteRequest $request, Patient $patient)
    {
        $patient->delete();

        return new PatientResource($patient);
    }
}
