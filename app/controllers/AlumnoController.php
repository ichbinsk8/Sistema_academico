<?php
class AlumnoController
{
    public function buscar()
    {
        Auth::check();

        try {
            $alumnos = [];
            $graduados = [];
            $notas = [];
            $observador = [];
            $error = null;

            if (!empty($_POST['cedula'])) {
                $model = new AlumnoModel();
                $service = new AlumnoService();
                $cedula = filter_input(
                    INPUT_POST,
                    'cedula',
                    FILTER_SANITIZE_NUMBER_INT
                );


                // Validación backend
                if (!$cedula || !preg_match('/^[0-9]{6,12}$/', $cedula)) {
                    throw new Exception('La cédula ingresada no es válida');
                } else {
                    $model = new AlumnoModel();
                    $alumnos = $model->buscarPorCedula($cedula);
                    if (empty($alumnos)) {
                        $error = 'No se encontraron resultados';
                    }
                    $graduados = $model->obtenerGraduacion($cedula);
                    $notas = $service->obtenerNotasProcesadas($cedula);
                    foreach ($notas as &$n) {
                        $n['definitiva'] = $service->calcularDefinitiva(
                            $n['1nota'],
                            $n['2nota'],
                            $n['3nota'],
                            $n['habilitacion'],
                            $n['nota_remedial']
                        );
                    }
                    unset($n);

                    $promedioGeneral = 0;
                    if (!empty($notas)) {
                        $promedioGeneral = $service->calcularPromedio($notas);
                    }
                    $observador = $model->obtenerObservador($cedula);
                }
            }
        } catch (PDOException $e) {
            Logger::handleException($e);

        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        require __DIR__ . '/../views/alumno/buscar.php';
    }


}
