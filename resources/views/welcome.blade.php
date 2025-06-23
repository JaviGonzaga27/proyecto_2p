<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Plataforma moderna desarrollada con Laravel - Inicia sesión o regístrate para comenzar">
    <meta name="author" content="Tu Empresa">

    <title>{{ config('app.name', 'Laravel') }} - Bienvenido</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .bg-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 100px; height: 100px; left: 60%; animation-delay: 1s; }
        .particle:nth-child(4) { width: 40px; height: 40px; left: 80%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 120px; height: 120px; left: 70%; animation-delay: 0.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-100px) rotate(180deg); }
        }

        /* Hero section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 2rem 0;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .hero-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .brand-logo i {
            font-size: 2rem;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            background: var(--dark-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: #6c757d;
            font-weight: 400;
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        /* Custom buttons */
        .btn-custom-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 15px 40px;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-custom-outline {
            background: transparent;
            border: 2px solid;
            border-image: var(--primary-gradient) 1;
            padding: 13px 40px;
            font-weight: 600;
            border-radius: 50px;
            color: #667eea;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-custom-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-custom-outline:hover::before {
            left: 0;
        }

        .btn-custom-outline:hover {
            color: white;
            border-color: transparent;
        }

        /* Features section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .feature-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .feature-title {
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Status indicator */
        .status-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 12px 20px;
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .btn-custom-primary,
            .btn-custom-outline {
                padding: 12px 30px;
                font-size: 0.9rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background particles -->
    <div class="bg-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Hero section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="hero-card p-5 text-center">
                        <!-- Brand logo -->
                        <div class="brand-logo">
                            <i class="fas fa-rocket"></i>
                        </div>

                        <!-- Main content -->
                        <h1 class="hero-title">
                            Bienvenido a<br>
                            {{ config('app.name', 'Laravel') }}
                        </h1>

                        <p class="hero-subtitle">
                            Descubre una plataforma moderna y potente construida con Laravel.
                            Experimenta la simplicidad y elegancia en cada interacción.
                        </p>

                        <!-- Action buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-custom-primary">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Ir al Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-custom-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" class="btn-custom-outline">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Crear Cuenta
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer info -->
    <div class="position-fixed bottom-0 start-0 p-3">
        <small class="text-white-50">
            <i class="fas fa-code me-1"></i>
            Desarrollado con Laravel {{ app()->version() }}
        </small>
    </div>

    <!-- Bootstrap 5 JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Add smooth scrolling and interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate hero card on load
            const heroCard = document.querySelector('.hero-card');
            heroCard.style.opacity = '0';
            heroCard.style.transform = 'translateY(30px)';

            setTimeout(() => {
                heroCard.style.transition = 'all 0.6s ease';
                heroCard.style.opacity = '1';
                heroCard.style.transform = 'translateY(0)';
            }, 200);

            // Add parallax effect to particles
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const particles = document.querySelectorAll('.particle');

                particles.forEach((particle, index) => {
                    const speed = 0.5 + (index * 0.1);
                    particle.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });

            // Button hover effects
            const buttons = document.querySelectorAll('.btn-custom-primary, .btn-custom-outline');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
