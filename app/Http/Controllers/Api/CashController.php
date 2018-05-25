<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/17
 * Time: 17:46
 */

namespace App\Http\Controllers\Api;


use App\Exceptions\ResourceStoreException;
use App\Exports\CashesExport;
use App\Http\Requests\StoreCash;
use App\Http\Resources\CashCollection;
use App\Models\Cash;
use App\Services\Tokens\TokenFactory;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class CashController extends ApiController
{
    public function index(Request $request)
    {
        $cashes = (new Cash())
            ->when($request->nickname, function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('nickname', 'like', '%' . $request->nickname . '%');
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->paginate(Input::get('limit') ?: 20);

        return $this->success(new CashCollection($cashes));
    }

    /**
     * 提现
     *
     * @param StoreCash $request
     * @return mixed
     * @throws ResourceStoreException
     * @throws \Throwable
     */
    public function store(StoreCash $request)
    {
        $number = $request->post('number');
        $tax = round(taxRate($number));

        try {
            DB::transaction(function () use ($number, $tax) {
                Cash::create([
                    'user_id' => TokenFactory::getCurrentUID(),
                    'number' => $number,
                    'tax' => $tax
                ]);

                TokenFactory::getCurrentUser()->asset()->decrement('available', $number);
            });
        } catch (Exception $exception) {
            throw new ResourceStoreException('提现失败，请重试');
        }

        return $this->created();
    }

    public function update(Request $request, Cash $cash)
    {
        $cash->status = $request->status;
        $cash->save();

        return $this->message('更新成功');
    }

    public function export()
    {
        return Excel::download(new CashesExport(), 'cashes.xlsx');
    }
}