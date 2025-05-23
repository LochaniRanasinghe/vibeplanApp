<footer id="animated-footer" class="position-relative text-light" style="background-color: #300628; overflow: hidden;">
    <!-- Animated Background Canvas -->
    <canvas id="footerCanvas"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></canvas>

    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="row text-center text-md-start">
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold">VibePlan 🚀</h5>
                <p>&copy; {{ date('Y') }} VibePlan. All Rights Reserved.</p>
            </div>

            <div class="col-md-2 mb-4">
                <h6 class="text-uppercase fw-bold">Customers</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">Buyer</a></li>
                    <li><a href="#" class="footer-link">Supplier</a></li>
                </ul>
            </div>

            <div class="col-md-2 mb-4">
                <h6 class="text-uppercase fw-bold">Company</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">About us</a></li>
                    <li><a href="#" class="footer-link">Careers</a></li>
                    <li><a href="#" class="footer-link">Contact</a></li>
                </ul>
            </div>

            <div class="col-md-2 mb-4">
                <h6 class="text-uppercase fw-bold">Info</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">Terms & Conditions</a></li>
                    <li><a href="#" class="footer-link">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="col-md-3 text-center text-md-start mb-4">
                <h6 class="text-uppercase fw-bold">Follow Us</h6>
                <div class="d-flex justify-content-center justify-content-md-start gap-3 bounce-icons">
                    <a href="#" class="social-icon"><i class="mdi mdi-facebook fs-5"></i></a>
                    <a href="#" class="social-icon"><i class="mdi mdi-twitter fs-5"></i></a>
                    <a href="#" class="social-icon"><i class="mdi mdi-linkedin fs-5"></i></a>
                    <a href="#" class="social-icon"><i class="mdi mdi-instagram fs-5"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .footer-link {
        color: #f0f0f0;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-link:hover {
        color: #ffca28;
        text-decoration: underline;
    }

    .social-icon {
        color: #f0f0f0;
        font-size: 1.5rem;
        transition: transform 0.4s ease;
    }

    .social-icon:hover {
        transform: scale(1.3);
        color: #ffca28;
    }

    /* Floating animation for icons */
    .bounce-icons a {
        animation: float 2s ease-in-out infinite;
    }

    .bounce-icons a:nth-child(2) {
        animation-delay: 0.2s;
    }

    .bounce-icons a:nth-child(3) {
        animation-delay: 0.4s;
    }

    .bounce-icons a:nth-child(4) {
        animation-delay: 0.6s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-8px);
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('footerCanvas');
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = 250;
        }

        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const blobs = Array.from({
            length: 15
        }, () => ({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            r: Math.random() * 30 + 10,
            dx: (Math.random() - 0.5) * 2,
            dy: (Math.random() - 0.5) * 2,
            color: `rgba(${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, 200, 0.2)`
        }));

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            blobs.forEach(blob => {
                ctx.beginPath();
                ctx.arc(blob.x, blob.y, blob.r, 0, Math.PI * 2);
                ctx.fillStyle = blob.color;
                ctx.fill();
                blob.x += blob.dx;
                blob.y += blob.dy;

                // Bounce off edges
                if (blob.x + blob.r > canvas.width || blob.x - blob.r < 0) blob.dx *= -1;
                if (blob.y + blob.r > canvas.height || blob.y - blob.r < 0) blob.dy *= -1;
            });
            requestAnimationFrame(animate);
        }

        animate();
    });
</script>
