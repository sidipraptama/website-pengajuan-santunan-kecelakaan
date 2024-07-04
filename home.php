<?php
session_start();
include 'config.php';

$roleName = '';
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 0:
            $roleName = 'Mahasiswa';
            break;
        case 1:
            $roleName = 'Staff';
            break;
        case 2:
            $roleName = 'KABAG';
            break;
        case 3:
            $roleName = 'KABAK';
            break;
        default:
            $roleName = 'Unknown';
            break;
    }
} else {
    $roleName = 'Guest'; // Jika tidak ada sesi role, mungkin default ke Guest atau lainnya
}

if (empty($_SESSION['username']) && empty($_SESSION['role'])) {
    header("Location: login.php");
}

if (isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];

    // status pengajuan
    // 0 = masuk
    // 1 = acc staff
    // 2 = acc kabag
    // 3 = acc kabak (diterima)
    // 4 = ditolak

    $sql = "";

    if ($role == 0) {
        $sql = "SELECT * FROM pengajuans JOIN users ON pengajuans.nomor_unik_pelapor = users.nomor_unik WHERE pengajuans.nomor_unik_pelapor='$username'";
    } else {
        $sql = "SELECT * FROM pengajuans JOIN users ON pengajuans.nomor_unik_pelapor = users.nomor_unik";
    }

    $pengajuans = mysqli_query($conn, $sql);
}

if ($pengajuans) {
    $pengajuans = mysqli_fetch_all($pengajuans, MYSQLI_ASSOC);
} else {
    $pengajuans = [];
}

// Check if 'success' parameter is present in the URL
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div id="notification" class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert" style="position: fixed; bottom: 1rem; right: 1rem;">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
              <span class="font-medium">Success alert!</span> New record created successfully.
            </div>
          </div>';
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
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
        <title>Home</title>
</head>

