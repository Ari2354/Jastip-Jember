<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="h-screen flex items-center justify-center bg-gray-900">
    <?php
    session_start();
    include '../config/config.php'; // Pastikan path benar

    $error = ''; // Untuk menyimpan pesan kesalahan

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash password menggunakan MD5
        $hashed_password = md5($password);

        // Query untuk mencari user dengan username dan password hash MD5
        $sql = "SELECT * FROM users WHERE username = ? AND password = ? AND role = 'admin'";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Set session dan redirect ke dashboard admin
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: dasbor.php");
            exit();
        } else {
            $error = "Username atau password salah.";
        }

        $stmt->close();
    }

    $con->close();
    ?>

    <div class="flex w-full h-full">
        <!-- Left Side Image -->
        <div class="w-1/2 h-full hidden md:block">
            <img src="https://storage.googleapis.com/a1aa/image/lyuRhIFp4HHg-QXXC8wIvcz0pfhcJP6ENeiRNRVa8Wg.jpg" alt="Close-up of a computer screen displaying code" class="w-full h-full object-cover">
        </div>
        <!-- Right Side Form -->
        <div class="w-full md:w-1/2 h-full flex items-center justify-center bg-black bg-opacity-75">
            <div class="w-3/4 max-w-sm">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-blue-500">Jastip Jember
                    </h1>
                </div>
                <!-- Tampilkan pesan kesalahan jika ada -->
                <?php if (!empty($error)): ?>
                    <div class="bg-red-500 text-white p-2 mb-4 rounded">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-4">
                        <label for="username" class="block text-gray-400 mb-2">Username</label>
                        <div class="relative">
                            <input type="text" class="w-full px-4 py-2 bg-transparent border-b border-gray-600 text-white focus:outline-none focus:border-blue-500" id="username" name="username" required>
                            <i class="fas fa-user absolute right-3 top-2 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-400 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" class="w-full px-4 py-2 bg-transparent border-b border-gray-600 text-white focus:outline-none focus:border-blue-500" id="password" name="password" required>
                            <i class="fas fa-eye-slash absolute right-3 top-2 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="px-6 py-2 bg-transparent border border-white text-white rounded-full hover:bg-white hover:text-black transition duration-300">ENTRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>