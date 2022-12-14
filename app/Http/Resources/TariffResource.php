<?php

namespace App\Http\Resources;

use App\Models\Translate;
use App\Models\TariffText;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lang = $request->lang;
        return [
            'id'    =>  $this->id,
            'title' =>  Translate::whereId($this->title)->value($lang),
            'description'   =>  Translate::whereId($this->description)->value($lang),
            'price' =>  $this->price,
            'count' =>  $this->count,
            'background_color'  =>  $this->background_color,
            'discount'  =>  $this->discount,
            'created_at'    =>  $this->created_at,
            'old_price'     =>  $this->old_price,
            'discount_text' =>  Translate::whereId($this->discount_text)->value($lang),
            'course_text' =>  Translate::whereId($this->course_text)->value($lang),
            'texts' =>  TariffText::join('translates as text', 'text.id', 'tariff_texts.text')
                ->where('tariff_texts.tariff_id', $this->id)
                ->select('tariff_texts.id','text.'.$lang.' as text')->get(),
        ];
    }
}
