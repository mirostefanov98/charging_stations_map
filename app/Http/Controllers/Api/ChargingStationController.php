<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChargingStationResource;
use App\Models\ChargingStation;
use App\Models\ChargingStationLike;
use App\Models\ChargingStationType;
use App\Models\PaymentType;
use App\Models\PlugType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChargingStationController extends Controller
{
    public function filters(Request $request)
    {
        $stationTypes = ChargingStationType::all(['id', 'name']);
        $plugTypes = PlugType::all(['id', 'name']);
        $paymentTypes = PaymentType::all(['id', 'name']);

        return response()->json([
            'charging_station_types' => $stationTypes,
            'plug_types' => $plugTypes,
            'payment_types' => $paymentTypes,
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:charging_stations,name',
            'working_time' => 'required|max:500',
            'description' => 'required|max:1000',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'charging_station_type_id' => 'required|exists:charging_station_types,id',
            'plug_types' => 'required',
            'payment_types' => 'required',
            'images' => 'required|array|max:5',
            'images.*' => 'image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 401);
        }

        $validated = $validator->validated();

        $chargingStaion = new ChargingStation();

        $chargingStaion->user_id = Auth::guard('sanctum')->id();
        $chargingStaion->name = $validated['name'];
        $chargingStaion->working_time = $validated['working_time'];
        $chargingStaion->description = $validated['description'];
        $chargingStaion->latitude = $validated['latitude'];
        $chargingStaion->longitude = $validated['longitude'];
        $chargingStaion->charging_station_type_id = $validated['charging_station_type_id'];
        $chargingStaion->publish = false;

        $chargingStaion->setImagesAttribute($validated['images']);

        $chargingStaion->save();

        $chargingStaion->plugTypes()->attach($validated['plug_types']);
        $chargingStaion->paymentTypes()->attach($validated['payment_types']);

        return response()->json([
            'message' => 'Charging station Created Successfully',
        ], 200);
    }

    public function getStation(Request $request, $id)
    {
        $station = ChargingStation::find($id);

        if (!$station) {
            return response([
                'message' => "Charging station with id: {$id} not found.",
            ], 404);
        }

        $stationUser = $station->user;

        $authUser = Auth::guard('sanctum')->user();

        if ($authUser) {
            if ($stationUser->id === $authUser->id) {
                return new ChargingStationResource($station);
            }
        }

        if (!$station->publish) {
            return response([
                'message' => "Charging station with id: {$id} not found.",
            ], 404);
        }

        return new ChargingStationResource($station);
    }

    public function likeStation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'charging_station_id' => 'required|exists:charging_stations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 401);
        }

        $validated = $validator->validated();

        $userId = Auth::guard('sanctum')->id();

        $like = ChargingStationLike::where('charging_station_id', $validated['charging_station_id'])
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            if ($like->like_type) {
                $like->delete();

                return response()->json([
                    'status' => false,
                    'message' => 'Remove like Successfully',
                ], 200);
            } else {
                $like->delete();
            }
        }

        $like = new ChargingStationLike();
        $like->charging_station_id = $validated['charging_station_id'];
        $like->user_id = $userId;
        $like->like_type = true;
        $like->save();

        return response()->json([
            'status' => true,
            'message' => 'Add like Successfully',
        ], 200);
    }

    public function dislikeStation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'charging_station_id' => 'required|exists:charging_stations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 401);
        }

        $validated = $validator->validated();

        $userId = Auth::guard('sanctum')->id();

        $dislike = ChargingStationLike::where('charging_station_id', $validated['charging_station_id'])
            ->where('user_id', $userId)
            ->first();

        if ($dislike) {
            if (!$dislike->like_type) {
                $dislike->delete();

                return response()->json([
                    'status' => false,
                    'message' => 'Remove dislike Successfully',
                ], 200);
            } else {
                $dislike->delete();
            }
        }

        $dislike = new ChargingStationLike();
        $dislike->charging_station_id = $validated['charging_station_id'];
        $dislike->user_id = $userId;
        $dislike->like_type = false;
        $dislike->save();

        return response()->json([
            'status' => true,
            'message' => 'Add dislike Successfully',
        ], 200);
    }
}
