<?php require __DIR__ . '/../layouts/header.php'; ?>

<h3 class="mb-3">Consulta de Información del Alumno</h3>

<form method="POST" class="mb-4" novalidate>
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" name="cedula" class="form-control" placeholder="Ingrese la cédula" pattern="[0-9]{6,15}"
                required value="<?= isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : '' ?>">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Buscar</button>
        </div>
    </div>
    <small class="text-muted">Solo números (6 a 15 dígitos)</small>
</form>


<?php if (isset($_POST['cedula']) && empty($alumnos)): ?>
    <div class="alert alert-warning">No se encontró ningún alumno con esa cédula.</div>
<?php endif; ?>

<?php if (!empty($alumnos)): ?>
    <ul class="nav nav-tabs mt-4" id="alumnoTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                Información personal
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notas" type="button" role="tab">
                Notas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#observador" type="button" role="tab">
                Observador
            </button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-3">

        <!-- Inicio Información personal -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">

            <div class="card shadow mt-3">
                <div class="card-header bg-primary text-white">
                    Datos del alumno
                </div>

                <div class="card-body">

                    <?php foreach ($alumnos as $a): ?>

                        <div class="row">

                            <!-- FOTO -->
                            <div class="col-md-3 text-center">
                                <img src="/New_SGA/public/fotos/<?= htmlspecialchars($a['cedula']) ?>.jpg" alt="Foto del alumno"
                                    class="img-fluid rounded shadow img-thumbnail" style="max-height:220px;">
                            </div>

                            <!-- DATOS -->
                            <div class="col-md-9">

                                <table class="table table-sm table-bordered">

                                    <tr>
                                        <th width="30%">Nombre</th>
                                        <td><?= htmlspecialchars($a['1Apellido'] . ' ' . $a['2Apellido'] . ' ' . $a['nombres']) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Cédula</th>
                                        <td><?= htmlspecialchars($a['cedula']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Carnet</th>
                                        <td><?= htmlspecialchars($a['carnet']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Curso</th>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= htmlspecialchars($a['curso']) ?>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>E-mail</th>
                                        <td><?= htmlspecialchars($a['email']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Dirección</th>
                                        <td><?= htmlspecialchars($a['direccion']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Celular</th>
                                        <td><?= htmlspecialchars($a['celular']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Teléfono</th>
                                        <td><?= htmlspecialchars($a['telefono']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Ciudad</th>
                                        <td><?= htmlspecialchars($a['ciudad']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Fecha de Nacimiento</th>
                                        <td><?= htmlspecialchars($a['fecha_nacimiento']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Lugar de Nacimiento</th>
                                        <td><?= htmlspecialchars($a['lugar_nacimiento']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Nacionalidad</th>
                                        <td><?= htmlspecialchars($a['nacionalidad']) ?></td>
                                    </tr>

                                </table>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Información graduación -->
            <?php if (!empty($graduados)): ?>
                <div class="card mt-3">
                    <div class="card-header bg-success text-white">
                        Información de graduación
                    </div>
                    <div class="card-body">
                        <?php foreach ($graduados as $g): ?>
                            <p><strong>Título:</strong> <?= htmlspecialchars($g['titulo_obtenido']) ?></p>
                            <p><strong>Fecha:</strong> <?= htmlspecialchars($g['fecha']) ?></p>
                            <p>
                                <strong>Acta:</strong> <?= htmlspecialchars($g['acta']) ?> |
                                <strong>Libro:</strong> <?= htmlspecialchars($g['libro']) ?> |
                                <strong>Folio:</strong> <?= htmlspecialchars($g['folio']) ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-3">No registra graduación.</div>
            <?php endif; ?>

        </div>

        <!-- Notas -->
        <div class="tab-pane fade" id="notas" role="tabpanel">

            <?php if (!empty($notas)): ?>
                <div class="alert alert-secondary mt-3">
                    <strong>Promedio general del estudiante:</strong>
                    <?= htmlspecialchars($promedioGeneral) ?>
                </div>
                <table class="table table-striped table-hover table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Materia</th>
                            <th>Corte 1</th>
                            <th>Corte 2</th>
                            <th>Corte 3</th>
                            <th>Habilitacion</th>
                            <th>Remedial</th>
                            <th>Definitiva</th>
                            <th>Intensidad</th>
                            <th>Curso</th>
                            <th>Semestre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notas as $n): ?>
                            <tr>
                                <td><?= htmlspecialchars($n['materia']) ?></td>
                                <td><?= htmlspecialchars($n['1nota']) ?></td>
                                <td><?= htmlspecialchars($n['2nota']) ?></td>
                                <td><?= htmlspecialchars($n['3nota']) ?></td>
                                <td><?= htmlspecialchars($n['habilitacion']) ?></td>
                                <td><?= htmlspecialchars($n['nota_remedial']) ?></td>
                                <td class="<?= $n['definitiva'] >= 6.9 ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                                    <?= htmlspecialchars($n['definitiva']) ?>
                                </td>
                                <td><?= htmlspecialchars($n['i_horaria']) ?></td>
                                <td><?= htmlspecialchars($n['curso']) ?></td>
                                <td><?= htmlspecialchars($n['semestre']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning">El alumno no tiene notas registradas.</div>
            <?php endif; ?>
        </div>

        <!-- Observador -->
        <div class="tab-pane fade" id="observador" role="tabpanel">

            <?php if (!empty($observador)): ?>
                <table class="table table-bordered table-sm">
                    <thead class="table-warning">
                        <tr>
                            <th>Motivo</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($observador as $o): ?>
                            <tr>
                                <td><?= htmlspecialchars($o['observaciones']) ?></td>
                                <td><?= htmlspecialchars($o['fecha']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-success">No presenta observaciones.</div>
            <?php endif; ?>

        </div>

    </div>

<?php endif; ?>

<div class="mt-5">
    <p></p>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>