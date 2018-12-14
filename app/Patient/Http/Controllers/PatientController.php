<?php

namespace App\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Patient\Http\Requests\PatientCreateRequest;
use App\Patient\Http\Requests\PatientDeleteRequest;
use App\Patient\Http\Requests\PatientUpdateRequest;
use App\Patient\Http\Requests\PatientViewRequest;
use App\Patient\Http\Resources\PatientResource;
use App\Patient\Models\Patient;
use App\Patient\Repositories\PatientRepository;
use App\Patient\Repositories\QueueRepositroy;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class PatientController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Patient\Repositories\PatientRepository
     */
    protected $patient;

    /**
     * Visit repository
     *
     * @var \App\Patient\Repositories\VisitRepository
     */
    protected $visit;

    /**
     * Create the controller instance
     *
     * @param \App\Patient\Repositories\PatientRepository $patient
     * @param \App\Patient\Repositories\VisitRepository $vist
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
     * @param  \App\Patient\Models\Patient $patient
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
        $this->visit->generate($patient, $request->progress ?? 1);

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
        $this->visit->generate($patient, $request->progress ?? 1);

        return $patient;
    }

    /**
     * Delete patients
     *
     * @param  \App\Patient\Http\Requests\PatientDeleteRequest $request
     * @param  \App\Patient\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientDeleteRequest $request, Patient $patient)
    {
        $patient->delete();

        return new PatientResource($patient);
    }
}
