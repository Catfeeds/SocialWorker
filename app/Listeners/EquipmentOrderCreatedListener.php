<?php

namespace App\Listeners;

use App\Events\EquipmentOrderCreated;
use App\Models\EquipmentOrderCode;
use App\Services\WeChatQRCode;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EquipmentOrderCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param EquipmentOrderCreated $event
     * @throws \Throwable
     */
    public function handle(EquipmentOrderCreated $event)
    {
        $equipmentOrder = $event->equipmentOrder;

        if ($equipmentOrder->type == 2) {
            try {
                \DB::transaction(function () use ($equipmentOrder) {
                    EquipmentOrderCode::create([
                        'equipment_order_id' => $equipmentOrder->id,
                        'code' => WeChatQRCode::crowdFunding($equipmentOrder->id)
                    ]);
                });
            } catch (\Exception $exception) {
                $equipmentOrder->delete();
                throw $exception;
            }
        }
    }
}
