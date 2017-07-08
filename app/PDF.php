<?php

namespace App;

use Fpdf;
use Storage;

class PDF extends Fpdf
{
    // Load data
    function LoadData($file)
    {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) {
            $data[] = explode(';', trim($line));
        }
        return $data;
    }

    // Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach ($header as $col) {
            $this->Cell(40, 7, $col, 1);
        }
        $this->Ln();
        // Data
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(40, 6, $col, 1);
            }
            $this->Ln();
        }
    }

    // Better table
    function ImprovedTable($header, $data)
    {
        // Column widths
        $w = array(40, 35, 40, 45);
        // Header
        for ($i=0; $i<count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
        // Data
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        for ($i=0; $i<count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    public static function save($header, $column_size, $font_size, $data)
    {
        $w = $column_size;
        $fill = false;
        $cantidad = 0;
        Fpdf::AddPage();
        foreach ($data as $row) {
            if ($cantidad%40 == 0) {
                Fpdf::Cell(array_sum($w), 0, '', 'T');
                Fpdf::SetFont('Arial', '', $font_size);
                Fpdf::AddPage();
                Fpdf::SetFillColor(4, 175, 191);
                Fpdf::SetTextColor(255);
                Fpdf::SetDrawColor(0, 0, 0);
                Fpdf::SetLineWidth(.3);
                Fpdf::SetFont('', 'B');

                //Encabezado
                for ($i=0; $i<count($header); $i++) {
                    Fpdf::Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
                }

                Fpdf::Ln();
                Fpdf::SetFillColor(224, 235, 255);
                Fpdf::SetTextColor(0);
                Fpdf::SetFont('');
            }

            for ($i=0; $i<count($header); $i++) {
                Fpdf::Cell($w[$i], 6, $row[$i], 'LR', 0, 'L', $fill);
            }
            
            Fpdf::Ln();
            $fill = !$fill;
            $cantidad++;
        }
        Fpdf::Cell(array_sum($w), 0, '', 'T');

        $nombre = 'file-'.date("Y-m-d-H:s");
        $path = __DIR__.'/../storage/exports/'.$nombre.'.pdf';
        Fpdf::Output($path, 'F');
        return $nombre;
    }

    public static function save_cursos($header, $column_size, $font_size, $data)
    {
        $w = $column_size;
        $fill = false;
        $cantidad = 0;

        foreach ($data as $row) {
            if ($cantidad%40 == 0) {
                Fpdf::Cell(array_sum($w), 0, '', 'T');
                Fpdf::SetFont('Arial', '', $font_size);
                Fpdf::AddPage();
                Fpdf::SetFillColor(4, 175, 191);
                Fpdf::SetTextColor(255);
                Fpdf::SetDrawColor(0, 0, 0);
                Fpdf::SetLineWidth(.3);
                Fpdf::SetFont('', 'B');

                //Encabezado
                for ($i=0; $i<count($header); $i++) {
                    Fpdf::Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
                }

                Fpdf::Ln();
                Fpdf::SetFillColor(224, 235, 255);
                Fpdf::SetTextColor(0);
                Fpdf::SetFont('');
            }

            for ($i=0; $i<count($header); $i++) {
                Fpdf::Cell($w[$i], 6, $row[$i], 'LR', 0, 'L', $fill);
            }
            
            Fpdf::Ln();
            $fill = !$fill;
            $cantidad++;
        }
        Fpdf::Cell(array_sum($w), 0, '', 'T');

        $nombre = 'file-'.date("Y-m-d-H:s");
        $path = __DIR__.'/../storage/exports/'.$nombre.'.pdf';
        Fpdf::Output($path, 'F');
        return $nombre;
    }
}
