<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/25
 * Time: 12:50
 */

namespace App\Exports;


use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CashesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return Cash::query()->where('status', 2)
            ->join('users', 'cashes.user_id', '=', 'users.id')
            ->select('users.name', 'users.phone', 'cashes.number', 'cashes.tax', 'cashes.created_at');;
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->phone . "\t",
            $row->number . "\t",
            $row->tax . "\t",
            $row->number - $row->tax . "\t",
            (string)$row->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '姓名',
            '手机',
            '申请金额',
            '代缴个税',
            '实到金额',
            '时间'
        ];
    }
}