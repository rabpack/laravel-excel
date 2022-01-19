<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class TestExcelExport implements FromQuery,WithHeadings,WithMapping,WithColumnFormatting,ShouldAutoSize,WithEvents,WithTitle,WithDrawings
{
    private int $userCount;

    public function __construct()
    {
        $this->userCount = User::query()->count() + 4;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
public function query()
{
   return User::query();
}

    public function headings(): array
    {
        return  [
            ['فدراسیون شنا، شیرجه و واترپلو'],
            ['گزارش پرداختی های ماه'],
            ['تاریخ : 2022/10/01','','','','','شماره : 15220-550021','',''],
            ['شناسه','نام','نام خانوادگی','موبایل','تاریخ تولد','کد ملی','ایمیل','تاریخ ساخت'],

        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->family,
            $user->mobile,
            $user->birthDate,
            $user->nationalCode,
            $user->email,
            $user->created_at

        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function registerEvents(): array
    {
        $styleArray = ['font' => ['bold' => true]];
        return [
            AfterSheet::class =>

                function (AfterSheet $event) use ($styleArray) {
                    // change direction to rtl
                    $event->sheet->setRightToLeft(true);

                    //merge row
                    $cellCount = $this->userCount + 1;
                    $event->sheet->getDelegate()->mergeCells('A1:H1');
                    $event->sheet->getDelegate()->mergeCells('A2:H2');
                    $event->sheet->getDelegate()->mergeCells('A3:E3');
                    $event->sheet->getDelegate()->mergeCells('F3:H3');
                    $event->sheet->getDelegate()->mergeCells("A{$cellCount}:C{$cellCount}");
                    $event->sheet->getDelegate()->mergeCells("D{$cellCount}:F{$cellCount}");
                    $event->sheet->getDelegate()->mergeCells("G{$cellCount}:H{$cellCount}");

                    // footer data
                    $event->sheet->setCellValue("A{$cellCount}",'امضاء1');
                    $event->sheet->setCellValue("D{$cellCount}",'امضاء2');
                    $event->sheet->setCellValue("G{$cellCount}",'امضاء3');


                    //bold heading
                    $event->sheet->getStyle('A1:H1')->applyFromArray($styleArray);
                    $event->sheet->getStyle('A2:H2')->applyFromArray($styleArray);
                    $event->sheet->getStyle('A4:H4')->applyFromArray($styleArray);

                    // center text
                    $event->sheet->getStyle("A4:H{$this->userCount}")->getAlignment()->setHorizontal('center');
                    $event->sheet->getStyle("A1:H1")->getAlignment()->setHorizontal('center');
                    $event->sheet->getStyle("A2:H2")->getAlignment()->setHorizontal('center');
                    $event->sheet->getStyle("A3:E3")->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle("F3:H3")->getAlignment()->setHorizontal('left');

                },

        ];
    }



    public function title(): string
    {
        return  'شرکت دیاکو پردازش';
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo.png'));
        $drawing->setWidth(30);
        $drawing->setHeight(30);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
