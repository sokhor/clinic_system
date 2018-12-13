<?php

namespace App\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Patient\Models\MedicalRecord;

class MedicalRecordController extends Controller
{
    /**
     * Get medical records.
     *
     * @param  \App\Patient\Http\Requests\MedicalRecordViewRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(MedicalRecordViewRequest $request)
    {
        $medical_records = MedicalRecord::with('patient')
            ->latest()
            ->paginate($request->per_page);

        return MedicalRecordResource::collection($medical_records);
    }

    /**
     * Get a medical record.
     *
     * @param  \App\Patient\Http\Requests\MedicalRecordViewRequest $request
     * @param  \App\Patient\Models\MedicalRecord $medical_record
     * @return \Illuminate\Http\Response
     */
    public function index(MedicalRecordViewRequest $request, MedicalRecord $medical_record)
    {
        return new MedicalRecordResource($medical_record);
    }

    /**
     * Create a new medical record.
     *
     * @param  \App\Patient\Http\Requests\MedicalRecordCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicalRecordCreateRequest $request)
    {
        $medical_record = MedicalRecord::create($request->all());
        $medical_record->medications()->create($request->all());

        return new MedicalRecordResource(
            MedicalRecord::with('medications')->find($medical_record)
        );
    }

    /**
     * Modify a medical record.
     *
     * @param  \App\Patient\Http\Requests\MedicalRecordUpdateRequest $request
     * @param  \App\Patient\Models\MedicalRecord $medical_record
     * @return \Illuminate\Http\Response
     */
    public function update(MedicalRecordUpdateRequest $request, MedicalRecord $medical_record)
    {
        $medical_record = MedicalRecord::update($request->all());
        $medical_record->medications()->updateMany($request->medications);

        return new MedicalRecordResource(
            MedicalRecord::with('medications')->find($medical_record)
        );
    }

    /**
     * Delete a medical record.
     *
     * @param  \App\Patient\Http\Requests\MedicalRecordUpdateRequest $request
     * @param  \App\Patient\Models\MedicalRecord $medical_record
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalRecordUpdateRequest $request, MedicalRecord $medical_record)
    {
        $medical_record->delete();

        return new MedicalRecordResource($medical_record);
    }
}