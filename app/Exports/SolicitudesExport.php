<?php

namespace App\Exports;

use App\Models\Solicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SolicitudesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $solicitudes;

    public function __construct($solicitudes)
    {
        $this->solicitudes = $solicitudes;
    }

    public function collection()
    {
        return $this->solicitudes;
    }

    public function headings(): array
    {
        return [
            'Folio',
            'Solicitante',
            'Correo',
            'Teléfono',
            'Escuela Procedencia',
            'Terminal',
            'Estado',
            'ID Credencial',
            'Vigencia',
            'Fecha Solicitud',
            'Lugar Residencia',
            'Lugar Origen',
            'Lugar Viaja Frecuente',
            'Veces por Semana',
            'Día Semana Viaja',
            'Forma Pago'
        ];
    }

    public function map($solicitud): array
    {
        return [
            $solicitud->folio,
            $solicitud->nombres . ' ' . $solicitud->apellidos,
            $solicitud->correo,
            $solicitud->telefono,
            $solicitud->escuela_procedencia,
            $solicitud->terminal ? $solicitud->terminal->nombre : 'N/A',
            $solicitud->estado ? $solicitud->estado->nombre : 'N/A',
            $solicitud->id_credencial ?? 'No asignado',
            $solicitud->vigencia ? \Carbon\Carbon::parse($solicitud->vigencia)->format('d/m/Y') : 'No definida',
            \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y H:i'),
            $solicitud->lugar_residencia,
            $solicitud->lugar_origen,
            $solicitud->lugar_viaja_frecuente,
            $solicitud->veces_semana,
            $this->getDiaSemana($solicitud->dia_semana_viaja),
            $this->getFormaPago($solicitud->formaPago)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para los headers
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4361ee']]
            ],
            // Autoajustar columnas
            'A:Z' => [
                'alignment' => ['vertical' => 'center']
            ]
        ];
    }

    private function getDiaSemana($diaId)
    {
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo'
        ];
        
        return $dias[$diaId] ?? 'No especificado';
    }

    private function getFormaPago($pagoId)
    {
        $formasPago = [
            1 => 'TRANSFERENCIA',
            2 => 'TAQUILLA'
        ];
        
        return $formasPago[$pagoId] ?? 'No especificado';
    }
}