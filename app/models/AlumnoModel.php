<?php
class AlumnoModel
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = Database::connect();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function buscarPorCedula($cedula)
    {
        try {
            $sql = "SELECT * FROM alumnos WHERE cedula LIKE :cedula ORDER BY `1Apellido`, `2Apellido`";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['cedula' => $cedula . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function obtenerCarnet($cedula)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT carnet FROM alumnos WHERE cedula = :cedula LIMIT 1"
            );
            $stmt->execute(['cedula' => $cedula]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw $e;
        }
    }


    /**
     * Obtiene las notas del alumno por cédula
     */
    public function obtenerNotas($cedula, $limit = 1000, $offset = 0)
    {
        try {
            $carnet = $this->obtenerCarnet($cedula);
            if (!$carnet)
                return [];

            $sql = "SELECT
                    n.`1nota`,
                    n.`2nota`,
                    n.`3nota`,
                    n.habilitacion,
                    n.curso,
                    m.materia,
                    n.semestre,
                    m.i_horaria,
                    nr.nota AS nota_remedial
                FROM notas n
                INNER JOIN materias m ON n.codigo_m = m.codigo_m
                LEFT JOIN notas_remediales nr 
                    ON nr.codigo_alumno = n.codigo_a 
                    AND nr.codigo_materia = n.codigo_m
                WHERE n.codigo_a = :carnet
                LIMIT :lim OFFSET :off";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':carnet', $carnet);
            $stmt->bindValue(':lim', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':off', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Obtiene el observador (bloqueos) del alumno
     */
    public function obtenerObservador($cedula)
    {
        try {
            $carnet = $this->obtenerCarnet($cedula);
            if (!$carnet)
                return [];

            $sql = "SELECT * FROM alumnos_bloqueos WHERE codigo_alumno = :carnet";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['carnet' => $carnet]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function obtenerGraduacion($cedula)
    {
        try {
            $carnet = $this->obtenerCarnet($cedula);
            if (!$carnet)
                return [];

            $stmt = $this->db->prepare(
                "SELECT fecha, titulo_obtenido, acta, libro, folio, acta_individual FROM graduados WHERE codigo_a = :carnet ORDER BY fecha DESC"
            );

            $stmt->execute(['carnet' => $carnet]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function contarNotas($cedula)
    {
        $carnet = $this->obtenerCarnet($cedula);

        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM notas WHERE codigo_a = :carnet"
        );
        $stmt->execute(['carnet' => $carnet]);
        return $stmt->fetchColumn();
    }

}