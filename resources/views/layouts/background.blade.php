<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        #fire-background {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            background-color: #000000;
            pointer-events: none;
        }

        /* Canvas particles.js tetap bisa menerima event mouse
           detect_on: "window" di config JS sudah cukup menangani interaktivitas
           tanpa perlu canvas berada di z-index tinggi */
        #fire-background canvas {
            pointer-events: auto !important;
        }
    </style>
</head>

<body>
    <div id="fire-background"></div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            particlesJS('fire-background', {
                "particles": {
                    "number": {
                        "value": 120,
                        "density": {
                            "enable": true,
                            "value_area": 500
                        }
                    },
                    "color": {
                        "value": ["#22d3ee", "#38bdf8", "#0ea5e9"]
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.8,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.3,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 5,
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
                        "distance": 100,
                        "color": "#0ea5e9",
                        "opacity": 0.4,
                        "width": 1.5
                    },
                    "move": {
                        "enable": true,
                        "speed": 4,
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
                    "detect_on": "window",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": false,
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


</html>