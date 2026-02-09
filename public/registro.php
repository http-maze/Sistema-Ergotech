<?php
session_start();

// Si ya hay sesión, redirigir al dashboard
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente - ErgoTech</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .registro-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .registro-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4a6fa5;
        }
        
        .registro-header h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .registro-header p {
            color: #7f8c8d;
        }
        
        .form-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #4a6fa5;
        }
        
        .form-section h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #34495e;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4a6fa5;
            box-shadow: 0 0 5px rgba(74, 111, 165, 0.3);
        }
        
        .required::after {
            content: " *";
            color: #e74c3c;
        }
        
        .terms-container {
            margin: 25px 0;
            padding: 20px;
            background: #e8f4fd;
            border-radius: 8px;
            border: 1px solid #b3d7ff;
        }
        
        .terms-content {
            max-height: 200px;
            overflow-y: auto;
            padding: 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 15px;
        }
        
        .terms-checkbox input[type="checkbox"] {
            margin-top: 3px;
        }
        
        .terms-checkbox label {
            font-size: 14px;
            color: #2c3e50;
        }
        
        .terms-checkbox a {
            color: #4a6fa5;
            text-decoration: none;
        }
        
        .terms-checkbox a:hover {
            text-decoration: underline;
        }
        
        .error {
            color: #e74c3c;
            background: #ffebee;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border: 1px solid #e74c3c;
        }
        
        .success {
            color: #27ae60;
            background: #eafaf1;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border: 1px solid #27ae60;
        }
        
        .btn-submit {
            background: #2c3e50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        
        .btn-submit:hover {
            background: #4a6fa5;
        }
        
        .btn-submit:disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
        }
        
        .login-link a {
            color: #4a6fa5;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 20px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            border-radius: 10px;
            position: relative;
        }
        
        .close-modal {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #7f8c8d;
        }
        
        .close-modal:hover {
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="registro-container">
    <div class="registro-header">
        <h2>Registro de Cliente</h2>
        <p>Complete el formulario para crear su cuenta de cliente en ErgoTech</p>
    </div>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <?php
            $errors = [
                '1' => 'Error en el registro. Intente nuevamente.',
                '2' => 'El usuario o correo ya existe.',
                '3' => 'Debe aceptar los términos y condiciones.',
                '4' => 'Error en la conexión a la base de datos.',
                '5' => 'Las contraseñas no coinciden.'
            ];
            echo $errors[$_GET['error']] ?? 'Error desconocido';
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="success">
            ¡Registro exitoso! Por favor, inicie sesión.
        </div>
    <?php endif; ?>
    
    <form action="../app/auth/procesar_registro.php" method="POST" id="registroForm">
        
        <!-- Sección 1: Información Personal -->
        <div class="form-section">
            <h3>📋 Información Personal</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombre" class="required">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" required 
                           placeholder="Ej: Juan Pérez García">
                </div>
                
                <div class="form-group">
                    <label for="email" class="required">Correo electrónico</label>
                    <input type="email" id="email" name="email" required 
                           placeholder="ejemplo@empresa.com">
                </div>
                
                <div class="form-group">
                    <label for="telefono" class="required">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" required 
                           placeholder="+52 123 456 7890">
                </div>
                
                <div class="form-group">
                    <label for="cargo" class="required">Cargo/Puesto</label>
                    <input type="text" id="cargo" name="cargo" required 
                           placeholder="Ej: Gerente de Recursos Humanos">
                </div>
            </div>
        </div>
        
        <!-- Sección 2: Información de la Empresa -->
        <div class="form-section">
            <h3>🏢 Información de la Empresa</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="empresa" class="required">Nombre de la empresa</label>
                    <input type="text" id="empresa" name="empresa" required 
                           placeholder="Ej: Soluciones Tecnológicas SA de CV">
                </div>
                
                <div class="form-group">
                    <label for="sector" class="required">Sector/Industria</label>
                    <select id="sector" name="sector" required>
                        <option value="">Seleccione un sector</option>
                        <option value="manufactura">Manufactura</option>
                        <option value="servicios">Servicios</option>
                        <option value="tecnologia">Tecnología</option>
                        <option value="salud">Salud</option>
                        <option value="educacion">Educación</option>
                        <option value="construccion">Construcción</option>
                        <option value="comercio">Comercio</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="num_empleados" class="required">Número de empleados</label>
                    <select id="num_empleados" name="num_empleados" required>
                        <option value="">Seleccione un rango</option>
                        <option value="1-10">1-10 empleados</option>
                        <option value="11-50">11-50 empleados</option>
                        <option value="51-200">51-200 empleados</option>
                        <option value="201-500">201-500 empleados</option>
                        <option value="501-1000">501-1000 empleados</option>
                        <option value="1000+">Más de 1000 empleados</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="pais" class="required">País</label>
                    <select id="pais" name="pais" required>
                        <option value="">Seleccione un país</option>
                        <option value="Mexico">México</option>
                        <option value="USA">Estados Unidos</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Chile">Chile</option>
                        <option value="España">España</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="ciudad" class="required">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad" required 
                           placeholder="Ej: Ciudad de México">
                </div>
            </div>
        </div>
        
        <!-- Sección 3: Credenciales de Acceso -->
        <div class="form-section">
            <h3>🔐 Credenciales de Acceso</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="usuario" class="required">Nombre de usuario</label>
                    <input type="text" id="usuario" name="usuario" required 
                           placeholder="Ej: juan.perez">
                    <small style="color: #7f8c8d; font-size: 12px;">Solo letras, números y puntos</small>
                </div>
                
                <div class="form-group">
                    <label for="password" class="required">Contraseña</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Mínimo 8 caracteres">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password" class="required">Confirmar contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Repita la contraseña">
                </div>
            </div>
        </div>
        
        <!-- Sección 4: Términos y Condiciones -->
        <div class="terms-container">
            <h3>📜 Términos y Condiciones</h3>
            
            <div class="terms-content">
                <h4>CONTRATO DE TÉRMINOS Y CONDICIONES DE USO</h4>
                
                <p><strong>Última actualización:</strong> <?php echo date('d/m/Y'); ?></p>
                
                <h5>1. ACEPTACIÓN DE TÉRMINOS</h5>
                <p>Al registrarse en el sistema ErgoTech, usted acepta cumplir con estos términos y condiciones, nuestra política de privacidad y todas las normas establecidas para el uso del sistema de evaluaciones ergonómicas.</p>
                
                <h5>2. USO DEL SISTEMA</h5>
                <p>El sistema ErgoTech está destinado exclusivamente para:</p>
                <ul>
                    <li>Evaluaciones ergonómicas de puestos de trabajo</li>
                    <li>Gestión de evaluaciones realizadas por profesionales certificados</li>
                    <li>Consulta de resultados y reportes</li>
                    <li>Análisis estadístico de condiciones laborales</li>
                </ul>
                
                <h5>3. RESPONSABILIDADES DEL CLIENTE</h5>
                <p>Como cliente del sistema, usted se compromete a:</p>
                <ul>
                    <li>Proporcionar información veraz y actualizada</li>
                    <li>Mantener la confidencialidad de sus credenciales de acceso</li>
                    <li>Utilizar el sistema únicamente para fines legítimos</li>
                    <li>Respetar los derechos de propiedad intelectual</li>
                    <li>Notificar inmediatamente cualquier acceso no autorizado</li>
                </ul>
                
                <h5>4. PROTECCIÓN DE DATOS</h5>
                <p>Nos comprometemos a proteger sus datos personales y cumplir con la legislación aplicable en materia de protección de datos personales.</p>
                
                <h5>5. LIMITACIÓN DE RESPONSABILIDAD</h5>
                <p>ErgoTech no se hace responsable por daños indirectos, incidentales o consecuentes resultantes del uso o la imposibilidad de uso del sistema.</p>
                
                <h5>6. MODIFICACIONES</h5>
                <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las versiones anteriores quedarán archivadas.</p>
                
                <h5>7. SUSPENSIÓN DE ACCESO</h5>
                <p>Podemos suspender o cancelar su acceso al sistema si incumple estos términos y condiciones.</p>
                
                <p><strong>Para consultas:</strong> legal@ergotech.com</p>
            </div>
            
            <div class="terms-checkbox">
                <input type="checkbox" id="acepto_terminos" name="acepto_terminos" required>
                <label for="acepto_terminos">
                    He leído y acepto los <a href="#" onclick="mostrarTerminosCompletos()">términos y condiciones</a> del sistema ErgoTech. Entiendo que debo aceptarlos para poder registrarme y acceder al sistema.
                </label>
            </div>
        </div>
        
        <button type="submit" class="btn-submit" id="btnSubmit">Registrarse</button>
        
        <div class="login-link">
            ¿Ya tiene una cuenta? <a href="index.php">Iniciar sesión</a>
        </div>
    </form>
</div>

<!-- Modal para términos completos -->
<div id="modalTerminos" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="cerrarTerminos()">&times;</span>
        <h2>Términos y Condiciones Completos</h2>
        <div style="padding: 20px;">
            <?php include 'terminos_completos.html'; ?>
        </div>
        <button onclick="cerrarTerminos()" style="padding: 10px 20px; background: #4a6fa5; color: white; border: none; border-radius: 5px; cursor: pointer;">Cerrar</button>
    </div>
</div>

<script>
// Validación de contraseñas
document.getElementById('registroForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const terminos = document.getElementById('acepto_terminos').checked;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
        return false;
    }
    
    if (!terminos) {
        e.preventDefault();
        alert('Debe aceptar los términos y condiciones para registrarse');
        return false;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 8 caracteres');
        return false;
    }
});

