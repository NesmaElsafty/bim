<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'TransactionID' => $this->transaction_id,
            'amount' => $this->amount,
            'Paid_on' => $this->paid_on,
            'Details' => $this->details,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
