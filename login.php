<?php
include 'config.php';
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
  header("Location: home.php");
  exit();
}

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE nomor_unik='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['nomor_unik'];
    $_SESSION['role'] = $row['role'];
    header("Location: home.php");
    echo 'login berhasil';
    exit();
  } else {
    echo "<script>alert('Username atau password Anda salah. Silakan coba lagi!')</script>";
  }
}
?>

<!DOCTYPE html>
<html>

<head>

  <title>Login</title>
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Comment script dibawah agar dark mode sesuai konfigurasi laptop -->
  <script>tailwind.config = {
    darkMode: 'class'
  };
  </script>
  <style type="text/tailwindcss">
    #toggle:checked ~ label div.toggle-circle {
      @apply translate-x-3;
    }
  </style>

</head>

<body class="dark:bg-slate-950 dark:text-slate-200">
  <div class="flex fixed top-0 right-0 p-5">
    <span class="dark:text-slate-50 text-sm text-slate-950 mr-2 justify-center">Light</span>
    <input type="checkbox" id="toggle" class="hidden">
    <label for="toggle">
    <div class="w-9 h-5 bg-slate-500 rounded-full flex items-center p-1 cursor-pointer">
        <div class="w-4 h-4 bg-slate-50 rounded-full toggle-circle"></div>
    </div>
    </label>
    <span class="dark:text-slate-50 text-sm text-slate-950 ml-2">Dark</span>
  </div>
  <div class="dark:text-slate-200 dark:border-slate-950 max-w-lg my-10 border border-slate-250 rounded-xl mx-auto shadow-md flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company">
        <!-- <svg class="w-20 h-20 text-slate-800 dark:text-white mx-auto h-10 w-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z"/>
</svg> -->
      <h2 class="dark:text-slate-200 mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="" method="POST" name="loginForm">
        <div>
          <label for="username" class="dark:text-slate-200 block text-sm font-medium leading-6 text-gray-900">Username</label>
          <div class="mt-2">
            <input id="username" name="username" type="username" autocomplete="username" required
              class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="dark:text-slate-200 block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="text-sm">
              <a href="#" class="dark:text-slate-500 dark:hover:text-slate-400 font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
            </div>
          </div>
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <button type="submit" name="submit"
            class="dark:bg-slate-800 dark:hover:bg-slate-700 flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Login</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const checkbox = document.querySelector('#toggle');
    const html = document.querySelector('html');
    checkbox.addEventListener('click', function()
    {
      checkbox.checked ? html.classList.add('dark') : html.classList.remove('dark')
    })
  </script>
</body>

</html>