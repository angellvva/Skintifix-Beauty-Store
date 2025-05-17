@extends ('base.base')

@section('content')
    <style>
        .contact-section {
            background-color: #fff0f5;
        }

        .contact-title {
            color: #e965a7;
            font-weight: bold;
        }

        .contact-form .form-control:focus {
            border-color: #e965a7;
            box-shadow: 0 0 0 0.2rem rgba(233, 101, 167, 0.25);
        }

        .contact-form .btn-submit {
            border: 2px solid #e965a7;
            color: #e965a7;
            transition: all 0.3s ease;
        }

        .contact-form .btn-submit:hover {
            background-color: #e965a7;
            color: #fff;
        }

        .contact-icon i {
            color: #e965a7;
        }

        .info-box {
            background: #fff;
            border-left: 4px solid #e965a7;
        }
    </style>

    <div class="contact-section">
        <div class="container py-5">
            <div class="p-5 bg-white shadow-sm" style="border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div class="row g-4">
                    <div class="col-12 text-center">
                        <h1 class="contact-title">Get in Touch with Skintifix</h1>
                        <p class="text-muted mb-4">We're here to answer any questions about skincare, product details, or
                            collaborations!</p>
                    </div>

                    <div class="col-lg-12">
                        <iframe class="rounded w-100 mb-5" height="400"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.706539781523!2d112.63062847453974!3d-7.273698771968859!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fde455555555%3A0xd7e2611ae591f046!2sUniversitas%20Ciputra!5e0!3m2!1sen!2sid!4v1717921211569!5m2!1sen!2sid"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <div class="col-lg-7">
                        @if (session('success'))
                            <div class="alert alert-success mt-4" id="success-message">
                                {{ session('success') }}
                            </div>
                        @elseif($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $e)
                                    {{ $e }} <br>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact') }}" class="contact-form">
                            @csrf
                            <input type="text" name="name" class="form-control py-3 mb-4" placeholder="Your Name"
                                required>
                            <input type="email" name="email" class="form-control py-3 mb-4" placeholder="Your Email"
                                required>
                            <textarea name="message" class="form-control mb-4" rows="5" placeholder="Your Message" required></textarea>
                            <button type="submit" class="btn btn-submit w-100 py-3">Send Message</button>
                        </form>
                    </div>

                    <div class="col-lg-5">
                        <div class="info-box d-flex p-4 mb-3 align-items-center">
                            <div class="contact-icon me-4">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Address</h5>
                                <p class="mb-0">Universitas Ciputra, Surabaya, IDN</p>
                            </div>
                        </div>

                        <div class="info-box d-flex p-4 mb-3 align-items-center">
                            <div class="contact-icon me-4">
                                <i class="fas fa-envelope fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p class="mb-0">skintificbeautystore@gmail.com</p>
                            </div>
                        </div>

                        <div class="info-box d-flex p-4 align-items-center">
                            <div class="contact-icon me-4">
                                <i class="fas fa-phone fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Phone</h5>
                                <p class="mb-0">+62 812 3456 7890</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 500); // Fade-out duration
            }, 3000); // 3 seconds display time
        }
    });
</script>
@endsection
