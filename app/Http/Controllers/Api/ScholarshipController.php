<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Scholarship;
use App\Http\Requests\ScholarshipRequest;
use Illuminate\Http\Request;
use Exception;

class ScholarshipController extends Controller
{
    public function index()
    {
        try {
            $scholarships = Scholarship::with(['image', 'letter'])
                ->where('active', 1)
                ->get();

            return $this->sendResponse(
                $scholarships->count() === 1 ? $scholarships->first() : $scholarships
            );
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve scholarships', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $scholarship = Scholarship::with(['image', 'letter'])->find($id);

            if (!$scholarship) {
                return $this->sendError('Scholarship not found', 404);
            }

            return $this->sendResponse($scholarship);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve scholarship', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(ScholarshipRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['sc_orders'])) {
                $data['sc_orders'] = Scholarship::max('sc_orders') + 1;
            }

            $Scholarship = Scholarship::create($data);
            return $this->sendResponse($Scholarship, 201, 'Scholarship created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Scholarship', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ScholarshipRequest $request, $id)
    {
        try {
            $scholarship = Scholarship::find($id);
            if (!$scholarship) {
                return $this->sendError('Scholarship not found', 404);
            }

            $scholarship->update($request->validated());
            return $this->sendResponse($scholarship, 200, 'Scholarship updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update scholarship', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $scholarship = Scholarship::find($id);
            if (!$scholarship) {
                return $this->sendError('Scholarship not found', 404);
            }

            $scholarship->active = $scholarship->active == 1 ? 0 : 1;
            $scholarship->save();

            return $this->sendResponse([], 200, 'Scholarship visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
