<?php

namespace App\Exports;

use App\Project;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;


class ProjectExport implements FromCollection
{
    use Exportable;

    private $collection;

    public function __construct($arrays) {
        //dd(array_values($arrays[0]));
        $output = array();
        $output[] = array_keys($arrays[0]);
        $output[] = array_values($arrays[0]);

        //add an empty row before the next dataset
        $output[] = [''];
        $output[] = [''];

        $output[] = [
            'Fault #','Site row',
            'Fault ID', 'Hotspot fault',
            'Substation','Inverter',
            'String','Module',
            'Module row', 'Comments',
            'Lat', 'Long',
            'Thermal Image Name','Digital Image Name'
        ];
        foreach($arrays[1] as $array){
            $output[] = $array;
        }
        $this->collection = collect($output);
    }

    public function collection() {
        return $this->collection;
    }

}
