<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Event;
use App\Http\Requests\EventRequest;
use Exception;

class EventController extends Controller
{
    public function index()
    {
        try {
            $events = Event::where('active', 1)->get();
            return $this->sendResponse($events->count() === 1 ? $events->first() : $events);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch events', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $event = Event::find($id);
            if (!$event) return $this->sendError('Event not found', 404);
            return $this->sendResponse($event);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch event', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(EventRequest $request)
    {
        try {
            $event = Event::create($request->validated());
            return $this->sendResponse($event, 201, 'Event created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create event', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(EventRequest $request, $id)
    {
        try {
            $event = Event::find($id);
            if (!$event) return $this->sendError('Event not found', 404);
            $event->update($request->all());
            return $this->sendResponse($event, 200, 'Event updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update event', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $event = Event::find($id);
            if (!$event) return $this->sendError('Event not found', 404);
            $event->active = $event->active ? 0 : 1;
            $event->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
