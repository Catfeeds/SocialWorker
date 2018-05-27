<?php

namespace App\Http\Resources;

use App\Exceptions\BaseException;
use App\Http\Controllers\Api\UserController;
use App\Models\ServiceOrder;
use App\Models\User;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static function collection($resource)
    {
        return tap(new UserResourceCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    /**
     * 需要隐藏的字段
     *
     * @var array
     */
    protected $withoutFields = [];

    /**
     * 需要显示的字段
     *
     * @var array
     */
    protected $showFields = [];

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'name' => $this->name ?: '-',
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
            'sex' => $this->convertSex($this->sex),
            'account' => $this->account,
            'phone' => $this->phone ?: '-',
            'order_count' => $this->checks()->sum('price') + $this->equipmentOrders()->sum('price'),
            'asset' => $this->asset->available,
            'checks' => ServiceOrderResource::collection($this->checks()->where('status', '>', 1)->get()),
            'services' => ServiceOrderResource::collection($this->services()->where('status', '>', 1)->get()),
            'friends' => (new UserController())->friends($this->id),
            'equipment' => EquipmentResource::collection($this->bindingsEquipment),
            'created_at' => (string)$this->created_at
        ]);
    }

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    public function show(array $field)
    {
        $this->showFields = $field;
        return $this;
    }

    protected function filterFields($array)
    {
        if (!empty($this->showFields))
            return collect($array)->only($this->showFields)->toArray();

        return collect($array)->forget($this->withoutFields)->toArray();
    }

    /**
     * 隐藏部分字段
     *
     * @param $value
     * @param $start
     * @param $length
     * @return mixed
     */
    public function partialHidden($value, $start, $length)
    {
        if (!$value) {
            return $value;
        }

        return substr_replace($value, '****', $start, $length);
    }

    /**
     * 转换性别字段
     *
     * @param $value
     * @return mixed
     */
    public function convertSex($value)
    {
        $sex = [
            0 => '未知',
            1 => '男',
            2 => '女'
        ];

        return $sex[$value];
    }

    /**
     * 判断是否是自己或者超级管理员
     *
     * @return bool
     * @throws \Exception
     */
    public function isSelfOrSuper()
    {
        try {
            return TokenFactory::needSelfOrRole($this->id);
        } catch (BaseException $e) {
            return false;
        }
    }
}