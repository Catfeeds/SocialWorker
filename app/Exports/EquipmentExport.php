<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/5/26
 * Time: 13:36
 */

namespace App\Exports;


use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EquipmentExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return Equipment::query()
            ->join('equipment_categories', 'equipment.category_id', '=', 'equipment_categories.id')
            ->select(
                'equipment.id',
                'equipment.category_id',
                'equipment_categories.name',
                'equipment.serial_no'
            );
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->category_id,
            $row->name,
            $row->serial_no
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            '类型ID',
            '类型名称',
            '序列号'
        ];
    }
}