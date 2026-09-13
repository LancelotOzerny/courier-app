<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LockerCell;
use App\Models\Order;
use App\Models\ParcelLocker;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderImportController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'number' => ['required', 'integer', 'min:1', 'unique:orders,number'],
            'courier_login' => ['required', 'string', 'max:255', 'exists:users,login'],
            'parcel_locker' => ['required', 'array:number,address'],
            'parcel_locker.number' => ['required', 'string', 'max:255'],
            'parcel_locker.address' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'cells' => ['required', 'array', 'min:1'],
            'cells.*' => ['required', 'string', 'max:255', 'distinct'],
        ]);

        $order = DB::transaction(function () use ($data): Order {
            $courier = User::query()->where('login', $data['courier_login'])->firstOrFail();

            $parcelLocker = ParcelLocker::query()->updateOrCreate(
                ['number' => $data['parcel_locker']['number']],
                ['address' => $data['parcel_locker']['address']],
            );

            $order = Order::query()->create([
                'number' => $data['number'],
                'courier_id' => $courier->id,
                'parcel_locker_id' => $parcelLocker->id,
                'courier_created_at' => now(),
            ]);

            $order->items()->createMany($data['items']);

            $cellIds = collect($data['cells'])
                ->map(fn (string $number): int => LockerCell::query()->firstOrCreate([
                    'parcel_locker_id' => $parcelLocker->id,
                    'number' => $number,
                ])->id)
                ->all();

            $order->lockerCells()->sync($cellIds);

            return $order->load(['courier', 'parcelLocker', 'items', 'lockerCells']);
        });

        return response()->json([
            'data' => [
                'number' => $order->number,
                'courier_login' => $order->courier->login,
                'courier_created_at' => $order->courier_created_at->toAtomString(),
                'status' => $order->status,
                'parcel_locker' => [
                    'number' => $order->parcelLocker->number,
                    'address' => $order->parcelLocker->address,
                ],
                'items' => $order->items->map(fn ($item): array => [
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                ])->values(),
                'cells' => $order->lockerCells->pluck('number')->values(),
            ],
        ], JsonResponse::HTTP_CREATED);
    }
}
