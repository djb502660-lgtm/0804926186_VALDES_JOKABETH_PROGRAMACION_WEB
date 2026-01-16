<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #fff5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 12px;
            border: 1px solid #fecaca;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .login-header {
            background: #fff1f2;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #fecaca;
        }

        .login-header h1 {
            font-size: 24px;
            color: #7f1d1d;
            margin: 0;
        }

        .login-header p {
            font-size: 13px;
            color: #991b1b;
            margin: 8px 0 0 0;
        }

        .login-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #7f1d1d;
            margin-bottom: 6px;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #fecaca;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .form-group input::placeholder {
            color: #d1d5db;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: #374151;
        }

        .checkbox-group input {
            margin-right: 8px;
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        .alert {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #7f1d1d;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .alert ul {
            margin: 8px 0 0 20px;
            padding: 0;
        }

        .alert li {
            margin: 4px 0;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #b91c1c;
        }

        .btn-submit:active {
            background: #991b1b;
        }

        .login-footer {
            background: #fafafa;
            padding: 16px 30px;
            text-align: center;
            border-top: 1px solid #fecaca;
            font-size: 13px;
        }

        .login-footer a {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Iniciar Sesión</h1>
            <p>Accede a tu cuenta</p>
        </div>

        <div class="login-body">
            <?php if($errors->any()): ?>
                <div class="alert">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="ejemplo@email.com">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        <label for="remember" style="margin: 0; font-weight: normal; color: #374151;">Recordarme</label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Iniciar Sesión</button>
            </form>
        </div>

        <div class="login-footer">
            ¿No tienes cuenta? <a href="<?php echo e(route('register')); ?>">Regístrate</a>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\0804926186_VALDES_JOKABETH_PROGRAMACION_WEB\sitio_web-main\resources\views/auth/login.blade.php ENDPATH**/ ?>