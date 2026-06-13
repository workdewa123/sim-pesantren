<!DOCTYPE html>
<html lang="en">

<!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
<head>
    <!-- Tambahkan ini sebelum </head> -->
    <style>
        #fire-background {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            background-color: rgb(255, 255, 255);
            /* Pastikan di belakang konten */
        }

        .main-content {
            position: relative;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.5);
            /* Overlay semi-transparan */
            min-height: 100vh;
            color: black;
            /* Warna teks putih */
        }

        .navbar {
            margin-left: -1/2.2%; 
            margin-right: -1/2.2%;
            position: sticky;
            background-color: rgba(27, 174, 227, 0.66) !important;
            /* Navbar lebih gelap */
        }
        
                /* Mengatur tabel */
        .table {
        border-collapse: separate; /* Penting untuk border-radius di tabel */
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 10px; /* Radius untuk sudut tabel */
        overflow: hidden; /* Memastikan radius terlihat dengan benar */
        }

        /* Mengatur thead */
        .thead {
        background-color:rgb(255, 255, 255) ; /* Warna latar thead */
        color: white; /* Warna teks thead */
        }
        /* Navbar styling */
        .navbar {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            position: sticky;
        }

        .navbar:hover {
            background-color: rgba(23, 155, 203, 0.8) !important;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.2rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .navbar-brand:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-link {
            position: relative;
            margin: 0 0.3rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: all 0.3s ease;
        }

        .nav-link:hover::after {
            width: 70%;
            left: 15%;
        }

        /* Tambahan style untuk notifikasi */
        .alert-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
            min-width: 300px;
        }

        /* Profile section */
        .navbar-nav {
            align-items: center;
        }
        .profile-container {
            display: flex;
            align-items: center;
            margin-left: 1rem;
            cursor: pointer;
            position: relative;
        }

        .profile-pic {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            min-width: 180px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .profile-container:hover .profile-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(5px);
        }
        .profile-dropdown a {
            display: block;
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .profile-dropdown a:hover {
            background-color: #f8f9fa;
            color: #1ba6e3;
        }

        .profile-name {
            margin-left: 0.5rem;
            color: white;
            font-weight: 500;
        }
         /* Modal styles */
        .modal-header {
            background-color: #1ba6e3;
            color: white;
        }
    </style>
</head>

<body>
    <div id="fire-background"></div> <!-- Background api -->
 <!--   <nav class="navbar navbar-expand-lg navbar-light bg-warning">
        <br></br>
    </nav> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info" positin="sticky-top-0">
        <div class="container-fluid">
            <a class="navbar-brand" aria-current="page" href="/home" style="color: white;">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/users"
                            style="color: white;">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/pemasukan"
                            style="color: white;">Pemasukan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/pengeluaran"
                            style="color: white;">Pengeluaran</a>
                    </li>
                    <li class="nav-item ms-auto" >
                        <div class="profile-container">
                            <span class="profile-name"></span>
                            <div class="profile-icon">
                                <i class="fa-solid fa-circle-user" style="color: white;"></i>
                            </div>
                            <div class="profile-dropdown">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="fas fa-user-edit me-2"></i> Edit Profil
                                </a>
                                <a href="/sesi/logout">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ '/users/'.Auth::user()->id }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfile">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="modal-footer">
                                <a href="#" class="btn btn-danger me-auto" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"><i class="fas fa-trash"></i> Hapus Akun</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- Confirm Delete Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ '/users/'.Auth::user()->id }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                         Apakah Anda yakin ingin menghapus akun ini? Aksi ini tidak dapat dibatalkan.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        
    <!-- Tambahkan sebelum </body> -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            particlesJS('fire-background', {
                "particles": {
                    "number": {
                        "value": 120,  // Lebih banyak partikel
                        "density": {
                            "enable": true,
                            "value_area": 500  // Lebih padat
                        }
                    },
                    "color": {
                        "value": ["#1E90FF", "#00BFFF", "#87CEFA"]  // Warna api lebih intens "#ff4500", "#ff8c00", "#ffcc00"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.8,  // Lebih opaque
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,  // Animasi lebih cepat
                            "opacity_min": 0.3,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 5,  // Ukuran lebih besar
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 3,
                            "size_min": 1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 100,  // Jarak lebih dekat
                        "color": "#ff6a00",
                        "opacity": 0.8,  // Garis lebih terlihat
                        "width": 2  // Garis lebih tebal
                    },
                    "move": {
                        "enable": true,
                        "speed": 5,  // Gerakan lebih cepat
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "repulse": {
                            "distance": 100,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 6
                        }
                    }
                },
                "retina_detect": true
            });
        });
    </script>
</body>
</div>

</html>