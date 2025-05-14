@extends("layouts.app")
@section("title", "About Us - Kalan Archive")
@section("styles")
    <style>
        .about-section {
            padding: 4rem 0;
            background-color: var(--container-color);
        }
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .about-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .about-header h1 {
            color: var(--title-color);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        .about-text {
            color: var(--text-color);
        }
        .about-text p {
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        .about-text h2 {
            color: var(--title-color);
            margin-bottom: 1rem;
        }
        .about-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .feature-item i {
            font-size: 1.5rem;
            color: var(--first-color);
        }
        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        .contact-info {
            margin-top: 2rem;
            padding: 2rem;
            background-color: var(--body-color);
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .contact-info h3 {
            color: var(--title-color);
            margin-bottom: 1rem;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }
        .contact-item i {
            font-size: 1.2rem;
            color: var(--first-color);
        }
        @media (max-width: 768px) {
            .about-content {
                grid-template-columns: 1fr;
            }
            .about-features {
                grid-template-columns: 1fr;
            }
            .map-container {
                height: 300px;
            }
        }
    </style>
@endsection
@section("content")
    <section class="about-section">
        <div class="about-container">
            <div class="about-header">
                <h1>About Kalan Archive</h1>
                <p>Your Premier Destination for Quality Books in Abidjan</p>
            </div>

            <div class="about-content">
                <div class="about-text">
                    <h2>Our Story</h2>
                    <p>Founded in 2024, Kalan Archive has been at the forefront of providing quality books to the people of Abidjan. We believe in making knowledge accessible to everyone, offering both physical books and e-books to cater to different reading preferences.</p>

                    <h2>Our Mission</h2>
                    <p>We strive to be the leading bookstore in Abidjan, providing a wide range of books at affordable prices. Our commitment to quality and customer satisfaction has made us a trusted name in the literary community.</p>

                    <div class="about-features">
                        <div class="feature-item">
                            <i class='bx bx-book-reader'></i>
                            <span>Wide Collection of Books</span>
                        </div>
                        <div class="feature-item">
                            <i class='bx bx-time'></i>
                            <span>24/7 Online Access</span>
                        </div>
                        <div class="feature-item">
                        <i class="ri-truck-line"></i>
                            <span>Fast Delivery</span>
                        </div>
                        <div class="feature-item">
                            <i class='bx bx-support'></i>
                            <span>Customer Support</span>
                        </div>
                    </div>
                </div>

                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3970.0!2d-3.996!3d5.406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xe32a9ad62337c7d%3A0x4c909e96df251e48!2s5%C2%B024%2721.9%22N%203%C2%B059%2745.6%22W!5e0!3m2!1sen!2s!4v1648123456789!5m2!1sen!2s"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <div class="contact-info">
                <h3>Visit Our Store</h3>
                <div class="contact-item">
                    <i class='bx bx-map'></i>
                    <span>Cité Angré les Oscars, Abidjan, Abidjan, Côte d'Ivoire</span>
                </div>
                <div class="contact-item">
                    <i class='bx bx-phone'></i>
                    <span>+225 07 07 07 07 07</span>
                </div>
                <div class="contact-item">
                    <i class='bx bx-envelope'></i>
                    <span>contact@kalanarchive.com</span>
                </div>
                <div class="contact-item">
                    <i class='bx bx-time'></i>
                    <span>Monday - Saturday: 8:00 AM - 8:00 PM</span>
                </div>
            </div>
        </div>
    </section>
@endsection
