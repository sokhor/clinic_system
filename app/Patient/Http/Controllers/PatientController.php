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

class PatientController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Patient\Repositories\PatientRepository
     */
    protected $patient;

    /**
     * Queue repository
     *
     * @var \App\Patient\Repositories\QueueRepositroy
     */
    protected $queue;

    /**
     * Create the controller instance
     *
     * @param \App\Patient\Repositories\PatientRepository $patient
     * @param \App\Patient\Repositories\QueueRepositroy $queue
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
            ->allowedFilters('full_name', 'phone', 'identity_no', 'id')
            ->latest()
            ->paginate($request->per_page);

        return PatientResource::collection($patients);
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
        $patient->visits()->create([
            'status' => 1,
        ]);
        $this->queue->generate($patient, ['status' => 1]);

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
        $patient->visits()->create([
            'status' => 1,
        ]);
        $this->queue->generate($patient, ['status' => 1]);

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