<body class="dark:bg-slate-950 dark:text-slate-200">
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <a href="https://flowbite.com/" class="flex items-center ps-2.5 mb-5">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"><?php echo $roleName; ?></span>
            </a>
            <ul class="font-medium">
                <li>
                    <a href="home.php"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M5.024 3.783A1 1 0 0 1 6 3h12a1 1 0 0 1 .976.783L20.802 12h-4.244a1.99 1.99 0 0 0-1.824 1.205 2.978 2.978 0 0 1-5.468 0A1.991 1.991 0 0 0 7.442 12H3.198l1.826-8.217ZM3 14v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5h-4.43a4.978 4.978 0 0 1-9.14 0H3Zm5-7a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm0 2a1 1 0 0 0 0 2h8a1 1 0 1 0 0-2H8Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3">Daftar Pengajuan</span>
                    </a>
                </li>
                <?php if ($_SESSION['role'] == 0): ?>
                    <li>
                        <a href="inputPengajuan.php"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="lex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 3a1 1 0 0 1 .78.375l4 5a1 1 0 1 1-1.56 1.25L13 6.85V14a1 1 0 1 1-2 0V6.85L8.78 9.626a1 1 0 1 1-1.56-1.25l4-5A1 1 0 0 1 12 3ZM9 14v-1H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-4v1a3 3 0 1 1-6 0Zm8 2a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <span class="flex-1 ms-3 whitespace-nowrap">Buat Pengajuan</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="logout.php"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="ex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="flex absolute top-10 right-5 p-5">
            <span class="dark:text-slate-50 text-sm text-slate-950 mr-2 justify-center">Light</span>
            <input type="checkbox" id="toggle" class="hidden">
            <label for="toggle">
            <div class="w-9 h-5 bg-slate-500 rounded-full flex items-center p-1 cursor-pointer">
                <div class="w-4 h-4 bg-slate-50 rounded-full toggle-circle"></div>
            </div>
            </label>
            <span class="dark:text-slate-50 text-sm text-slate-950 ml-2">Dark</span>
        </div>
            <p class="text-3xl text-gray-900 dark:text-white mb-5 mt-5">Daftar Pengajuan Santunan Kecelakaan</p>

            <!-- Custom Dropdown Button -->
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-5"
                type="button" style="min-width: 250px;">All Status
            </button>

            <!-- Hidden Select Element -->
            <select id="statusFilter" class="hidden">
                <option value="">All</option>
                <option value="Masuk ke Staff BAKA">Masuk ke Staff BAKA</option>
                <option value="Masuk ke Kepala Bagian BAKA">Masuk ke Kepala Bagian BAKA</option>
                <option value="Masuk ke Kepala BAKA">Masuk ke Kepala BAKA</option>
                <option value="Ditolak">Ditolak</option>
                <option value="Diterima">Diterima</option>
            </select>

            <!-- Dropdown Menu -->
            <div id="dropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
                style="min-width: 200px;">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-value="">All</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-value="Masuk ke Staff BAKA">Masuk ke Staff BAKA</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-value="Masuk ke Kepala Bagian BAKA">Masuk ke Kepala Bagian BAKA</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-value="Masuk ke Kepala BAKA">Masuk ke Kepala BAKA</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-value="Ditolak">Ditolak</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-value="Diterima">Diterima</a>
                    </li>
                </ul>
            </div>


            <div class="flex items-center justify-center mb-4 rounded bg-gray-50 dark:bg-gray-800">
                <!-- tabel pengajuans -->
                <div class="relative overflow-x-auto w-full p-5">
                    <table id="pengajuansTable"
                        class="display min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 dark:bg-slate-950">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 font-medium text-left text-gray-900 dark:text-white">NRP Pengaju
                                </th>
                                <th class="px-4 py-2 font-medium text-left text-gray-900 dark:text-white">Tanggal
                                    Pengajuan</th>
                                <th class="px-4 py-2 font-medium text-left text-gray-900 dark:text-white">Status</th>
                                <th class="px-4 py-2 font-medium text-left text-gray-900 dark:text-white">Actions</th>
                                <!-- Add other headers with similar classes here -->
                            </tr>
                        </thead>
                        <tbody class="dark:bg-slate-950 dark:text-slate-950">
                            <!-- DataTables will populate tbody -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Pengajuan</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="detail-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 overflow-auto w-full" id="modal-content">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <!-- Modal footer -->
                <div class="p-4 overflow-auto w-full border-t border-gray-200 rounded-b dark:border-gray-600"
                    id="modal-footer">
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            var data = <?php echo json_encode($pengajuans); ?>;
            var table = $('#pengajuansTable').DataTable({
                "data": data,
                "columns": [
                    { "data": "nomor_unik_pelapor" },
                    { "data": "tanggal_pengajuan" },
                    {
                        "data": "status",
                        "render": function (data, type, row) {
                            if (data == 0) {
                                return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Masuk ke Staff BAKA</span>';
                            } else if (data == 1) {
                                return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Masuk ke Kepala Bagian BAKA</span>';
                            } else if (data == 2) {
                                return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Masuk ke Kepala BAKA</span>';
                            } else if (data == 3) {
                                return '<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Diterima</span>';
                            } else if (data == 4) {
                                return '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>';
                            }
                        }
                    }, {
                        "data": null,
                        "render": function (data, type, row) {
                            return `<button data-modal-target="detail-modal" data-modal-toggle="detail-modal" id="${row.pengajuan_id}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm p-2 px-5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 show-detail-modal">Details</button>`;
                        }
                    }
                ]
            });

            $('#statusFilter').on('change', function () {
                var searchValue = this.value;
                console.log()
                console.log(searchValue)
                table.column(2).search(searchValue, true, false).draw();
            });

            function getStatusLabel(data) {
                if (data == 0) {
                    return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Masuk ke Staff BAKA</span>';
                } else if (data == 1) {
                    return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Masuk ke Kepala Bagian BAKA</span>';
                } else if (data == 2) {
                    return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Masuk ke Kepala BAKA</span>';
                } else if (data == 3) {
                    return '<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Diterima</span>';
                } else if (data == 4) {
                    return '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>';
                }
            }

            $(document).on('click', '.show-detail-modal', function () {
                var pengajuanId = $(this).attr('id');
                console.log(pengajuanId)
                var data = <?php echo json_encode($pengajuans); ?>;
                var pengajuan = data.find(p => p.pengajuan_id == pengajuanId);
                console.log(pengajuan)

                var modalContent = `
                    <div class="grid grid-cols-3 md:gap-6">
                        <div class="relative col-span-2 z-0 w-full group">
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full group">
                                    <p class="text-sm font-medium text-gray-500">Tanggal</p>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <p class="text-sm font-medium text-gray-500">Kepada</p>
                                </div>
                            </div>
                        </div>
                        <div class="relative col-span-1  z-0 w-full group">
                            <div class="flex justify-end w-full">${getStatusLabel(pengajuan.status)}</div>
                        </div>
                    </div>
                `;

                if (pengajuan.tanggal_pengajuan != null) {
                    modalContent += `
                    <div class="grid md:grid-cols-3 md:gap-6">
                        <div class="relative col-span-2 z-0 w-full group">
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-2 text-sm font-medium relative w-full">${pengajuan.tanggal_pengajuan}</p>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-2 text-sm font-medium relative w-full">Masuk ke Staff BAKA</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }

                if (pengajuan.status_acc_staff != null) {
                    modalContent += `
                    <div class="grid md:grid-cols-3 md:gap-6">
                        <div class="relative col-span-2 z-0 w-full group">
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-2 text-sm font-medium relative w-full">${pengajuan.status_acc_staff}</p>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-2 text-sm font-medium relative w-full">Masuk ke Kepala Bagian BAKA</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }

                if (pengajuan.status_acc_kabag != null) {
                    modalContent += `
                    <div class="grid md:grid-cols-3 md:gap-6">
                        <div class="relative col-span-2 z-0 w-full group">
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-2 text-sm font-medium relative w-full">${pengajuan.status_acc_kabag}</p>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-2 text-sm font-medium relative w-full">Masuk ke Kepala BAKA</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }

                if (pengajuan.status_acc_mahasiswa != null) {
                    modalContent += `
                    <div class="grid md:grid-cols-3 md:gap-6">
                        <div class="relative col-span-2 z-0 w-full group">
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-5 text-sm font-medium relative w-full">${pengajuan.status_acc_mahasiswa}</p>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <p class="text-grey-600 mb-2 text-sm font-medium relative w-full">Diterima Mahasiswa</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }

                modalContent += `

                    <hr class="mt-3">

                    <p class="text-lg text-gray-900 dark:text-white mb-5 mt-5">Data Mahasiswa</p>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Nama</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.nama}</p>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Jenis
                                Kelamin</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.jenis_kelamin == 0 ? 'Laki-laki' : 'Perempuan'}</p>
                        </div>
                    </div>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white dark:bg-slate-950">NRP</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.nomor_unik}</p>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="default-input"
                                    class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Fakultas</label>
                                <p class="text-md text-gray-900 dark:text-white mb-1s relative w-full">${pengajuan.fakultas}</p>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="default-input"
                                    class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Program
                                    Studi</label>
                                <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.program_studi}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Alamat</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.alamat}</p>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Telepon/HP</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.no_telp}</p>
                        </div>
                    </div>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">File Surat Keterangan Visum</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full"><a href="uploads/${pengajuan.file_surat_keterangan_visum}" target="_blank" class="text-blue-500 underline">Open</a></p>
                        </div>
                    </div>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">File Kronologi Kejadian</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full"><a href="uploads/${pengajuan.file_kronologi_kejadian}" target="_blank" class="text-blue-500 underline">Open</a></p>
                        </div>
                    </div>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">File Nota</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full"><a href="uploads/${pengajuan.file_nota}" target="_blank" class="text-blue-500 underline">Open</a></p>
                        </div>
                    </div>

                    <hr>

                    <p class="text-lg text-gray-900 dark:text-white mb-5 mt-5">Keterangan Kejadian</p>
                    <!-- rows -->
                    <div class="grid md:grid-cols-1 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Jenis Kecelakaan</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.jenis_kecelakaan}</p>
                        </div>
                    </div>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="grid md:grid-cols-1 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <label for="default-input"
                                    class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Tanggal dan Waktu Kecelakaan</label>
                                <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.jam_hari_tanggal}</p>
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Tempat Kecelakaan</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.tempat_kecelakaan}</p>
                        </div>
                    </div>

                    <hr>

                    <p class="text-lg text-gray-900 dark:text-white mb-5 mt-5">Data Orang Tua/Wali</p>
                    <!-- rows -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Nama</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.nama_orang_tua}</p>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Telepon/HP
                            </label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.no_telp_orang_tua}</p>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="default-input"
                                class="block mb-1 text-sm font-medium text-gray-500 dark:text-white">Alamat</label>
                            <p class="text-md text-gray-900 dark:text-white mb-1 relative w-full">${pengajuan.alamat_orang_tua}</p>
                        </div>
                    </div>
                `;

                var userRole = <?php echo json_encode($_SESSION['role']); ?>;

                var modalFooter = '';

                console.log(userRole)

                if (userRole === '1' && pengajuan.status == '0') {
                    modalFooter += `
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group">
                            <button id="tolak-button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-md px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 font-extrabold" style="width: 100%" data-id="${pengajuan.pengajuan_id}">Tolak Pengajuan</button>
                        </div>
                        <div class="relative z-0 w-full group">
                            <button id="accept-button" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-md px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 font-extrabold" style="width: 100%" data-id="${pengajuan.pengajuan_id}">Teruskan Pengajuan</button>
                        </div>
                    </div>`;
                } else if (userRole === '2' && pengajuan.status == '1') {
                    modalFooter += `
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group">
                            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" id="tolak-button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-md px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 font-extrabold" style="width: 100%" data-id="${pengajuan.pengajuan_id}" type="button">Tolak Pengajuan</button>
                        </div>
                        <div class="relative z-0 w-full group">
                            <button id="kabag-button" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-md px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 font-extrabold" style="width: 100%" data-id="${pengajuan.pengajuan_id}">Teruskan Pengajuan</button>
                        </div>
                    </div>`;
                } else if (userRole === '3' && pengajuan.status == '2') {
                    modalFooter += `
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group">
                            <button id="tolak-button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-md px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 font-extrabold" style="width: 100%" data-id="${pengajuan.pengajuan_id}">Tolak Pengajuan</button>
                        </div>
                        <div class="relative z-0 w-full group">
                            <button id="kabak-button" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-md px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 font-extrabold" style="width: 100%" data-id="${pengajuan.pengajuan_id}">Terima Pengajuan</button>
                        </div>
                    </div>`;
                }

                $('#modal-content').html(modalContent);
                $('#modal-footer').html(modalFooter);
                $('#detail-modal').removeClass('hidden').addClass('flex');
            });

            // Attach click event handler for the accept button
            $(document).on('click', '#accept-button', function () {
                var pengajuanId = $(this).data('id');
                updatePengajuanStatus(pengajuanId, 1, 'status_acc_staff');
            });

            // Attach click event handler for the kabag accept button
            $(document).on('click', '#kabag-button', function () {
                var pengajuanId = $(this).data('id');
                updatePengajuanStatus(pengajuanId, 2, 'status_acc_kabag');
            });

            // Attach click event handler for the kabak accept button
            $(document).on('click', '#kabak-button', function () {
                var pengajuanId = $(this).data('id');
                updatePengajuanStatus(pengajuanId, 3, 'status_acc_kabak');
            });

            // Attach click event handler for the tolak button
            $(document).on('click', '#tolak-button', function () {
                var pengajuanId = $(this).data('id');
                updatePengajuanStatusSaja(pengajuanId, 4);
            });

            function updatePengajuanStatus(pengajuanId, status, statusColumn) {
                console.log("Updating pengajuan with ID: " + pengajuanId + " to status: " + status);

                $.ajax({
                    url: 'update_status.php', // The URL to your server-side script that will handle the update
                    type: 'POST',
                    data: {
                        pengajuan_id: pengajuanId,
                        status: status,
                        [statusColumn]: new Date().toISOString().slice(0, 19).replace('T', ' ') // Current timestamp in MySQL format
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        console.log(response);
                        if (response.success) {
                            // Update the data in the DataTable
                            var updatedPengajuan = data.find(p => p.pengajuan_id == pengajuanId);
                            updatedPengajuan.status = status;
                            updatedPengajuan[statusColumn] = new Date().toISOString().slice(0, 19).replace('T', ' ');
                            table.clear().rows.add(data).draw();

                            // Hide the modal
                            $('#detail-modal').removeClass('flex').addClass('hidden');

                            // Remove the modal backdrop
                            $('div[modal-backdrop]').remove();

                            // Optionally show a success message
                            alert('Pengajuan updated successfully');

                            window.location.href = 'home.php';
                        } else {
                            // Handle error
                            alert('Failed to update pengajuan');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while updating pengajuan');
                    }
                });
            }

            function updatePengajuanStatusSaja(pengajuanId, status) {
                console.log("Updating pengajuan with ID: " + pengajuanId + " to status: " + status);

                $.ajax({
                    url: 'update_status_saja.php', // The URL to your server-side script that will handle the update
                    type: 'POST',
                    data: {
                        pengajuan_id: pengajuanId,
                        status: status
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        console.log(response);
                        if (response.success) {
                            // Update the data in the DataTable
                            var updatedPengajuan = data.find(p => p.pengajuan_id == pengajuanId);
                            updatedPengajuan.status = status;
                            table.clear().rows.add(data).draw();

                            // Hide the modal
                            $('#detail-modal').removeClass('flex').addClass('hidden');

                            // Remove the modal backdrop
                            $('div[modal-backdrop]').remove();

                            // Optionally show a success message
                            alert('Pengajuan updated successfully');

                            window.location.href = 'home.php';
                        } else {
                            // Handle error
                            alert('Failed to update pengajuan');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while updating pengajuan');
                    }
                });
            }

            $(document).on('click', '[data-modal-hide="detail-modal"]', function () {
                $('#detail-modal').removeClass('flex').addClass('hidden');
            });

            // Hide the notification after 5 seconds
            setTimeout(function () {
                var notification = document.getElementById('notification');
                if (notification) {
                    notification.style.display = 'none';
                }
            }, 5000);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('dropdownDefaultButton');
            const dropdownMenu = document.getElementById('dropdown');
            const selectElement = document.getElementById('statusFilter');
            const dropdownItems = dropdownMenu.querySelectorAll('a');

            dropdownButton.addEventListener('click', function () {
                dropdownMenu.classList.toggle('hidden');
            });

            dropdownItems.forEach(function (item) {
                item.addEventListener('click', function (event) {
                    event.preventDefault();
                    const value = item.getAttribute('data-value');
                    selectElement.value = value;
                    dropdownButton.textContent = item.textContent.trim();
                    dropdownMenu.classList.add('hidden');
                    // Trigger change event on the select element to update the table
                    const eventChange = new Event('change');
                    selectElement.dispatchEvent(eventChange);
                });
            });

            document.addEventListener('click', function (event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
        
        const checkbox = document.querySelector('#toggle');
        const html = document.querySelector('html');
        checkbox.addEventListener('click', function()
        {
        checkbox.checked ? html.classList.add('dark') : html.classList.remove('dark')
        })
    </script>
</body>

</html>