// Mostrar términos completos
function mostrarTerminosCompletos() {
    event.preventDefault();
    document.getElementById('modalTerminos').style.display = 'block';
}

function cerrarTerminos() {
    document.getElementById('modalTerminos').style.display = 'none';
}

// Validar usuario en tiempo real
document.getElementById('usuario').addEventListener('blur', function() {
    const usuario = this.value;
    if (usuario.length > 0) {
        // Aquí podrías agregar una petición AJAX para verificar si el usuario existe
        console.log('Verificando usuario:', usuario);
    }
});

// Validar email en tiempo real
document.getElementById('email').addEventListener('blur', function() {
    const email = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email.length > 0 && !emailRegex.test(email)) {
        this.style.borderColor = '#e74c3c';
        alert('Por favor, ingrese un correo electrónico válido');
    } else {
        this.style.borderColor = '#ddd';
    }
});

// Habilitar/deshabilitar botón de envío
const formInputs = document.querySelectorAll('#registroForm input, #registroForm select');
const btnSubmit = document.getElementById('btnSubmit');

function checkForm() {
    let allFilled = true;
    formInputs.forEach(input => {
        if (input.hasAttribute('required') && !input.value.trim()) {
            allFilled = false;
        }
    });
    
    const terminos = document.getElementById('acepto_terminos').checked;
    btnSubmit.disabled = !(allFilled && terminos);
}

formInputs.forEach(input => {
    input.addEventListener('input', checkForm);
    input.addEventListener('change', checkForm);
});

document.getElementById('acepto_terminos').addEventListener('change', checkForm);

// Inicializar validación
checkForm();
</script>

</body>
</html>
