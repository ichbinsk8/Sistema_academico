<?php
class AlumnoService
{
    private $model;

    public function __construct()
    {
        $this->model = new AlumnoModel();
    }

    public function obtenerNotasProcesadas($cedula)
    {
        $notas = $this->model->obtenerNotas($cedula);

        foreach ($notas as &$n) {

            $definitiva = $this->calcularDefinitiva(
                $n['1nota'],
                $n['2nota'],
                $n['3nota']
            );

            $n['definitiva'] = $definitiva;
            $n['aprobada'] = $definitiva >= 3.0;
            $n['aprobo_nota'] = $n['aprobada']
                ? 'table'
                : 'table-danger';
        }

        return $notas;
    }

    /**
     * Determina si una nota está aprobada
     */
    public function estaAprobada($definitiva)
    {
        return $definitiva >= 3.0;
    }

    /**
     * Calcula el promedio general del estudiante
     */
    public function calcularPromedio(array $notas)
    {
        if (empty($notas))
            return 0;

        $suma = 0;
        foreach ($notas as $n) {
            $suma += $n['definitiva'];
        }

        return round($suma / count($notas), 2);
    }

    /**
     * Calcula la nota definitiva
     * Nota1: 30%
     * Nota2: 30%
     * Nota3: 40%
     * Retorna con 2 decimales
     */
    public function calcularDefinitiva($n1, $n2, $n3, $habilitacion = null, $remedial = null)
    {
        try {
            // cálculo normal
            $definitiva = round(
                ($n1 * 0.30) + ($n2 * 0.30) + ($n3 * 0.40),
                2
            );

            // si habilitación es mayor a 7 reemplaza
            if ($habilitacion !== null && $habilitacion >= 7) {
                $definitiva = $habilitacion;
            }

            // si remedial es mayor a 7 y mayor que la actual
            if ($remedial !== null && $remedial > 7 && $remedial > $definitiva) {
                $definitiva = $remedial;
            }

            return round($definitiva, 2);

        } catch (Exception $e) {
            throw $e;
        }
    }
}
