<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Announcement;
use App\Http\Requests\AnnouncementRequest;
use Exception;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        try {
            $announcements = Announcement::with('img')->where('active', 1)->orderBy("am_orders", "asc")->get();
            return $this->sendResponse($announcements->count() === 1 ? $announcements->first() : $announcements);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch announcements', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $announcement = Announcement::with('img')->find($id);
            if (!$announcement) return $this->sendError('Announcement not found', 404);
            return $this->sendResponse($announcement);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch announcement', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(AnnouncementRequest $request)
    {
        try {
            $data = $request->validated();

            if (empty($data['am_orders'])) {
                $data['am_orders'] = Announcement::max('am_orders') + 1;
            }

            $announcement = Announcement::create($data);
            return $this->sendResponse($announcement, 201, 'Announcement created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create announcement', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AnnouncementRequest $request, $id)
    {
        try {
            $announcement = Announcement::find($id);
            if (!$announcement) return $this->sendError('Announcement not found', 404);

            $announcement->update($request->all());
            return $this->sendResponse($announcement, 200, 'Announcement updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update announcement', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $announcement = Announcement::find($id);
            if (!$announcement) return $this->sendError('Announcement not found', 404);

            $announcement->active = $announcement->active ? 0 : 1;
            $announcement->save();

            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found'], 404);
        }

        $newAnnouncement = $announcement->replicate();
        $newAnnouncement->am_title = $announcement->am_title . ' (Copy)';
        $newAnnouncement->am_orders = Announcement::max('am_orders') + 1;
        $newAnnouncement->save();

        return response()->json(['message' => 'Announcement duplicated', 'data' => $newAnnouncement], 200);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.am_id' => 'required|integer|exists:tbannouncement,am_id',
            '*.am_orders' => 'required|integer'
        ]);

        foreach ($data as $item) {
            Announcement::where('am_id', $item['am_id'])->update(['am_orders' => $item['am_orders']]);
        }

        return response()->json([
            'message' => 'Announcement order updated successfully',
        ], 200);
    }
}
