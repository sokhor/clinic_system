<?php

namespace App\Reception\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Reception\Http\Requests\PatientCreateRequest;
use App\Reception\Http\Requests\PatientDeleteRequest;
use App\Reception\Http\Requests\PatientUpdateRequest;
use App\Reception\Http\Requests\PatientViewRequest;
use App\Reception\Http\Resources\PatientResource;
use App\Reception\Models\Patient;
use App\Reception\Repositories\PatientRepository;
use App\Reception\Repositories\QueueRepositroy;
use Spatie\QueryBuilder\QueryBuilder;

class PatientController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Reception\Repositories\PatientRepository
     */
    protected $patient;

    /**
     * Queue repository
     *
     * @var \App\Reception\Repositories\QueueRepositroy
     */
    protected $queue;

    /**
     * Create the controller instance
     *
     * @param \App\Reception\Repositories\PatientRepository $patient
     * @param \App\Reception\Repositories\QueueRepositroy $queue
     */
    public function __construct(PatientRepository $patient, QueueRepositroy $queue)
    {
        $this->patient = $patient;
        $this->queue = $queue;
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
            ->allowedFilters('name_en', 'phone', 'identity_no', 'id')
            ->latest()
            ->paginate($request->per_page);

        return PatientResource::collection($patients);
    }

    /**
     * Show a patient
     *
     * @param  \App\Place\Http\Requests\PatientViewRequest $request
     * @param  \App\Reception\Models\Patient $patient
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
        $this->queue->generate($patient);

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
        $patient = $this->patient->update(
            Patient::findOrFail($id),
            $request->all()
        );

        $this->queue->generate($patient);

        return $patient;
    }

    /**
     * Delete patients
     *
     * @param  \App\Reception\Http\Requests\PatientDeleteRequest $request
     * @param  \App\Reception\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientDeleteRequest $request, Patient $patient)
    {
        $patient->delete();

        return new PatientResource($patient);
    }
}
